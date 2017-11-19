@extends('layouts.default')

@section('cover')
    <div class="cover">
        <div class="cover-inner">
            <div class="cover-contents">
                <h1 class="text-center">あにらん！</h1>
                <h4 class="text-center">～素敵なアニメと出会う場所～</h4>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('items.select_year_season')
    <p class="text-right">※ランキングは一定時間毎に更新されます。</p>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-condensed table-headerfixed">
            <thead>
                <tr>
                    <th width="10%" class="text-center">Rank</th>
                    <th width="10%" class="text-center">Score</th>
                    <th width="60%" class="text-center">title</th>
                    <th width="10%" class="text-center">{!!$high_rate_i!!}</th>
                    <th width="10%" class="text-center">{!!$low_rate_i!!}</th>
                </tr>
            </thead>
            <tbody>
            @foreach($rankings as $key => $ranking)
                <tr>
                    <td width="10%" class="text-center">{{$ranking->rank}}</td>
                    <td width="10%" class="text-center">{{$ranking->score}}</td>
                    <td width="60%" class="text-left ellipsis"><img src = "{{ $ranking->profile_image_url }}"> {!! link_to_route('items.item_detail', $ranking->title, ['id' => $ranking->item_id]) !!}</td>
                    <td width="10%" class="text-center">{{$ranking->high_rate}}</td>
                    <td width="10%" class="text-center">{{$ranking->low_rate}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection