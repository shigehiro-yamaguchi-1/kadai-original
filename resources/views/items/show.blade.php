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


            <div class="container-fluid">
                @if(!$comments->isEmpty())
                    <h4>{{$item->title}}のコメント一覧</h4>
                    <div class="comment_area"> 
                        <div ng-repeat="data in hoge.chatdata">
                            <div class="row">
                                <div class="col-xs-12">
                                    @foreach($comments as $comment)
                                        @guest
                                            <p class="left_balloon">{{$comment->comment}}<br>{{$comment->user->name}} {{$comment->created_at}}</p><br> <!-- 他人のコメント -->
                                        @else
                                            @if(\Auth::user()->id === $comment->user_id)
                                                <span ng-if="data.type == 'chat'">
                                                    <p class="right_balloon new_line">{{$comment->comment}}<br>{{$comment->user->name}} {{$comment->created_at}}</p><br> <!-- 自分のコメント -->
                                                </span>  
                                            @else
                                                <p class="left_balloon">{{$comment->comment}}<br>{{$comment->user->name}} {{$comment->created_at}}</p><br> <!-- 他人のコメント -->
                                            @endif
                                        @endguest
                                    @endforeach
                                </div>  
                                {!! $comments->render() !!}
                            </div>
                        </div>
                    </div>
                @else
                    <h2>{{$item->title}}にコメントはありません</h2>
                @endif
                    <div class="row text-center">
                        <div class="col-xs-12">
                            @guest
                            @else
                                @include('comments.commentform')
                            @endguest
                        </div>
                    </div>
            </div>


        </div>
    </div>
@endsection