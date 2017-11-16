@if (Auth::user()->is_high_rating($item->id))
    {!! Form::open(['route' => 'item.dont_high_rate', 'method' => 'delete']) !!}
        {!! Form::hidden('itemId', $item->id) !!}
        {!! Form::submit(\Config::get('anime_type.high_rate_name'), ['class' => 'btn btn-success']) !!}
        {{ csrf_field() }}
    {!! Form::close() !!}
@else
    {!! Form::open(['route' => 'item.high_rate']) !!}
        {!! Form::hidden('itemId', $item->id) !!}
        {!! Form::submit(\Config::get('anime_type.high_rate_name'), ['class' => 'btn btn-default']) !!}
        {{ csrf_field() }}
    {!! Form::close() !!}
@endif