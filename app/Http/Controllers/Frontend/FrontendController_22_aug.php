<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Posts;
use App\Models\Postcat;
use App\Models\Postmeta;
use App\Models\Cat_relation;
use App\Models\Subscriber;
use App\Models\Autobrands;
use DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NepaliCalenderController;


use Illuminate\Support\Facades\Auth;
use Mail;
use Response;

class FrontendController extends Controller
{
    public function getHomePage(Request $request)
    {
            $s = $request->input('s');
            if(!empty($s)){
                $title = $s;
                $results = Posts::where('title', 'LIKE', '%' . $s . '%')
                            ->orWhere('content', 'LIKE', '%' . $s . '%')
                    ->paginate(24);
                $results->appends(['s' => $s]);
                return view('frontend.search')->with('title',$title)
                                                ->with('results',$results);
            }

            $posts = Posts::where('ctype', '=', 'post')
							->where('status', '=', 'publish')
                          ->orderBy('created_at', 'DESC')->limit(3)->get();
            $featuredNews = Posts::where('ctype','=','post')
                          ->where('status','=','publish')
                          ->orderBy('created_at', 'DESC')
                          ->offset(3)
                          ->limit(6)
                          ->get();


            /*$featuredNews =  DB::table('posts')
                    ->join('postmetas', 'postmetas.postid', '=', 'posts.id')
                    ->where('postmetas.meta_key', '=', 'featured_news')
                    ->where('postmetas.meta_value', '=', 'yes')
                    ->select('posts.*')
                    ->limit(6)
                    ->get();*/


            $others = Posts::where('ctype','=','post')
                            ->where('status','=','publish')
                            ->orderBy('created_at', 'DESC')
                            ->offset(9)
                            ->limit(6)
                            ->get();

            $nadas = DB::table('posts')
                    ->join('cat_relations', 'cat_relations.postid', '=', 'posts.id')
                    ->join('postcats', 'postcats.id', '=', 'cat_relations.catid')
                    ->where('postcats.slug', '=', 'nada')
                    ->select('posts.*')
                    ->orderby('created_at','DESC')
                    ->limit(6)
                            ->get();;

        	return view('frontend.home')->with('posts', $posts)
                                        ->with('others', $others)
                                        ->with('featuredNews', $featuredNews)
                                        ->with('nadas', $nadas)
                                        ->with('mediumrectangle',
                                            DB::table('posts')
                                                ->join('cat_relations', 'cat_relations.postid', '=', 'posts.id')
                                                ->join('postcats', 'postcats.id', '=', 'cat_relations.catid')
                                                ->where('postcats.slug', '=', 'medium-rectangle')
                                                ->select('posts.*')
                                                ->get());

    }

    public function singlepage($slug){
        //echo $slug ; die();

        //$newslug = $this->convertUtf8($slug);

        $post = Posts::where('clean_url', $slug)->first();
        $postId = $post->id;
        $postmeta = Postmeta::where('postid', $postId)->get();
        $category = Cat_relation::where('postid',$postId)->first();

        $ads = DB::table('posts')
                        ->join('cat_relations', 'cat_relations.postid', '=', 'posts.id')
                        ->join('postcats', 'postcats.id', '=', 'cat_relations.catid')
                        ->where('postcats.slug', '=', 'post-bottom')
                        ->select('posts.*')
                        ->limit(2)
                        ->get();


        $year = $post->created_at->year;
        $month = $post->created_at->month;
        $day = $post->created_at->day;

        $nepaliDate = new NepaliCalenderController();
        $date = $nepaliDate->engToNep($year, $month, $day);
        //dd($date);

        if(!empty($category)){
            $catId = $category->catid;
            $relatedposts = DB::table('posts')
                        ->join('cat_relations', 'cat_relations.postid', '=', 'posts.id')
                        ->join('postcats', 'postcats.id', '=', 'cat_relations.catid')
                        ->where('posts.id', '!=', $postId)
                        ->where('postcats.id', '=', $catId)
                        ->select('posts.*')
                        ->limit(3)
                        ->get();
             return view('frontend.singlenews')->with('post',$post)
                                               ->with('postmeta',$postmeta)
                                               ->with('relatedposts',$relatedposts)
                                               ->with('ads',$ads)
                                               ->with('date',$date);
        }

         return view('frontend.singlenpage')->with('post',$post)
                                           ->with('postmeta',$postmeta)
                                           ->with('ads',$ads)
                                           ->with('date',$date);


    }


    public function subscriber(Request $request){
        echo $email = $request->subsEmail;


        $checksubs = Subscriber::where('emailid', $email)->first();

        if(!empty($checksubs)){
            return back()->with('subsucc', 'Already subscribed');
        }
        else{
            $sub = new Subscriber();
            $sub->emailid = $email;
            $sub->save();

            return back()->with('subsucc', 'Thank you for subscribing Nepal Auto');
        }


    }

    public function category($slug){
        $category = Postcat::where('slug',$slug)->first();
        $title = $category->name;

        if($slug=='automobile'){
          $catproducts = DB::table('posts')
                ->join('cat_relations', 'cat_relations.postid', '=', 'posts.id')
                ->join('postcats', 'postcats.id', '=', 'cat_relations.catid')
                ->where('postcats.slug', '=', $slug)
                ->orwhere('postcats.slug', '=', 'vehicle')
                ->select('posts.*')
                ->orderby('created_at','DESC')
                ->paginate(24);
        }
        else{
          $catproducts = DB::table('posts')
                ->join('cat_relations', 'cat_relations.postid', '=', 'posts.id')
                ->join('postcats', 'postcats.id', '=', 'cat_relations.catid')
                ->where('postcats.slug', '=', $slug)
                ->select('posts.*')
                ->orderby('created_at','DESC')
                ->paginate(24);
        }

            
            return view('frontend.category')->with('title',$title)
                ->with('catproducts',$catproducts);
    }


    public function loadajax(Request $request){
        $output = '';
        $id = $request->id;

        $others = Posts::where('ctype','=','post')
                        ->where('status','=','publish')
                        ->where('id','>',$id)
                        ->orderBy('created_at', 'DESC')
                        ->limit(2)
                        ->get();

        if(!$others->isEmpty())
        {
            foreach($others as $order)
            {
                $url = url($order->clean_url);
                if(!empty($order->image))
                    $orderimage = $order->image;
                else
                    $orderimage = 'frontend/images/image-not-found.png';

                $image = url($orderimage);
                $title = $order->title;

                $output .='<div class="col-sm-6">
                                <div class="wrap o-hight">
                                    <div class="o-left">
                                        <a href="'.$url.'" title="'.$order->title.'">
                                            <div class="ima" style="background-image:url('.$image.')"></div>
                                        </a>
                                    </div>
                                    <div class="o-right">
                                        <h3><a href="'.$url.'" title="'.$order->title.'">'.$title.'</a></h3>
                                        <p>'.str_limit($order->excerpt,80).'</p>

                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </div>';

            }

            $output .= '<div id="remove-row" class="col-sm-12">
                            <button id="btn-more" data-id="'.$order->id.'" class="btn btn-more" > Load More </button>
                        </div>';

            echo $output;

        }
    }


    public function contactpage(){
      return view('frontend.contact-page');
    }

    public function contactsend(Request $request){
        //dd($request);
        $admin = DB::table('users')
                            ->where('id','=',1)->first();
        $adminEmail = $admin->email;


        $data = array(
            'fullname'  => $request['fullname'],
            'emailid'   =>  $request['emailid'],
            'bodyMessage'   =>  $request['message']
        );

        Mail::send('emails.contact',$data,function($message) use($data){
            $message->from($data['emailid']);
            $message->to('binaya619@gmail.com');
        });

        return redirect()->url('/contact');
    }

    public function searchpricelist(){
       $brand = Input::get('company');
       $keyword = Input::get('keywords');

       if($brand!="" and $keyword!="")
       {
       $products = DB::table('posts')
          ->where('ctype', '=', 'price')
          ->where(function ($query) use($keyword){
            $query->where('title', 'like', '%'.$keyword.'%')
                  ->orWhere('content', 'like', '%'.$keyword.'%')
                  ->orWhere('excerpt', 'like', '%'.$keyword.'%');
          })
          ->join('postmetas', function($q) use ($brand){
            if($brand!="")
              $q->on('posts.id', '=', 'postmetas.postid')
              ->where('postmetas.meta_key', '=', 'brand')
              ->where('postmetas.meta_value', '=', $brand);
            else
              $q->on('posts.id', '=', 'postmetas.postid');
            }
          )
          ->select('posts.*', 'postmetas.meta_value')
          ->orderBy('posts.id','DESC')
          ->paginate(25);
        }
        if($brand=="" and $keyword!="")
        {
        $products = DB::table('posts')
           ->where('ctype', '=', 'price')
           ->where(function ($query) use($keyword){
             $query->where('title', 'like', '%'.$keyword.'%')
                   ->orWhere('content', 'like', '%'.$keyword.'%')
                   ->orWhere('excerpt', 'like', '%'.$keyword.'%');
           })
           ->select('posts.*')
           ->orderBy('posts.id','DESC')
           ->paginate(25);
         }
         if($brand!="" and $keyword=="")
         {
           $products = DB::table('posts')
              ->where('ctype', '=', 'price')
              ->join('postmetas', function($q) use ($brand){
                if($brand!="")
                  $q->on('posts.id', '=', 'postmetas.postid')
                  ->where('postmetas.meta_key', '=', 'brand')
                  ->where('postmetas.meta_value', '=', $brand);
                else
                  $q->on('posts.id', '=', 'postmetas.postid');
                }
              )
              ->select('posts.*', 'postmetas.meta_value')
              ->orderBy('posts.id','DESC')
              ->paginate(25);
         }

        return view('frontend.pricelist',compact('company','keywords'))
                                        ->with('company',$brand)
                                        ->with('keywords',$keyword)
                                        ->with('products',$products);

    }


    public function pricelist($slug=''){
        if($slug==''){
            $title = 'Price list';
            $autobrands = Autobrands::where('status', '=', 'publish')->get();
            return view('frontend.cat-price-list')->with('title',$title)
                                                    ->with('autobrands',$autobrands);
        }
        else{

            $autobrand = Autobrands::where('slug',$slug)->first();

            //dd($autobrand);
            $title = $autobrand->title;

            $products =  DB::table('posts')
                ->join('postmetas', 'postmetas.postid', '=', 'posts.id')
                ->where('postmetas.meta_key', '=', 'brand')
                ->where('postmetas.meta_value', '=', $autobrand->id)
                ->select('posts.*')
                ->paginate(24);

            return view('frontend.single-brand')->with('title',$title)
                                                ->with('products',$products);
        }
    }

    public function pricelistDetail($slug){
            $post = Posts::where('clean_url', $slug)->first();
            $postId = $post->id;

            $ads = DB::table('posts')
                        ->join('cat_relations', 'cat_relations.postid', '=', 'posts.id')
                        ->join('postcats', 'postcats.id', '=', 'cat_relations.catid')
                        ->where('postcats.slug', '=', 'post-bottom')
                        ->select('posts.*')
                        ->limit(2)
                        ->get();

            $postmeta = Postmeta::where('postid', $postId)->get();
                return view('frontend.pricelistdetail')->with('post',$post)
                                               ->with('postmeta',$postmeta)
                                               ->with('ads',$ads);


    }

    /*
    *Epaper section
    */

        public static function getEpaperMetas($id){
            $metas = array();
               $epaperMetas = Postmeta::where('postid', $id)->get();
               foreach ($epaperMetas as $epaperMetas) {
                    if($epaperMetas->meta_key=='epaper_month')
                        $metas['month'] = $epaperMetas->meta_value;
                    if($epaperMetas->meta_key=='epaper_year')
                        $metas['years'] = $epaperMetas->meta_value;
                    if($epaperMetas->meta_key=='epaper_pdf')
                        $metas['file'] = $epaperMetas->meta_value;
               }
            return $metas;
        }

        public function pdfstream($slug){
            $post = Posts::where('clean_url', $slug)->first();
                $postId = $post->id;
                $postmeta = Postmeta::where('postid', $postId)->get();

                foreach ($postmeta as $pm) {
                   if($pm->meta_key=='epaper_pdf')
                       $file = $pm->meta_value;
                }
                    $file;
                  $path = url($file);
            return Response::make(file_get_contents($path), 200, [
                'Content-Type' => 'application/pdf',
                //'Content-Disposition' => 'inline; filename="'.$file.'"'
            ]);
        }

        public function listepaper()
        {
            $allepaper = Posts::where('ctype', '=', 'epaper')
                    ->orderBy('created_at', 'ASC')
                    ->get();
            return view('frontend.epaper-list')->with('allepaper',$allepaper);
        }
    /*
    *Epaper section
    */


}
