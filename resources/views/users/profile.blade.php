@extends('layouts.default')

@section('content')
    <div>
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">
                    <h1>{{$user->name}}さんのプロフィール</h1>
                </div>
            </div>
            <table class="table">
                <tbody>
                    <tr>
                        <td width="20%">名前</td><td>{{$user->name}}</td>
                    </tr>
                    @if (\Auth::user()->id === $user->id)
                        <tr>
                            <td width="20%">メールアドレス</td><td>{{\Auth::user()->email}}</td>
                        </tr>
                    @endif
                    <tr>
                        <td width="20%">友達</td><td>{{$count_friends}}人</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="form-group">
            @include('users.friend_button')
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <h1>{{$user->name}}さんの視聴アニメ</h1>
                </div>
            </div>
            @include('items.select_year_season')
            <table class="table table-hover">
                <tbody id="evaluate_color">
                    @foreach ($evaluates as $evaluate)
                        <tr>
                            <td class="width="80%" class="text-left ellipsis"><img src = "{{ $evaluate->profile_image_url }}"> {!! link_to_route('items.item_detail', $evaluate->title, ['id' => $evaluate->id]) !!}</td>
                            <td width="20%">{!!\Config::get('anime_type.'.$evaluate->pivot->type)!!}</td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
<script>
var high_rate_name = "{!! \Config::get('anime_type.high_rate_name'); !!}";
$('#evaluate_color tr').each(function() {
    var text = $('td', this).eq(1).text();
    if (text == high_rate_name) {
        $(this).css('background-color', '#f6fff7');
    } else {
        $(this).css('background-color', '#fdefef');
    }
});
</script>

@endsection