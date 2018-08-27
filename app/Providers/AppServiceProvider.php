<?php
namespace App\Providers;

use DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use App\Models\Posts;
use App\Models\Postmeta;
use App\Models\Postcat;
use App\Models\Autobrands;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);


        view()->composer('frontend.includes.sidebar',function($view)
        {
            $view->with('editorChoices',
                DB::table('posts')
                ->join('postmetas', 'postmetas.postid', '=', 'posts.id')
                ->where('postmetas.meta_key', '=', 'editor_choice')
                ->where('postmetas.meta_value', '=', 'yes')
                ->select('posts.*')
                ->orderby('updated_at','DESC')
                ->limit(3)
                ->get())
                
                ->with('sidebartops',
                    DB::table('posts')
                        ->join('cat_relations', 'cat_relations.postid', '=', 'posts.id')
                        ->join('postcats', 'postcats.id', '=', 'cat_relations.catid')
                        ->where('postcats.slug', '=', 'sidebar-top')
                        ->select('posts.*')
                        ->get())

                ->with('sidebarbottoms',
                    DB::table('posts')
                        ->join('cat_relations', 'cat_relations.postid', '=', 'posts.id')
                        ->join('postcats', 'postcats.id', '=', 'cat_relations.catid')
                        ->where('postcats.slug', '=', 'sidebar-bottom')
                        ->select('posts.*')
                        ->get())

                ->with('epapers',
                        Posts::where('ctype', '=', 'epaper')
                                ->orderBy('id', 'DESC')
                                ->limit(1)
                                ->get()
                        );
        });

        view()->composer('frontend.includes.sub-footer',function($views){
           $views->with('categories',
               Postcat::where('type', 'category')->get()
               );
        });

        view()->composer('frontend.includes.price',function($views){
            $views->with('brands',
                Autobrands::where('status', '=', 'publish')->get()
            );
        });

        

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
