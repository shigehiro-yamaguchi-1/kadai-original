@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-md-6 col-sm-9 col-xs-12 col-md-offset-3">
            <div class="item">
                <img src = "{{ $item->profile_image_url }}">
                {{ $item->title }}
                <img src = "{{ $item->profile_banner_url }}" class='banner_image'>
                公式サイト：<a href={{$item->public_url}} target="_blank">{{$item->public_url}}</a>
                {{-- 評価領域 --}}
                @guest
                    <p><a href={{ url('/login') }}>ログイン</a>すると、アニメを評価することができます！</p>
                @else
                    <div class="form-inline">
                        <div class="form-group">
                            @include('items.high_rate_button', ['item' => $item])
                        </div>
                        <div class="form-group">
                            @include('items.low_rate_button', ['item' => $item])
                        </div>
                    </div>
                @endguest
                {{-- 評価領域 --}}
            </div>
        </div>
    </div>
@endsection