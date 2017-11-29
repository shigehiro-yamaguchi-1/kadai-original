<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}"> 

        <title>あにらん</title>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <!-- ソーシャルログイン -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-social/5.1.1/bootstrap-social.min.css" />
        <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
        
        <!--セレクトボックス-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
        
        <!-- 左サイドメニュー -->
        <link rel="stylesheet" href="{{ asset('css/drawer.min.css') }}">
        <script src="{{ URL::asset('js/drawer.min.js') }}"></script>
        <script src="{{ URL::asset('js/iscroll.js') }}"></script>

        
        <!-- コメント・チャット -->
        <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
        
        <!-- original -->
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">


        <!--<script src="https://cdn.jsdelivr.net/npm/vue"></script>-->
        <!--<script src="https://unpkg.com/vue-router/dist/vue-router.js"></script>-->
        <!--@if (env('APP_DEBUG'))-->
        <!--    <script src="{{ asset('js/vue.js') }}"></script>-->
        <!--@else-->
        <!--   <script src="{{ asset('js/vue.min.js') }}"></script>-->
        <!--@endif-->

    </head>

    <body class="drawer drawer--left drawer--sidebar">
        @yield('cover')

        <div class="container">
            @include('commons.error_messages')
            <div class="row">
                @include('commons.left_side')
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                        @yield('content')
                </div>
                @include('commons.right_side')
            </div>
        </div>

        @include('commons.footer')


        <!-- 左サイドメニュー -->
        <script>
            jQuery.noConflict();
            (function($) {
            $(document).ready(function() {
            $(".drawer").drawer();
            });
            })(jQuery);
        </script>

        <script src="{{ mix('js/app.js') }}"></script>

    </body>
    
</html>