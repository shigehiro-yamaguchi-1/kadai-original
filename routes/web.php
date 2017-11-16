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



Auth::routes();
// モデルとの結合
Route::model('item', 'App\M_item');

//Twitter
Route::get('auth/twitter', 'Auth\OAuthLoginController@getAuth');
Route::get('auth/callback/twitter', 'Auth\OAuthLoginController@authCallback');
//Facebook
Route::get('auth/facebook', 'Auth\OAuthLoginController@getAuth');
Route::get('auth/callback/facebook', 'Auth\OAuthLoginController@authCallback');
//Google
Route::get('auth/google', 'Auth\OAuthLoginController@getAuth');
Route::get('auth/callback/google', 'Auth\OAuthLoginController@authCallback');
 
/*
|--------------------------------------------------------------------------
| 1) User 認証不要
|--------------------------------------------------------------------------
*/
Route::get('/home', function () { return redirect('/'); });
    // Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', 'WelcomeController@index')->name('get.home');
Route::post('/', 'WelcomeController@index')->name('post.home');
Route::get('detail/{id}', 'ItemController@show')->name('item.show');

/*
|--------------------------------------------------------------------------
| 2) User ログイン後
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'auth:user'], function() {
    // Route::get('/home', 'HomeController@index')->name('home');
    
    // high_rate
    Route::post('high_rate', 'ItemController@high_rate')->name('item.high_rate');
    Route::delete('high_rate', 'ItemController@dont_high_rate')->name('item.dont_high_rate');

    // low_rate
    Route::post('low_rate', 'ItemController@low_rate')->name('item.low_rate');
    Route::delete('low_rate', 'ItemController@dont_low_rate')->name('item.dont_low_rate');
    
    // コメント投稿
    Route::post('detail/{item}', 'CommentController@newComment')->name('comment.new');
});
 
/*
|--------------------------------------------------------------------------
| 3) Admin 認証不要
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'admin'], function() {
    Route::get('/',         function () { return redirect('/admin/home'); });
    Route::get('login',     'Admin\LoginController@showLoginForm')->name('admin.login');
    Route::post('login',    'Admin\LoginController@login');
});

/*
|--------------------------------------------------------------------------
| 4) Admin ログイン後
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function() {
    Route::post('logout',   'Admin\LoginController@logout')->name('admin.logout');
    Route::get('home',      'Admin\HomeController@index')->name('admin.home');
    Route::post('home',      'Admin\HomeController@postIndex')->name('admin.post.home');
    Route::resource('m_items', 'Admin\M_itemsController', ['only' => ['store']]);
});
