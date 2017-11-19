@extends('layouts.default')

@section('content')
    <div>
        <div>
            <table class="table">
                <tbody>
                    <tr>
                        <td width="20%">名前</td><td>{{$user[0]['name']}}</td>
                    </tr>
                    @if (\Auth::user()->id === $user[0]['id'])
                        <tr>
                            <td width="20%">メールアドレス</td><td>{{\Auth::user()->email}}</td>
                        </tr>
                    @endif
                    <tr>
                        <td width="20%">友達</td><td>{{$count_friends}}人</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="form-group">
            @include('users.friend_button')
        </div>
    </div>
@endsection