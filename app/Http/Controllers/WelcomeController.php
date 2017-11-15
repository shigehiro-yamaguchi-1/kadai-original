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

        $year = request()->year;
        $season = request()->season;
        
        // selectから取得できなかった場合の初期値
        // 上でyear,seasonをdescソートしているのでこれでいっかな
        if (!$year || !$season) {
            $year = $years->first();;
            $season = $seasons->first();;
        }
        
        // 年とシーズンで絞るよ
        $rankingData = Season_ranking_data::where('year', $year)
                        ->where('season', $season)
                        ->get();

        $data = [
            'rankings' => $rankingData,
            'years' => $years,
            'seasons' => $seasons,
        ];

        return view('welcome', $data);
    }
}

