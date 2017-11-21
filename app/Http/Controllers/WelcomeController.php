<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Season_ranking_data;

class WelcomeController extends Controller
{
    public function index()
    {
        $ranking_year_seasons = $this->get_cache_year_season();

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
        $rankingDatas = $this->get_cache_season_ranking($year, $season);

        // SelectBox用に加工していくよ
        $year_seasons = $this->get_select_array($ranking_year_seasons);
        
        $config_rate_names = $this->config_rate_names();

        $data = [
            'rankings' => $rankingDatas,
            'year_seasons' => $year_seasons,
            'high_rate_i' => $config_rate_names['high_rate_i'],
            'low_rate_i' => $config_rate_names['low_rate_i'],
        ];

        return view('welcome', $data);
    }
    
    public function get_cache_year_season()
    {
        $CacheKey = 'ranking_year_seasons';

        $ranking_year_seasons = \Cache::rememberForever($CacheKey, function() {
            // 初回、及びランキングデータ作成後でcacheが無い場合は直接取る
            $ranking_year_seasons = Season_ranking_data::select('year','season')
                                                ->groupby('year','season')
                                                ->orderby('year', 'DESC')
                                                ->orderby('season', 'DESC')
                                                ->get();
            return $ranking_year_seasons;
        });
        $ranking_year_seasons = \Cache::get('ranking_year_seasons');
        return $ranking_year_seasons;
    }

    
    public function get_cache_season_ranking($year, $season)
    {
        $CacheKey = 'rankingDatas_'.$year.'_'.$season;

        $rankingDatas = \Cache::rememberForever($CacheKey, function() use ($year, $season){
            // 初回、及びランキングデータ作成後でcacheが無い場合は直接取る
            // 指定のyear, seasonで表示用ランキングデータを取ってくるよ
            $rankingDatas = Season_ranking_data::where('year', $year)
                                                ->where('season', $season)
                                                ->get();
            return $rankingDatas;
        });

        $rankingDatas = \Cache::get($CacheKey);
        return $rankingDatas;
    }
    
    
}

