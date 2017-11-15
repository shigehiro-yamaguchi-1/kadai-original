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
Route::get('detail/{id}', 'ItemUserController@show')->name('item_user.show');

/*
|--------------------------------------------------------------------------
| 2) User ログイン後
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'auth:user'], function() {
    // Route::get('/home', 'HomeController@index')->name('home');
    
    // high_rate
    Route::post('high_rate', 'ItemUserController@high_rate')->name('item_user.high_rate');
    Route::delete('high_rate', 'ItemUserController@dont_high_rate')->name('item_user.dont_high_rate');

    // low_rate
    Route::post('low_rate', 'ItemUserController@low_rate')->name('item_user.low_rate');
    Route::delete('low_rate', 'ItemUserController@dont_low_rate')->name('item_user.dont_low_rate');
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
