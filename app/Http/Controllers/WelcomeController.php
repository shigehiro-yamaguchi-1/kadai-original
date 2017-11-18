<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Season_ranking_data;

class WelcomeController extends Controller
{
    public function index()
    {

        // SelectBox用にyear,seasonを取得
        $ranking_year_seasons = Season_ranking_data::select('year','season')
                                            ->groupby('year','season')
                                            ->orderby('year', 'DESC')
                                            ->orderby('season', 'DESC')
                                            ->get();

        // SelectBoxからの返り値
        if (request()->year_season === null) {
            // SelectBoxから取得できなかった場合の初期値
            $year = $ranking_year_seasons->first()->year;
            $season = $ranking_year_seasons->first()->season;
        } else {
            // requestのyear_seasonは、'yyyy,mm'で返ってくるため分解する
            $select_year_season = explode(',', request()->year_season);
            $year = $select_year_season[0];
            $season = $select_year_season[1];
        }
        // 指定のyear, seasonで表示用ランキングデータを取ってくるよ
        $rankingDatas = Season_ranking_data::where('year', $year)
                                            ->where('season', $season)
                                            ->get();

        // SelectBox用に加工していくよ
        // Array
        // (
        //     [2017年] => Array
        //         (
        //             [2017,4] => 2017年 冬アニメ
        //             [2017,3] => 2017年 秋アニメ
        //         )
        //     [2016年] => Array
        //         (
        //             [2016,4] => 2016年 冬アニメ
        //             [2016,1] => 2016年 春アニメ
        //         )
        // )
        $year_seasons = [];
        foreach ($ranking_year_seasons as $ranking_year_season) {
            $key = $ranking_year_season->year.'年';
            if (array_key_exists($key, $year_seasons)) {
                $year_seasons[$key] += [$ranking_year_season->year.','.$ranking_year_season->season => $ranking_year_season->year.'年 '.\Config::get('anime_item.seasons')[$ranking_year_season->season].'アニメ'];
            } else {
                $year_seasons[$key] = [$ranking_year_season->year.','.$ranking_year_season->season => $ranking_year_season->year.'年 '.\Config::get('anime_item.seasons')[$ranking_year_season->season].'アニメ'];
            }
        }

        $data = [
            'rankings' => $rankingDatas,
            'year_seasons' => $year_seasons,
        ];

        return view('welcome', $data);
    }
}

