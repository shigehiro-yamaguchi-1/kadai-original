{!! Form::open(['route' => 'm_items.store', 'method' => 'post']) !!}
    {!! Form::select('year', $years, null) !!}
    {!! Form::select('season', $seasons, null) !!}
    {!! Form::submit('アイテム追加', ['class' => 'btn btn-warning']) !!}
    {{ csrf_field() }}
{!! Form::close() !!}
