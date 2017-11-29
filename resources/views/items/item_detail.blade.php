@extends('layouts.default')

@section('content')
    <div>
        <img src = "{{ $item->profile_banner_url }}" class='banner_image' alt="バナー画像">

        <div>
            <table class="table">
                <tbody>
                    <tr>
                        <td width="20%">タイトル</td>
                        <td width="80%"><img src = "{{ $item->profile_image_url }}">{{ $item->title }}</td>
                    </tr>
                    <tr>
                        <td width="20%">略称</td>
                        <td width="80%">{{$item->title_short1}}</td>
                    </tr>
                    <tr>
                        <td width="20%">時期</td>
                        <td width="80%">{{$item->year}}年 {{\Config::get('anime_item.seasons')[$item->season]}}頃</td>
                    </tr>
                    <tr>
                        <td width="20%">公式サイト</td>
                        <td width="80%"><a href={{$item->public_url}} target="_blank" alt='バナー'>{{$item->public_url}}</a></td>
                    </tr>
                    <tr>
                        <td width="20%">続編モノ</td>
                        <td width="80%">
                            @if ($item->sequel)
                                <p>はい</p>
                            @else
                                <p>いいえ</p>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- 評価領域 --}}
        <div>
            @guest
                <p><a href={{ url('/login') }}>ログイン</a>すると、コメントすることやアニメを評価することができます。</p>
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
        </div>
        {{-- 評価領域 --}}
    </div>


    <!--リアルタイム-->
    <div id ="app">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <h5 id = "reply" class="text-center">コメント一覧</h5>
                </div>
            </div>
            <div class="panel-body" id="target">
                <div class="row">
                    <div class="col-xs-12">
                        <chat-log :messages="messages" :authUser="{{ json_encode(\Auth::user()) }}"></chat-log>
                    </div>
                </div>
            </div>
            @guest
            @else
                <chat-composer v-on:messagesent="addMessage"></chat-composer>
            @endguest
        </div>
    </div>
    <!--リアルタイム-->
    
    <a href={{ url('/') }}><button class="btn btn-warning"><i class="glyphicon glyphicon-circle-arrow-left"></i> 戻る</button></a>
    
@endsection