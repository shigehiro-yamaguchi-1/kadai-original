<header>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!--<a class="navbar-left" href="/"><img src="{{ asset("images/logo.png") }}" alt="あにらん"></a>-->
                <a class="navbar-left" href="/">あにらん</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                <ul class="nav navbar-nav navbar-right">
                    @guest
                        <li><a href="{{ route('login') }}"><button tyoe="button" class="btn btn-primary glyphicon glyphicon-log-in"> ログイン</button></a></li>
                        <li><a href="{{ route('register') }}"><button tyoe="button" class="btn btn-primary glyphicon glyphicon-registration-mark"> ユーザー登録</button></a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                {{ Auth::user()->name }}さん <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu">
                                <li>{!! link_to_route('users.profile', 'プロフィール', ['id' => Auth::user()->id]) !!}</li>
                                <li>{!! link_to_route('users.friend_list', '友達一覧', ['id' => Auth::user()->id]) !!}</li>
                                <li>
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        ログアウト
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</header>