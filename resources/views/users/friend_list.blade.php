@extends('layouts.default')

@section('content')
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="panel-title">
            <h1>{{$user->name}}さんの友達一覧（{{$count_friends}}人）</h1>
        </div>
    </div>
    <div>
        @if (\Auth::user()->id === $user->id && $count_friends === 0)
            <p>あなたは一人じゃないd(￣ ￣)</p>
        @elseif ($count_friends === 0)
            <p>ぼっち...</p>
        @else
            <table class="table table-hover">
                <tbody>
                    @foreach ($friends as $friend)
                        <tr>
                            <td>{!! link_to_route('users.profile', $friend->name, ['id' => $friend->id]) !!}</td>
                        </tr>
                    @endforeach
                 </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
