{!! Form::open() !!}
    {!! Form::select('year', $years, null) !!}
    {!! Form::select('season', $seasons, null) !!}
    {!! Form::submit('GO', ['class' => 'btn btn-primary']) !!}
    {{ csrf_field() }}
{!! Form::close() !!}