<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', ['as' => '/', 'uses' => 'Frontend\FrontendController@getHomePage']);
Route::get('/{slug}', ['as' => '/', 'uses' => 'Frontend\FrontendController@singlepage']);*/



Auth::routes();



// Authentication Routes...
Route::get('/admin/login', [
  'as' => 'admin/login',
  'uses' => 'Auth\LoginController@showAdminLoginForm'
]);
Route::get('bike/{slug}', function($slug){
    return redirect($slug, 301);
});
Route::get('car/{slug}', function($slug){
    return redirect($slug, 301);
});
/*Route::post('login', [
  'as' => 'login',
  'uses' => 'Auth\LoginController@login'
]);*/
/*Route::post('logout', [
  'as' => 'logout',
  'uses' => 'Auth\LoginController@logout'
]);*/

// Password Reset Routes...
/*Route::post('password/email', [
  'as' => 'password.email',
  'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail'
]);
Route::get('password/reset', [
  'as' => 'password.request',
  'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm'
]);
Route::post('password/reset', [
  'as' => '',
  'uses' => 'Auth\ResetPasswordController@reset'
]);
Route::get('password/reset/{token}', [
  'as' => 'password.reset',
  'uses' => 'Auth\ResetPasswordController@showResetForm'
]);

// Registration Routes...
Route::get('register', [
  'as' => 'register',
  'uses' => 'Auth\RegisterController@showRegistrationForm'
]);
Route::post('register', [
  'as' => '',
  'uses' => 'Auth\RegisterController@register'
]);*/




Route::get('/dashboard', 'HomeController@index')->name('dashboard');



Route::group(['prefix' => '/admin/page/'], function () {
  Route::get('list', ['uses' => 'Posts\PageController@indexPage'])->middleware('admin');
  Route::get('add', ['uses' => 'Posts\PageController@createPage'])->middleware('admin');
  Route::get('edit/{id}', ['uses' => 'Posts\PageController@createPage'])->middleware('admin');
  Route::post('store', ['uses' => 'Posts\PageController@store'])->middleware('admin');
});

Route::group(['prefix' => '/admin/post/'], function () {
  Route::get('list', ['uses' => 'Posts\PostsController@indexPosts'])->middleware('admin');
  Route::get('add', ['uses' => 'Posts\PostsController@createPosts'])->middleware('admin');
  Route::get('edit/{id}', ['uses' => 'Posts\PostsController@createPosts'])->middleware('admin');
  Route::post('store', ['uses' => 'Posts\PostsController@store'])->middleware('admin');
  Route::get('category', ['uses' => 'Posts\PostsController@indexCategory'])->middleware('admin');
  Route::get('category/{id}', ['uses' => 'Posts\PostsController@indexCategory'])->middleware('admin');
  Route::post('store-category', ['uses' => 'Posts\PostsController@storeCategory'])->middleware('admin');
});

Route::group(['prefix' => '/admin/ads/'], function () {
  Route::get('list', ['uses' => 'Posts\AdsController@listAds'])->middleware('admin');
  Route::get('add', ['uses' => 'Posts\AdsController@createAds'])->middleware('admin');
  Route::get('edit/{id}', ['uses' => 'Posts\AdsController@createAds'])->middleware('admin');
  Route::post('store', ['uses' => 'Posts\AdsController@storeAds'])->middleware('admin');
  Route::get('position', ['uses' => 'Posts\AdsController@adsPosition'])->middleware('admin');
  Route::get('edit-position/{id}', ['uses' => 'Posts\AdsController@adsPosition'])->middleware('admin');
  Route::get('delete-position/{id}', ['uses' => 'Posts\AdsController@deletePosition'])->middleware('admin');
  Route::post('position', ['uses' => 'Posts\AdsController@storePosition'])->middleware('admin');
  Route::get('delete/{id}', ['uses' => 'Posts\AdsController@adsDelete'])->middleware('admin');
});


Route::group([
    'prefix'    =>  '/admin/price',
    'as'        =>  'price.',
  //'namespace' =>  'Article',

],function(){
  Route::group(['namespace' => 'Posts'],function(){

    Route::get('/brand',['uses' =>'PriceSearchController@brandIndex'])->middleware('admin');
    Route::get('/brand/{id}',['uses' =>'PriceSearchController@brandIndex'])->middleware('admin');
    Route::get('/brand/delete/{id}',['uses' =>'PriceSearchController@branddestroy'])->middleware('admin');
    Route::post('/brand-store',['uses' =>'PriceSearchController@brandstore'])->middleware('admin');


    Route::get('/product-list',['uses' =>'PriceSearchController@productIndex'])->middleware('admin');
    Route::get('/product/add',['uses' =>'PriceSearchController@productadd'])->middleware('admin');
    Route::post('/storeProduct',['uses' =>'PriceSearchController@storeProduct'])->middleware('admin');
    Route::get('/product/edit/{id}',['uses' => 'PriceSearchController@productadd'])->middleware('admin');
    Route::get('/product/delete/{id}', ['uses' =>'PriceSearchController@deleteProduct'])->middleware('admin');


    Route::get('/category',['uses' => 'PriceSearchController@indexCategory'])->middleware('admin');
    Route::get('/category/{id}',['uses' => 'PriceSearchController@indexCategory'])->middleware('admin');
    Route::post('/store',['uses' => 'PriceSearchController@storeCategory'])->middleware('admin');
    Route::get('category/delete/{id}', ['uses' => 'PriceSearchController@catdestroy'])->middleware('admin');

   // Route::resource('article' , 'PriceSearchController');
  });
});

Route::group([
    'prefix'  =>  'admin/e-paper',
    'as'      =>  'e-paper.',
],function(){
  Route::group(['namespace' => 'Posts'],function(){
    Route::get('/',['uses' => 'EpaperController@indexEpaper'])->middleware('admin');
    Route::get('/{id}',['uses' => 'EpaperController@indexEpaper'])->middleware('admin');

    Route::post('/store',['uses' => 'EpaperController@storeEpaper'])->middleware('admin');
    Route::get('/delete/{id}',['uses' => 'EpaperController@deleteEpaper'])->middleware('admin');
  });
});


Route::group(
    [
        'prefix' => '/',
        'as'     =>  'frontend.',
    ],
    function () {
      //product category

      Route::get('','Frontend\FrontendController@getHomePage')->name('getHomePage');
      Route::get('/contact-us','Frontend\FrontendController@contactpage')->name('contactpage');
      Route::post('/contact-us','Frontend\FrontendController@contactsend')->name('contactsend');

      Route::get('/price-list','Frontend\FrontendController@pricelist')->name('pricelist');
      Route::get('/price-list/{slug}','Frontend\FrontendController@pricelist')->name('pricelist');
      Route::get('/price-list/detail/{slug}','Frontend\FrontendController@pricelistDetail')->name('pricelistDetail');

      Route::get('/search/price-list','Frontend\FrontendController@searchpricelist')->name('searchpricelist');


      Route::get('/{slug}','Frontend\FrontendController@singlepage')->name('singlepage');
      Route::post('/subscriber','Frontend\FrontendController@subscriber')->name('subscriber');

      Route::get('category/{slug}','Frontend\FrontendController@category')->name('category');

      Route::post('/loadajax','Frontend\FrontendController@loadajax')->name('loadajax');

      Route::get('/epaper/list','Frontend\FrontendController@listepaper')->name('listepaper');
      Route::get('/epaper/view/{slug}', 'Frontend\FrontendController@pdfstream')->name('pdfstream');
    });
