@if (Auth::user()->is_low_rating($item->id))
    {!! Form::open(['route' => 'item.un_low_rate', 'method' => 'delete']) !!}
        {!! Form::hidden('itemId', $item->id) !!}
        {!! Form::button($low_rate_name, array('type' => 'submit', 'class' => 'btn btn-danger')) !!}
        {{ csrf_field() }}
    {!! Form::close() !!}
@else
    {!! Form::open(['route' => 'item.low_rate']) !!}
        {!! Form::hidden('itemId', $item->id) !!}
        {!! Form::button($low_rate_name, array('type' => 'submit', 'class' => 'btn btn-default')) !!}
        {{ csrf_field() }}
    {!! Form::close() !!}
@endif