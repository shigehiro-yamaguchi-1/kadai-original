{!! Form::open(['route' => ['comment.new', $item->id]]) !!}
    {!! Form::textarea('comment', null, [
                                            'class' => 'form-control input-sm',
                                            'rows' => 3,
                                            'placeholder' => 'コメントを書く（50文字まで）'
                                        ]) !!}
    {!! Form::hidden('comment_user_id', \Auth::user()->id ) !!}
    {!! Form::submit('送信', ['class' => 'btn btn-success']) !!}
    {{ csrf_field() }}
{!! Form::close() !!}