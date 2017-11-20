
{!! Form::open(['id' => 'submit_form']) !!}
    {!! Form::select('year_season', $year_seasons, null, ['class' => 'selectpicker', 'id' => 'submit_select']) !!}
    {{ csrf_field() }}
{!! Form::close() !!}

<script type="text/javascript">
$(function(){
  $("#submit_select").change(function(){
    $("#submit_form").submit();
  });
});
</script>