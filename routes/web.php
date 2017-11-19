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



/*
|--------------------------------------------------------------------------
| 1) User 認証不要
|--------------------------------------------------------------------------
*/

// モデルとの結合
Route::model('item', 'App\M_item');

// ログイン関連
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

// トップ
Route::get('/home', function () { return redirect('/'); });
Route::get('/', 'WelcomeController@index')->name('get.home');
Route::post('/', 'WelcomeController@index')->name('post.home');

// アイテム詳細
Route::get('detail/{id}', 'ItemController@show')->name('items.item_detail');


/*
|--------------------------------------------------------------------------
| 2) User ログイン後
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'auth:user'], function() {

    // high_rate
    Route::post('high_rate', 'ItemEvaluateController@high_rate')->name('item.high_rate');
    Route::delete('high_rate', 'ItemEvaluateController@un_high_rate')->name('item.un_high_rate');

    // low_rate
    Route::post('low_rate', 'ItemEvaluateController@low_rate')->name('item.low_rate');
    Route::delete('low_rate', 'ItemEvaluateController@un_low_rate')->name('item.un_low_rate');
    
    // コメント投稿
    Route::post('detail/{item}', 'CommentController@newComment')->name('comment.new');
    
    // プロフィール
    Route::get('profile/{id}', 'UsersController@profile')->name('users.profile');

    // フレンド関連
    Route::group(['prefix' => 'users/{id}'], function () { 
        Route::post('friend', 'UserFriendController@friend')->name('user.friend');
        Route::delete('unfriend', 'UserFriendController@unfriend')->name('user.unfriend');
        Route::get('friend_list', 'UsersController@friend_list')->name('users.friend_list');
    });
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
