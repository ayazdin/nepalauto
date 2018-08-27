<?php

namespace App\Http\Controllers\Posts;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Posts;
use App\Models\Postmeta;
use App\Models\Postcat;
use DB;
use Illuminate\Support\Facades\Auth;

class EpaperController extends Controller
{
    //
    public function indexEpaper($id=""){
        $epapers = Posts::where('ctype', '=', 'epaper')
                    ->orderBy('updated_at', 'DESC')->paginate(25);

        if($id!=''){
            $editepaper = Posts::where('id', $id)->first();
            return view('admin.epaper.index')->with('epapers',$epapers)
                                             ->with('editepaper',$editepaper)   ;
        }

        return view('admin.epaper.index')->with('epapers',$epapers);
    }


    public function storeEpaper(Request $request){
    //dd($request);
        if(Auth::check())
            $user = Auth::user();

        if($request['epaperid']!="")
            $post = Posts::where('id', $request['epaperid'])->first();
        else
            $post = new Posts();

        $post->title = $request['title'];
        if(empty($request['slug']))
            $slug = $this->generateSeoURL($request['title']);
        else
            $slug = $request['slug'];

        $post->clean_url = $this->getUniqueSlug($slug, $post->id);
        $post->image = $request['filepath'];
        $post->ctype = 'epaper';
        $post->userid = $user->id;

        //dd($request['epaper_month']);
        if($request['epaperid']!="")
        {
            $post->update();
            $request->session()->flash('succ', 'One item updated successfully!!!');
        }
        else
        {
            $post->save();
            $request->session()->flash('succ', 'One item added successfully!!!');
        }

        $this->addAttributes('epaper_month', $request['epaper_month'], $post->id);
        $this->addAttributes('epaper_year', $request['epaper_year'], $post->id);
        $this->addAttributes('epaper_pdf', $request['filepath2'], $post->id);


        return back();

    }

    public function deleteEpaper($id){
        Postmeta::where('postid', $id)->delete();
        Posts::destroy($id);
        return redirect('/admin/e-paper')->with('succ', 'One item deleted');
    }

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
        //dd($postMeta);
        if(!empty($hasAtt))
            $postMeta->update();
        else
            $postMeta->save();

        //}
    }

}
