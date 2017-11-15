<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;
use App\SocialProvider;
use App\User;

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
        try{
            $socialUser = Socialite::driver($social)->user();
        } catch(Exception $e) {
            return redirect('/');
        }

        //すでに登録済みかチェック
        $socialProvider = SocialProvider::where('provider_id',$socialUser->getId())->first();
        
        if (!$socialProvider) {
            //レコードの作成＋データの挿入
            $user = User::firstOrCreate(
                ['email' => $socialUser->getEmail(), 'name' => $socialUser->getName()]
            );
            
            //ソーシャルプロバイダーのテーブルにレコードを追加
            $user->socialProviders()->create(
                ['provider_id' => $socialUser->getId(), 'provider' => $social]
            );
        } else {
            $user = $socialProvider->user;
        }
        
        auth()->login($user);
        
        return redirect('/');
    }

}
