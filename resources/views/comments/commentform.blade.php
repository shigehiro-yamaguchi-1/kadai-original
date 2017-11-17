{!! Form::open(['route' => ['comment.new', $item->id]]) !!}
    {!! Form::textarea('comment', null, [
                                            'class' => 'form-control input-sm',
                                            'rows' => 3,
                                            'placeholder' => 'コメントを書く（50文字まで）'
                                        ]) !!}
    {!! Form::hidden('comment_user_id', \Auth::user()->id ) !!}
    {!! Form::button('<i class="glyphicon glyphicon-arrow-up"></i> 送信', array('type' => 'submit', 'class' => 'btn btn-success')) !!}
    {{ csrf_field() }}
{!! Form::close() !!}