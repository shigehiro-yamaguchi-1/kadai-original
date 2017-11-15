{!! Form::open() !!}
    {!! Form::select('year', $years, null) !!}
    {!! Form::select('season', $seasons, null) !!}
    {!! Form::submit('ランキング作成', ['class' => 'btn btn-primary']) !!}
    {{ csrf_field() }}
{!! Form::close() !!}