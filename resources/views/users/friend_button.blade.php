@if (\Auth::user()->id !== $user[0]['id'])
    @if (Auth::user()->is_friends($user[0]['id']))
        {!! Form::open(['route' => ['user.unfriend', $user[0]['id']], 'method' => 'delete']) !!}
            {!! Form::button('<i class="glyphicon glyphicon-heart-empty"></i> 友達解除', array('type' => 'submit', 'class' => 'btn btn-danger')) !!}
            {{ csrf_field() }}
        {!! Form::close() !!}
    @else
        {!! Form::open(['route' => ['user.friend', $user[0]['id']]]) !!}
            {!! Form::button('<i class="glyphicon glyphicon-heart"></i> 友達追加', array('type' => 'submit', 'class' => 'btn btn-success')) !!}
            {{ csrf_field() }}
        {!! Form::close() !!}
    @endif
@endif