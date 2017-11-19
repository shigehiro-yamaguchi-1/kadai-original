@extends('layouts.default')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">ユーザーログイン</div>

        <div class="panel-body">
            <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-4 control-label">メールアドレス</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="col-md-4 control-label">パスワード</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control" name="password" required>

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> 次回から省略する
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-8 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            ログイン
                        </button>

                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            パスワードをお忘れの方はこちら
                        </a>
                    </div>
                </div>

                <!-- ソーシャルログイン -->
                <div class="form-group">
                    <div class="col-md-4 col-md-offset-4">
                        <a class="btn btn-social btn-twitter"  href="auth/twitter">
                            <span class="fa fa-twitter"></span> Sign in with Twitter
                        </a>
                        
                        <!--<a class="btn btn-block btn-social btn-facebook" href="auth/facebook">-->
                        <!--    <span class="fa fa-facebook"></span> Sign in with Facebook-->
                        <!--</a>-->
                        
                        <a class="btn btn-social btn-google"  href="auth/google">
                            <span class="fa fa-google"></span> Sign in with Google
                        </a>
                    </div>
                </div>
                <!-- /ソーシャルログイン -->

            </form>
        </div>
    </div>
@endsection
