@extends('layouts.default')

@section('content')
    <div>
        <div>
            <h1>{{$user[0]['name']}}さんのプロフィール</h1>
            <table class="table">
                <tbody>
                    <tr>
                        <td width="20%">名前</td><td>{{$user[0]['name']}}</td>
                    </tr>
                    @if (\Auth::user()->id === $user[0]['id'])
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

        <div>
            <h1>{{$user[0]['name']}}さんの視聴アニメ</h1>
            <table class="table table-hover table-color">
                <tbody class="evaluate_color">
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
$('.evaluate_color tr').each(function() {
    var text = $('td', this).eq(1).text();
    if (text == high_rate_name) {
        $(this).css('background-color', '#f6fff7');
    } else {
        $(this).css('background-color', '#ffd5d529');
    }
});
</script>

@endsection