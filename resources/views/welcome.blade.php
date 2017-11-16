@extends('layouts.default')

@section('cover')
    <div class="cover">
        <div class="cover-inner">
            <div class="cover-contents">
                <h1>素敵なアニメと出会う場所</h1>
            </div>
        </div>
    </div>
@endsection

@section('content')
    

    @include('items.select_year_season')

    @foreach($rankings as $key => $ranking)
        <div>
            {{$ranking->rank}}
            {{$ranking->score}}
            <img src = "{{ $ranking->profile_image_url }}">
            
            {!! link_to_route('item.show', $ranking->title, ['id' => $ranking->item_id]) !!}
            {{$ranking->high_rate}}
            {{$ranking->low_rate}}
            <!--<img src = "{{ $ranking->profile_banner_url }}">-->
        </div>
    @endforeach

@endsection