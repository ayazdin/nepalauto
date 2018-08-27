<?php

namespace App\Http\Controllers\Posts;

use App\Models\Posts;
use App\Models\Postcat;
use App\Models\Postmeta;
use App\Models\Cat_relation;
use DB;
use App\Http\Controllers\Posts\PostCatController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexPosts()
    {
      $posts = Posts::where('ctype', '=', 'post')
                          ->orderBy('updated_at', 'DESC')->paginate(25);
      return view('admin.posts.posts')->with('posts', $posts);
    }

    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexCategory($id='')
    {
      $postcat="";
      $catCtrl = new PostCatController();
      $postcat = $catCtrl->getCategoryList();

      if($id!="")
      {
        $editcat = Postcat::where('id', $id)->first();
        return view('admin.category.add-category')->with('postcat', $postcat)
                                                    ->with('editcat', $editcat)
                                                    ->with('categoryType', 'category');
      }
      //return "we are here";
      return view('admin.category.add-category')->with('postcat', $postcat)
                                                  ->with('categoryType', 'category');
    }

    /**
     * Show the form for creating a new Products.
     *
     * @return \Illuminate\Http\Response
     */
    public function createPosts($id="")
    {
        $catCtrl = new PostCatController();

        if($id!="")
        {
          $catrel = Cat_relation::where('postid','=', $id)->get();
          if($catrel->isNotEmpty())
          {
            foreach($catrel as $cr)
            {
                $sel[]=$cr->catid;
            }
          }
          $ddlCat = $catCtrl->getCategoryList('li', $sel);
          $post = Posts::where('id', $id)->first();
          //print_r($post->postmeta);
          return view('admin.posts.add-posts')->with('ddlCat', $ddlCat)
                                                      ->with('post', $post);
        }
        else {
          $ddlCat = $catCtrl->getCategoryList('li');
        }
        return view('admin.posts.add-posts')->with('ddlCat', $ddlCat);
    }

    /**
     * Show the form for creating a new Category for home page sliders.
     *
     * @return \Illuminate\Http\Response
     */
    public function createHomeCategory($id='')
    {
        $hSlider = Posts::where('ctype', '=', 'home')
                            ->orderBy('menu_order', 'ASC')
                            ->paginate(25);

        if($id!="")
        {
          $editSlider = Posts::where('id', $id)->first();
          return view('yala-admin.posts.add-home-slider')->with('slider', $hSlider)
                                                      ->with('editslider', $editSlider)
                                                      ->with('cType', 'home');
        }
        return view('yala-admin.posts.add-home-slider')->with('slider', $hSlider)
                                                    ->with('cType', 'home');
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //$pc = new PostsController();
      try{
          if(Auth::check())
              $user = Auth::user();
          if($request['postid']!="")
            $posts = Posts::where('id', $request['postid'])->first();
          else
            $posts = new Posts();

          $posts->title = $request['prodTitle'];
          if(empty($request['prodSlug']))
            $posts->clean_url = $this->generateSeoURL($request['prodTitle']);
          else
            $posts->clean_url = $request['prodSlug'];

          if($request['description']!="")
            $posts->content = $request['description'];
          if($request['excerpt']!="")
            $posts->excerpt = $request['excerpt'];

          $posts->status = $request['rdoPublish'];
          $posts->ctype = $request['ctype'];
          $posts->userid = $user->id;
          if($request['featuredimage']!="")
            $posts->image = $request['featuredimage'];

          if($request['postid']!="")
            $posts->update();
          else
            $posts->save();
          if(!empty($request['category']))
            $this->addCategoryRelation($request['category'], $posts->id);
          $this->addAttributes('keywords', $request['keywords'], $posts->id);
          $this->addAttributes('metadesc', $request['metadesc'], $posts->id);
          //$this->addAttributes('author_post', $request['author_post'], $posts->id);
      }
      catch ( Illuminate\Database\QueryException $e) {
          var_dump($e->errorInfo);
          $request->session()->flash('fail', 'Due to some technical issues the request cannot be done!!!');
      }
      if($request['postid']!="")
        $request->session()->flash('succ', 'One item updated successfully!!!');
      else
        $request->session()->flash('succ', 'One item added successfully!!!');
      return back();
    }

    /**
     * Store a newly created category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeCategory(Request $request)
    {
      try {
        if($request['catid']!="")
          $postcat = Postcat::where('id', $request['catid'])->first();
        else
          $postcat = new Postcat();

        $postcat->name = $request['catName'];
        if(empty($request['slug']))
          $slug = $this->generateSeoURL($request['catName']);
        else
          $slug = $request['slug'];
        if(!empty($request['categoryType']))
          $postcat->type = $request['categoryType'];
        else
          $postcat->type = 'category';
        $postcat->slug = $this->getUniqueSlug($slug, $postcat->id);
        $postcat->parent = $request['subCat'];
        $postcat->image = $request['filepath'];
        //echo $postcat->slug;exit;
        if($request['catid']!="")
        {
            $postcat->update();
    				$request->session()->flash('succ', 'One item updated successfully!!!');
    		}
    		else
    		{
    				$postcat->save();
    				$request->session()->flash('succ', 'One item added successfully!!!');
    		}

      } catch ( Illuminate\Database\QueryException $e) {
          var_dump($e->errorInfo);
          $request->session()->flash('fail', 'Due to some technical issues the request cannot be done!!!');
      }
      return redirect('/admin/post/category/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyPost($id)
    {
      try {
          Cat_relation::where('postid', $id)->delete();
          Postmeta::where('postid', $id)->delete();
          Posts::destroy($id);
      } catch ( Illuminate\Database\QueryException $e) {
          var_dump($e->errorInfo);
      }
      return back()->with('succ', 'One item deleted');
    }

    /**
     * Remove the specified category from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyCategory($id)
    {
      try {
          Cat_relation::where('catid', $id)->delete();
          Postcat::destroy($id);
      } catch ( Illuminate\Database\QueryException $e) {
          var_dump($e->errorInfo);
      }
      return back()->with('succ', 'One item deleted');
    }


    /* --------------------------- Page controller --------------------------*/
    public function generateSeoURL($string, $wordLimit = 0)
		{
		    $separator = '-';

		    if($wordLimit != 0){
		        $wordArr = explode(' ', $string);
		        $string = implode(' ', array_slice($wordArr, 0, $wordLimit));
		    }

		    $quoteSeparator = preg_quote($separator, '#');

		    $trans = array(
		        '&.+?;'                    => '',
		        '[^\w\d _-]'            => '',
		        '\s+'                    => $separator,
		        '('.$quoteSeparator.')+'=> $separator
		    );

		    $string = strip_tags($string);
		    foreach ($trans as $key => $val){
		        //$string = preg_replace('#'.$key.'#i'.(UTF8_ENABLED ? 'u' : ''), $val, $string);
						$string = preg_replace('#'.$key.'#i', $val, $string);
		    }

		    $string = strtolower($string);

		    return trim(trim($string, $separator));
		}

    public function getUniqueSlug($s, $catid="")
    {
      if($catid!="")
        $postcat = Postcat::where('slug', $s)
                            ->where('id', '<>', $catid)
                            ->first();
      else
        $postcat = Postcat::where('slug', $s)->first();
      if(!empty($postcat))
        return $postcat->slug."-".date('md');
      else
        return $s;
    }

    public function addAttributes($metaKey, $metaValue, $postid)
    {
      if($metaValue=="")
        $metaValue="";
      //{
        $hasAtt = Postmeta::where('postid', $postid)
                              ->where('meta_key', '=', $metaKey)->first();
        if(!empty($hasAtt))
          $postMeta = Postmeta::where('postid', $postid)
                              ->where('meta_key', '=', $metaKey)->first();
        else
          $postMeta = new Postmeta();
        $postMeta->postid = $postid;
        $postMeta->meta_key = $metaKey;
        $postMeta->meta_value = $metaValue;
        if(!empty($hasAtt))
          $postMeta->update();
        else
          $postMeta->save();

      //}
    }

    public function getMetaValue($metakey, $postid)
    {
      if($metakey!="" and $postid!="")
      {
        $metavalue = Postmeta::where('postid', '=', $postid)
                                ->where('meta_key', '=', $metakey)->first();
        if(!empty($metavalue))
          return $metavalue->meta_value;
      }
        return "";
    }

    public function getCategoryName($slug="", $id="")
    {
      if($slug!="")
      {
        $catName = Postcat::where('slug', '=', $slug)->first();
        return $catName->name;
      }
      elseif($id!="")
      {
        $catName = Postcat::where('id', '=', $id)->first();
        return $catName->name;
      }
      else
        return "";
    }

    public function getSubCategory($id, $isa)
    {
      $cats = Postcat::where('parent', '=', $id)->get();
      if($isa==true)
        return response()->json(['response' => 'This is post method']);
      else
        return $cats;
    }

    public function addCategoryRelation($categories, $postid)
    {
      //print_r($categories);exit;
      if(!empty($categories))
      {
        $cr = new Cat_relation();
        $cr->where('postid', $postid)->delete();

        foreach($categories as $c)
        {
          $crs = new Cat_relation();
          $crs->postid = $postid;
          $crs->catid = $c;
          $crs->save();
        }
      }
    }

    public function getPostsByType($type="product", $paging=false)
    {
      if($paging==true)
        $posts = Posts::where('ctype', '=', $type)->paginate(25);
      else
        $posts = Posts::where('ctype', '=', $type)->get();
      return $posts;
    }

    public function getPostByField($fieldName, $fieldValue, $operator='=')
    {
      $post = Posts::where($fieldName, $operator, $fieldValue)->get();
      return $post;
    }

    public function getThumbnail($image)
    {
      return substr_replace($image, '/thumbs/', strrpos($image, "/"), 0);
    }




    /* methods for ads  starts */

    public function listAds()
    {
      $posts = Posts::where('ctype', '=', 'ads')
                          ->orderBy('updated_at', 'DESC')->paginate(25);
      return view('admin.ads.ads')->with('posts', $posts);
    }

    public function createAds($id="")
    {
      $catCtrl = new PostCatController();

      //$position  = Postcat::where('type','=', 'ads')->orderBy('catorder', 'ASC')->get();
      if($id!="")
      {
        $sel="";
        $catrel = Cat_relation::where('postid','=', $id)->get();
        if($catrel->isNotEmpty())
        {
          foreach($catrel as $cr)
          {
              $sel[]=$cr->catid;
          }
        }
        $ddlCat = $catCtrl->getCategoryList('li', $sel, 'ads');
        $ads = Posts::where('ctype', '=', 'ads')
                        ->where('id', '=', $id)
                        ->first();
        return view('admin.ads.add-ads')->with('ddlCat', $ddlCat)
                                          ->with('post', $ads);
      }
      else {
        $ddlCat = $catCtrl->getCategoryList('li', '', 'ads');
      }
      return view('admin.ads.add-ads')->with('ddlCat', $ddlCat);
    }

    public function storeAds(Request $request)
    {
      try{
          if(Auth::check())
              $user = Auth::user();
          if($request['postid']!="")
            $posts = Posts::where('id', $request['postid'])->first();
          else
            $posts = new Posts();

          $posts->title = $request['prodTitle'];
          if(empty($request['prodSlug']))
            $posts->clean_url = $this->generateSeoURL($request['prodTitle']);
          else
            $posts->clean_url = $request['prodSlug'];

          if($request['description']!="")
            $posts->content = $request['description'];

          $posts->status = $request['rdoPublish'];
          $posts->ctype = $request['ctype'];
          $posts->userid = $user->id;
          if($request['featuredimage']!="")
            $posts->image = $request['featuredimage'];

          if($request['postid']!="")
            $posts->update();
          else
            $posts->save();
          if(!empty($request['category']))
            $this->addCategoryRelation($request['category'], $posts->id);
          $this->addAttributes('startdate', $request['startDate'], $posts->id);
          $this->addAttributes('enddate', $request['endDate'], $posts->id);
          //$this->addAttributes('author_post', $request['author_post'], $posts->id);
      }
      catch ( Illuminate\Database\QueryException $e) {
          var_dump($e->errorInfo);
          $request->session()->flash('fail', 'Due to some technical issues the request cannot be done!!!');
      }
      if($request['postid']!="")
        $request->session()->flash('succ', 'One item updated successfully!!!');
      else
      {
        $request->session()->flash('succ', 'One item added successfully!!!');
        return redirect('/admin/ads/edit/'.$posts->id);
      }
      return back();
    }

    /**
     * Store a newly created advertisement in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function adsPosition($id="")
    {
      $postcat  = Postcat::where('type','=', 'ads')->orderBy('catorder', 'ASC')->paginate(25);
      if($id!="")
      {
        $position = Postcat::where('type','=', 'ads')
                              ->where('id', '=', $id)->first();
        return view('admin.ads.ads-position')->with('position', $position)
                                          ->with('postcat', $postcat);
      }
      return view('admin.ads.ads-position')->with('postcat', $postcat);
    }

    /**
     * Store a newly created advertisement in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storePosition(Request $request)
    {
      try {
        if($request['catid']!="")
          $postcat = Postcat::where('id', $request['catid'])->first();
        else
          $postcat = new Postcat();

        $postcat->name = $request['catName'];
        if(empty($request['slug']))
          $slug = $this->generateSeoURL($request['catName']);
        else
          $slug = $request['slug'];
        if(!empty($request['categoryType']))
          $postcat->type = $request['categoryType'];
        else
          $postcat->type = 'category';
        $postcat->slug = $this->getUniqueSlug($slug, $postcat->id);
        if($request['catid']!="")
        {
            $postcat->update();
    				$request->session()->flash('succ', 'One item updated successfully!!!');
    		}
    		else
    		{
    				$postcat->save();
    				$request->session()->flash('succ', 'One item added successfully!!!');
    		}

      } catch ( Illuminate\Database\QueryException $e) {
          var_dump($e->errorInfo);
          $request->session()->flash('fail', 'Due to some technical issues the request cannot be done!!!');
      }
      return back();
    }

    public function adsDelete($id)
    {
      try {
          Cat_relation::where('postid', $id)->delete();
          Posts::where('id', $id)->delete();
      } catch ( Illuminate\Database\QueryException $e) {
          var_dump($e->errorInfo);
      }
      return back()->with('succ', 'One item deleted');
    }

    public function deletePosition($id)
    {
      try {
          Cat_relation::where('catid', $id)->delete();
          Postcat::where('id', $id)->delete();
      } catch ( Illuminate\Database\QueryException $e) {
          var_dump($e->errorInfo);
      }
      return back()->with('succ', 'One item deleted');
    }

    /* methods for ads  ends */

}
