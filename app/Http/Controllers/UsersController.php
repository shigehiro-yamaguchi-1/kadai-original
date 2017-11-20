<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    public function profile($id)
    {
        $userData = User::find($id);

        // 視聴一覧（＝評価したもの）
        // SelectBox用にyear,seasonを取得
        $evaluate_year_seasons = $userData->evaluates()->select('year','season')
                                        ->orderby('year', 'DESC')
                                        ->orderby('season', 'DESC')
                                        ->get();

        // SelectBoxからの返り値
        if (request()->year_season === null) {
            // SelectBoxから取得できなかった場合の初期値
            $year = $evaluate_year_seasons->first()->year;
            $season = $evaluate_year_seasons->first()->season;
        } else {
            // requestのyear_seasonは、'yyyy,mm'で返ってくるため分解する
            $select_year_season = explode(',', request()->year_season);
            $year = $select_year_season[0];
            $season = $select_year_season[1];
        }

        // 指定のyear, seasonで表示用ランキングデータを取ってくるよ
        $evaluates = $userData->evaluates()->where('year', $year)
                                        ->where('season', $season)
                                        ->orderby('type', 'ASC')
                                        ->get();

        // SelectBox用に加工していくよ
        $year_seasons = $this->get_select_array($evaluate_year_seasons);

        $data = [
            'user' => $userData,
            'evaluates' => $evaluates,
            'year_seasons' => $year_seasons,
        ];
        
        $data += $this->user_counts($userData);
        
        return view('users.profile', $data);
    }
    
    public function friend_list($id)
    {
        $userData = User::find($id);

        $friendData = $userData->friends()->get();

        $data = [
            'user' => $userData,
            'friends' => $friendData,
        ];

        $data += $this->user_counts($userData);

        return view('users.friend_list', $data);
    }
}