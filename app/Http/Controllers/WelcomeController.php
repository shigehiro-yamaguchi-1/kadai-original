<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Season_ranking_data;

class WelcomeController extends Controller
{
    public function index()
    {

        // formのselect用
        $years = Season_ranking_data::groupby('year')->orderby('year', 'DESC')->pluck('year', 'year');
        $seasons = Season_ranking_data::groupby('season')->orderby('season', 'DESC')->pluck('season', 'season');

        // selectからの返り値
        if (request()->year_season === null) {
            // selectから取得できなかった場合の初期値
            // 上でyear,seasonをdescソートしているのでこれでいっかな
            $year = $years->first();;
            $season = $seasons->first();;
        } else {
            // requestのyear_seasonは、'yyyy,mm'で返ってくるため分解する
            $year_season = explode(',', request()->year_season);
            $year = $year_season[0];
            $season = $year_season[1];
        }

        // 年とシーズンで絞るよ
        $rankingData = Season_ranking_data::where('year', $year)
                        ->where('season', $season)
                        ->get();

        $year_seasons = [];
        foreach ($years as $year) {
            $key = $year.'年';
            foreach ($seasons as $season) {
                if (array_key_exists($key, $year_seasons)) {
                    $year_seasons[$key] += [$year.','.$season => $year.'年 '.\Config::get('anime_item.seasons')[$season].'アニメ'];
                } else {
                    $year_seasons[$key] = [$year.','.$season => $year.'年 '.\Config::get('anime_item.seasons')[$season].'アニメ'];
                }
            }
        }

        $data = [
            'rankings' => $rankingData,
            'years' => $years,
            'seasons' => $seasons,
            'year_seasons' => $year_seasons,
        ];

        return view('welcome', $data);
    }
}

