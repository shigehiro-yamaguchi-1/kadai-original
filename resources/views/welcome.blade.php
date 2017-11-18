@extends('layouts.default')

@section('cover')
    <div class="cover">
        <div class="cover-inner">
            <div class="cover-contents">
                <h1 class="text-center">素敵なアニメと出会う場所</h1>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
            左にゃ
            <br>何にしようかなぁ
            <br>カテゴリは面倒だしなぁ
            <br>フレンド機能欲しいなぁ
            <br>ならフレンドチャット欲しいなぁ
            <br>自分が見てるアニメ（＝評価したアニメ）を見せ合いっこしたら面白そうだなぁ
        </div>
        
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
            @include('items.select_year_season')
            <p class="text-right">※ランキングは一定時間毎に更新されます。</p>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-condensed table-headerfixed">
                    <thead>
                        <tr>
                            <th width="10%" class="text-center">Rank</th>
                            <th width="10%" class="text-center">Score</th>
                            <th width="60%" class="text-center">title</th>
                            <th width="10%" class="text-center">{!!$high_rate_name!!}</th>
                            <th width="10%" class="text-center">{!!$low_rate_name!!}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($rankings as $key => $ranking)
                        <tr>
                            <td width="10%" class="text-center">{{$ranking->rank}}</td>
                            <td width="10%" class="text-center">{{$ranking->score}}</td>
                            <td width="60%" class="text-left ellipsis"><img src = "{{ $ranking->profile_image_url }}"> {!! link_to_route('item.show', $ranking->title, ['id' => $ranking->item_id]) !!}</td>
                            <td width="10%" class="text-center">{{$ranking->high_rate}}</td>
                            <td width="10%" class="text-center">{{$ranking->low_rate}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
            右にゃ
            <br>何にしようかなぁ
            <br>広告でも貼るスペースってことでスルーするかなぁ
        </div>

    </div>
@endsection