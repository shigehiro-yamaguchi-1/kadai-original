<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\M_item;
use App\Http\Controllers\Controller;
use Carbon\Carbon;


class CreateRankingData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'createranking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create ranking data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // #########################
        // # ランキングデータの作成
        // #########################

        // アイテムマスター
        $itemData = M_item::all();

        $rankingData = [];
        foreach ($itemData as $key => $item) {
            $rankingData[$key]['year']          = $item->year;
            $rankingData[$key]['season']        = $item->season;
            // $rankingData[$key]['rank']          = 1;
            $rankingData[$key]['score']         = 50;       // なんとなく初期値入れとこ
            $rankingData[$key]['item_id']       = $item->id;
            $rankingData[$key]['title']         = $item->title;
            $rankingData[$key]['profile_image_url'] = $item->profile_image_url;

            // high & low
            $array = Controller::item_counts($item);
            $rankingData[$key]['high_rate']     = $array['count_high_rates']; // high_rate
            $rankingData[$key]['low_rate']      = $array['count_low_rates']; // low_rate
            
            $rankingData[$key]['created_at']    = Carbon::now();
            $rankingData[$key]['updated_at']    = Carbon::now();
        }

        // score付け（超適当）
        foreach ($rankingData as $key => $ranking) {
            $rankingData[$key]['score'] += $ranking['high_rate'] - $ranking['low_rate'];
        }
        
        // 年別・期別で処理しやすいように
        foreach ($rankingData as $key => $value) {
            $key_year[$key]   = $value['year'];
            $key_season[$key] = $value['season'];
            $key_score[$key]  = $value['score'];
        }
        array_multisort($key_year, SORT_ASC, $key_season, SORT_ASC, $key_score, SORT_DESC, $rankingData);

        // scoreに沿って番付=>rank
        // 同scoreの場合は同列順位とする
        foreach ($rankingData as $key => $value) {
            static $i = 0;
            if ($i == 0) {
                $i = 1;
                $year = $value['year'];
                $season = $value['season'];
                $score = $value['score'];
            }
            if ($year == $value['year'] && $season == $value['season']) {
                if ($score != $value['score']) {
                    $i++;
                    $score = $value['score'];
                }
                $rankingData[$key]['rank'] = $i;
            } else {
                $i = 1;
                $rankingData[$key]['rank'] = $i;
                $score = $value['score'];
            }
            $year = $value['year'];
            $season = $value['season'];
        }

        // ランキングデータの削除（本当はキャッシュに乗せておきたい）
        \DB::table('season_ranking_datas')
            ->truncate();

        // ランキングデータの作成
        try{
            $cli = \DB::table('season_ranking_datas')
                    ->insert($rankingData);
        }catch(\Exception $e) {
            // てけとー
            echo 'データのinsertに失敗しました。';
            exit;
        }
    }

}
