@extends('layouts.default')

@section('content')
    <div>
        {{$user[0]['name']}}さんの友達一覧（{{$count_friends}}人）
        <div>
            <table class="table table-hover">
                <tbody>
                    @foreach ($friends as $friend)
                        <tr>
                            <td>{!! link_to_route('users.profile', $friend->name, ['id' => $friend->id]) !!}</td>
                        </tr>
                    @endforeach
             </tbody>
            </table>
        </div>
    </div>
@endsection
