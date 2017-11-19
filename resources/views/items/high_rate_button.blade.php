@if (Auth::user()->is_high_rating($item->id))
    {!! Form::open(['route' => 'item.un_high_rate', 'method' => 'delete']) !!}
        {!! Form::hidden('itemId', $item->id) !!}
        {!! Form::button($high_rate_name, array('type' => 'submit', 'class' => 'btn btn-success')) !!}
        {{ csrf_field() }}
    {!! Form::close() !!}
@else
    {!! Form::open(['route' => 'item.high_rate']) !!}
        {!! Form::hidden('itemId', $item->id) !!}
        {!! Form::button($high_rate_name, array('type' => 'submit', 'class' => 'btn btn-default')) !!}
        {{ csrf_field() }}
    {!! Form::close() !!}
@endif