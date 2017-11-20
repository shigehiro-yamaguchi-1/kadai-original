<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
    <!-- ハンバーガーボタン -->
    <button type="button" class="drawer-toggle drawer-hamburger">
        <span class="sr-only">toggle navigation</span>
        <span class="drawer-hamburger-icon"></span>
    </button>

    <nav class="drawer-nav left-side-color">
        <div class="list-group list-color">
            <!-- ドロワーメニューの中身 -->
            {!! link_to_route('get.home', ' あにらんTOP', null, ['class' => 'list-group-item glyphicon glyphicon-home']) !!}
            @guest
                {!! link_to_route('login', ' ログイン', null, ['class' => 'list-group-item glyphicon glyphicon-log-in']) !!}
                {!! link_to_route('register', ' ユーザー登録', null, ['class' => 'list-group-item glyphicon glyphicon-pencil']) !!}
            @else
                {!! link_to_route('users.profile', ' プロフィール', ['id' => Auth::user()->id], ['class' => 'list-group-item glyphicon glyphicon-list-alt']) !!}
                {!! link_to_route('users.friend_list', ' 友達一覧', ['id' => Auth::user()->id], ['class' => 'list-group-item glyphicon glyphicon-user']) !!}
                <a href="{{ route('logout') }}" class = "list-group-item glyphicon glyphicon-log-out" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> ログアウト</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            @endguest
        </div>
    </nav>
</div>