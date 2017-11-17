{!! Form::open() !!}
    {!! Form::select('year_season', $year_seasons, null, ['class' => 'selectpicker']) !!}
    {!! Form::submit('GO', ['class' => 'btn btn-primary']) !!}
    {{ csrf_field() }}
{!! Form::close() !!}