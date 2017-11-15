{!! Form::open(['route' => 'admin.post.home', 'method' => 'post']) !!}
    {!! Form::submit('ランキング作成', ['class' => 'btn btn-warning']) !!}
    {{ csrf_field() }}
{!! Form::close() !!}