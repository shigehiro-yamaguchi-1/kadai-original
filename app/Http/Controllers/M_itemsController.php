<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\M_item;
use Carbon\Carbon;

class M_itemsController extends Controller
{
    public function create()
    {
        // $year = request()->year;
        // $season = request()->cours;
        // ToDo
        $year = 2017;
        $season = 4;
        
        // (1) shangrilla...api からとりあえず一通り取得
        $sha_api_data = $this->shangrila_anime_api($year, $season);

        // (2) twitter_apiに投げる前にパラメータ準備
        $param = $this->get_twwiter_param($sha_api_data, 'twitter_account');
        
        // (3) twitter_apiから追加情報を取得
        $twi_api_data = $this->twitter_api($param);

        // (1), (3)を結合
        $anime_data = $this->fArray_merge( $sha_api_data, $twi_api_data );
        
        echo "<pre>";
        print_r($anime_data);
        echo "</pre>";

            $cli = DB::table('m_items')
                    -> insert($anime_data[2]);
        // try{
        //     $cli = DB::table('m_items')
        //             -> insert($anime_data);
        // }catch(\Exception $e) {
        //     // てけとー
        //     echo 'データのinsertに失敗しました。';
        //     exit;
        // }

        return view('admin.home');
    }
    
    private function shangrila_anime_api($year, $season)
    {

        /**************************************************
        
        	ShangriLa Anime API V1
        	ドキュメント: https://qiita.com/AKB428/items/64938febfd4dcf6ea698
    
        **************************************************/    

        $genre_id = 0;
        $api = 'http://api.moemoe.tokyo/anime/v1/master';

        $response = file_get_contents("$api/$year/$season");
        
        $animeList = json_decode($response);
        
        $array = [];
        foreach ($animeList as $anime) {
            $array[] = [
                'title'            => $anime->title,
                'title_short1'     => $anime->title_short1,
                'title_short2'     => $anime->title_short2,
                'title_short3'     => $anime->title_short3,
                'public_url'       => $anime->public_url,
                'twitter_account'  => $anime->twitter_account,
                'twitter_hash_tag' => $anime->twitter_hash_tag,
                'year'             => $year,
                'season'           => $season,
                'cours_id'         => $anime->cours_id,
                'sex'              => $anime->sex,
                'sequel'           => $anime->sequel,
                'ganre_id'         => $genre_id,
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now(),
            ];
        }
        return $array;
    }
    
    private function get_twwiter_param ($arrays, $target)
    { 
        $param = [];
        foreach ($arrays as $array) {
            foreach($array as $key => $value) {
                if ($key === $target) {
                    $param[] = $value;
                }
            }
        }
        $param_result = implode(',', $param);
        
        return $param_result;
    }


    private function twitter_api($param)
    {

         /**************************************************
        
        	Twitter API
        	参考: https://syncer.jp/Web/API/Twitter/REST_API/GET/users/profile_banner/
    
        **************************************************/    

        // 設定
    	$api_key = env('TWITTER_API_KEY') ;		// APIキー
    	$api_secret = env('TWITTER_API_SECRET') ;		// APIシークレット
    	$access_token = env('TWITTER_ACCESS_TOKEN') ;		// アクセストークン
    	$access_token_secret = env('TWITTER_ACCESS_TOKEN_SECRET') ;		// アクセストークンシークレット
    	$request_url = 'https://api.twitter.com/1.1/users/lookup.json' ;		// エンドポイント
    	$request_method = 'GET' ;
    
    	// パラメータA (オプション)
    	$params_a = array(
    		"screen_name" => $param,
    	) ;
    
    	// キーを作成する (URLエンコードする)
    	$signature_key = rawurlencode( $api_secret ) . '&' . rawurlencode( $access_token_secret ) ;
    
    	// パラメータB (署名の材料用)
    	$params_b = array(
    		'oauth_token' => $access_token ,
    		'oauth_consumer_key' => $api_key ,
    		'oauth_signature_method' => 'HMAC-SHA1' ,
    		'oauth_timestamp' => time() ,
    		'oauth_nonce' => microtime() ,
    		'oauth_version' => '1.0' ,
    	) ;
    
    	// パラメータAとパラメータBを合成してパラメータCを作る
    	$params_c = array_merge( $params_a , $params_b ) ;
    
    	// 連想配列をアルファベット順に並び替える
    	ksort( $params_c ) ;
    
    	// パラメータの連想配列を[キー=値&キー=値...]の文字列に変換する
    	$request_params = http_build_query( $params_c , '' , '&' ) ;
    
    	// 一部の文字列をフォロー
    	$request_params = str_replace( array( '+' , '%7E' ) , array( '%20' , '~' ) , $request_params ) ;
    
    	// 変換した文字列をURLエンコードする
    	$request_params = rawurlencode( $request_params ) ;
    
    	// リクエストメソッドをURLエンコードする
    	// ここでは、URL末尾の[?]以下は付けないこと
    	$encoded_request_method = rawurlencode( $request_method ) ;
     
    	// リクエストURLをURLエンコードする
    	$encoded_request_url = rawurlencode( $request_url ) ;
     
    	// リクエストメソッド、リクエストURL、パラメータを[&]で繋ぐ
    	$signature_data = $encoded_request_method . '&' . $encoded_request_url . '&' . $request_params ;
    
    	// キー[$signature_key]とデータ[$signature_data]を利用して、HMAC-SHA1方式のハッシュ値に変換する
    	$hash = hash_hmac( 'sha1' , $signature_data , $signature_key , TRUE ) ;
    
    	// base64エンコードして、署名[$signature]が完成する
    	$signature = base64_encode( $hash ) ;
    
    	// パラメータの連想配列、[$params]に、作成した署名を加える
    	$params_c['oauth_signature'] = $signature ;
    
    	// パラメータの連想配列を[キー=値,キー=値,...]の文字列に変換する
    	$header_params = http_build_query( $params_c , '' , ',' ) ;
    
    	// リクエスト用のコンテキスト
    	$context = array(
    		'http' => array(
    			'method' => $request_method , // リクエストメソッド
    			'header' => array(			  // ヘッダー
    				'Authorization: OAuth ' . $header_params ,
    			) ,
    		) ,
    	) ;
    
    	// パラメータがある場合、URLの末尾に追加
    	if( $params_a ) {
    		$request_url .= '?' . http_build_query( $params_a ) ;
    	}
    
    	// cURLを使ってリクエスト
    	$curl = curl_init() ;
    	curl_setopt( $curl, CURLOPT_URL , $request_url ) ;
    	curl_setopt( $curl, CURLOPT_HEADER, 1 ) ; 
    	curl_setopt( $curl, CURLOPT_CUSTOMREQUEST , $context['http']['method'] ) ;	// メソッド
    	curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER , false ) ;	// 証明書の検証を行わない
    	curl_setopt( $curl, CURLOPT_RETURNTRANSFER , true ) ;	// curl_execの結果を文字列で返す
    	curl_setopt( $curl, CURLOPT_HTTPHEADER , $context['http']['header'] ) ;	// ヘッダー
    	curl_setopt( $curl , CURLOPT_TIMEOUT , 5 ) ;	// タイムアウトの秒数
    	$res1 = curl_exec( $curl ) ;
    	$res2 = curl_getinfo( $curl ) ;
    	curl_close( $curl ) ;
    
    	// 取得したデータ
    	$json = substr( $res1, $res2['header_size'] ) ;		// 取得したデータ(JSONなど)
    	$header = substr( $res1, 0, $res2['header_size'] ) ;	// レスポンスヘッダー (検証に利用したい場合にどうぞ)
    
    	// JSONをオブジェクトに変換
    	$obj = json_decode( $json ) ;

        $twitter_data = [];
        foreach($obj as $array) {
            $temp = [];
            foreach($array as $key => $value) {
                if ($key === 'profile_banner_url') {
                    $temp += array($key => $value);
                }
            }
            $twitter_data[] = $temp;
        }
    	
    	return $twitter_data;
    }
    
    private function fArray_merge( $aOld, $aNew ){
         /**************************************************
        
        	多次元連想配列同士のマージ
        	参考: http://designhack.slashlab.net/php-note-for-merge-multidimensional-associative-arrays/
    
        **************************************************/    

        foreach($aNew as $sKey=>$mValue){
            if ( isset($aOld[$sKey]) && is_array($mValue) && is_array($aOld[$sKey])){
                $aOld[$sKey] = $this->fArray_merge($aOld[$sKey], $mValue);
            } else {
                $aOld[$sKey] = $mValue;
            }
        }
        return($aOld);
    }
    
}