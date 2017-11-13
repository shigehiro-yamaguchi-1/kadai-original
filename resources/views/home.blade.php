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
            {{ $items[$key]->title }}
            <img src = "{{ $items[$key]->profile_image_url }}">
            <!--<img src = "{{ $items[$key]->profile_banner_url }}">-->
        </div>
    @endforeach

@endsection