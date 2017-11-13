@if (Auth::user()->is_high_rating($item->id))
    {!! Form::open(['route' => 'item_user.dont_high_rate', 'method' => 'delete']) !!}
        {!! Form::hidden('itemId', $item->id) !!}
        {!! Form::submit(\Config::get('type.high_rate_name'), ['class' => 'btn btn-success']) !!}
    {!! Form::close() !!}
@else
    {!! Form::open(['route' => 'item_user.high_rate']) !!}
        {!! Form::hidden('itemId', $item->id) !!}
        {!! Form::submit(\Config::get('type.high_rate_name'), ['class' => 'btn btn-default']) !!}
    {!! Form::close() !!}
@endif