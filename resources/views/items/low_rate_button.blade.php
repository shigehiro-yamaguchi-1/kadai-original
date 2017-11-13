@if (Auth::user()->is_low_rating($item->id))
    {!! Form::open(['route' => 'item_user.dont_low_rate', 'method' => 'delete']) !!}
        {!! Form::hidden('itemId', $item->id) !!}
        {!! Form::submit(\Config::get('type.low_rate_name'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@else
    {!! Form::open(['route' => 'item_user.low_rate']) !!}
        {!! Form::hidden('itemId', $item->id) !!}
        {!! Form::submit(\Config::get('type.low_rate_name'), ['class' => 'btn btn-default']) !!}
    {!! Form::close() !!}
@endif