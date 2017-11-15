<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;

class OAuthLoginController extends Controller
{
    /**
     * OAuth認証 リクエスト
     * @return mixed
     */
    public function getAuth() 
    {
        $social = basename(parse_url($this->getUrl(), PHP_URL_PATH));
        return Socialite::driver($social)->redirect();
    }

    private function getUrl() 
    {
        return (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
    }
    
    /**
    * OAuth認証　コールバック
    */
    public function authCallback() 
    {
        $social = basename(parse_url($this->getUrl(), PHP_URL_PATH));
        
        // ユーザ属性を取得
        $user = Socialite::driver($social)->user();
        
        // デバッグ（デモンストレーション用）
        // echo'<pre>'; print_r($user); echo'<pre>'; exit;
    }
    
}
