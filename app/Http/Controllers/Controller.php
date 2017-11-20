<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public static function item_counts($item) {
        $count_high_rates = $item->high_rate_users()->count();
        $count_low_rates = $item->low_rate_users()->count();

        return [
            'count_high_rates' => $count_high_rates,
            'count_low_rates' => $count_low_rates,
        ];
    }

    public static function user_counts($user) {
        $count_friends = $user->friends()->count();
        
        return [
            'count_friends' => $count_friends,
        ];
    }
    
    public static function config_rate_names() {
        return [
            'high_rate_i'       => '<i class="glyphicon glyphicon-thumbs-up"></i>',
            'low_rate_i'        => '<i class="glyphicon glyphicon-thumbs-down"></i>',
            'high_rate_name'    => '<i class="glyphicon glyphicon-thumbs-up"></i> '     . \Config::get('anime_type.high_rate_name'),
            'low_rate_name'     => '<i class="glyphicon glyphicon-thumbs-down"></i> '   . \Config::get('anime_type.low_rate_name'),
        ];
    }
    
     /**************************************************
    	SelectBox選択肢生成
    	desc    : yearでグルーピングした多次元連想配列を返します
    	return  : 多次元連想配列
    	arg1    : $array
    **************************************************/ 
    public function get_select_array($arrays)
    {
        $year_seasons = [];
        foreach ($arrays as $array) {
            $key = $array->year.'年';
            if (array_key_exists($key, $year_seasons)) {
                $year_seasons[$key] += [$array->year.','.$array->season => $array->year.'年 '.\Config::get('anime_item.seasons')[$array->season].'アニメ'];
            } else {
                $year_seasons[$key] = [$array->year.','.$array->season => $array->year.'年 '.\Config::get('anime_item.seasons')[$array->season].'アニメ'];
            }
        }
        return $year_seasons;
    }
}
