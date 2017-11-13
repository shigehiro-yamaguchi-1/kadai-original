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

    @foreach($items as $key => $item)
        <div>
            <img src = "{{ $items[$key]->profile_image_url }}">
            {!! link_to_route('item_user.show', $item->title, ['id' => $item->id]) !!}
            {{$item->counts['count_high_rates']}}
            {{$item->counts['count_low_rates']}}
            <!--<img src = "{{ $items[$key]->profile_banner_url }}">-->
        </div>
    @endforeach

@endsection