<?php

namespace App\Http\Controllers\Posts;

use App\Models\Posts;
use App\Models\Postcat;
use App\Models\Postmeta;
use App\Models\Cat_relation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostCatController extends Controller
{
  public function getCategoryList($list="", $sel="", $ctype="")
  {
    $categories=array();
    $parents = $this->getParent($ctype);
    foreach($parents as $p)
    {
      $prod_sel='';
      if(is_array($sel) and in_array($p->id, $sel ))
          $prod_sel='selected';
      elseif($sel==$p->id)
        $prod_sel=='selected';
      $subCat = $this->hasChild($p->id, $sel);
      if($subCat!==false)
        $categories[] = array('id' => $p->id, 'name' => $p->name, 'slug' => $p->slug, 'image' => $p->image, 'selected' => $prod_sel,  'subcategory' => $subCat);
      else
        $categories[] = array('id' => $p->id, 'name' => $p->name, 'slug' => $p->slug, 'image' => $p->image, 'selected' => $prod_sel);
    }

    if($list=="li")
    {
      $output="";
      if(!empty($categories))
      {//print_r($categories);exit;
        $output .= '<ul>';
        $output .= $this->getCategoryLi($categories, $sel);
        $output .= '</ul>';
      }
      //echo $output;exit;
      return $output;
    }
    else
      return $categories;
  }

  public function getParent($ctype="")
  {
    if($ctype!="")
      return Postcat::where('type', '=', $ctype)
                        ->where('parent', '=', '0')
                        ->get();
    else
      return Postcat::where('type', '=', 'category')
                        ->where('parent', '=', '0')
                        ->get();
  }

  public function hasChild($id, $sel="")
  {
    $cat = array();
    $categories = Postcat::where('parent', '=', $id)->get();
    if(!empty($categories) and $categories!== false)
    {//print_r($categories);exit;
      foreach($categories as $category)
      {
        $prod_sel='';
        if(is_array($sel) and in_array($category->id, $sel))
          $prod_sel='selected';
        elseif($sel==$category->id)
          $prod_sel=='selected';
        //$subCat = $this->hasChild($category->id);
        //$prodType = $this->getProductType($category->id, $sel);
        /*if($subCat!==false)
          $cat[] = array('id' => $category->id, 'name' => $category->name, 'slug' => $category->slug, 'image' => $category->image, 'subcategory' => $subCat);
        else*/
          $cat[] = array('id' => $category->id, 'name' => $category->name, 'slug' => $category->slug, 'image' => $category->image, 'selected' => $prod_sel);
      }
      return $cat;
    }
    else
      return false;
  }

  public function getCategoryLi($categories, $sel="")
  {
    $output = "";
    if(!empty($categories))
    {
      foreach($categories as $cat)
      {
        if($sel!="")
        {
          if(in_array($cat['id'], $sel))
            $output .='<li><label><input type="checkbox" name="category[]" checked value="'.$cat['id'].'"></label> '.$cat['name'];
          else
            $output .='<li><label><input type="checkbox" name="category[]" value="'.$cat['id'].'"></label> '.$cat['name'];
        }
        else
          $output .='<li><label><input type="checkbox" name="category[]" value="'.$cat['id'].'"></label> '.$cat['name'];
        if(!empty($cat['subcategory']))
        {
          $output .='<ul>';
          $output .=$this->getCategoryLi($cat['subcategory'], $sel);
          $output .='</ul></li>';
        }
        else
          $output .= '</li>';
      }
    }
    //echo $output;exit;
    return $output;
  }

  /* gets the categories of the post
   * Parameter: post id whose categories to be returned
   * Returns array of categories
   */
  public function getPostCategories($postid)
  {
      $cat="";
      $categories = Cat_relation::where('postid', '=', $postid)->get();
      foreach($categories as $category)
      {
        $cat[]=$category->catid;
      }
      return $cat;
  }

  /* gets the products id list of the categories
   * Parameter: Category id array
   * Returns array of products id
   */
  public function getRelationProduct($cats)
  {
    $products="";
    $results = Cat_relation::where(function ($q) use ($cats) {
        foreach ($cats as $c) {
            $q->orWhere('catid', '=', $c);
        }
    })->get();

    $products = Posts::where(function ($q) use ($results) {
        foreach ($results as $result) {
            $q->orWhere('id', '=', $result->postid);
        }
    })->get();
    return $products;

  }

}
