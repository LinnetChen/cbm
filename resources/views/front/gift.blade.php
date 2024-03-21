@extends('layouts.app2')
@section('title', '《黑色契約CABAL Online》領獎專區')
@section('link')
    <link rel="stylesheet" href="/css/home_page/gift_style.css?v1.0">
@endsection
@section('main_title', '領獎專區')
@section('content')
    <p>達成活動條件後，可以在此頁面登入並領取活動獎勵。</p>
    <div class="line"></div>
    <div class="select_box">
        <select class="section year" name="select_year">
            <option class="option" value="0">年</option>
            <option class="option" value="2023">2023</option>
            <option class="option" value="2024">2024</option>
        </select>
        <select class="section month" name="select_month">
            <option class="option" value="0">月</option>
            <option class="option" value="01">01</option>
            <option class="option" value="02">02</option>
            <option class="option" value="03">03</option>
            <option class="option" value="04">04</option>
            <option class="option" value="05">05</option>
            <option class="option" value="06">06</option>
            <option class="option" value="07">07</option>
            <option class="option" value="08">08</option>
            <option class="option" value="09">09</option>
            <option class="option" value="10">10</option>
            <option class="option" value="11">11</option>
            <option class="option" value="12">12</option>
        </select>
        <input type="text" placeholder="輸入活動關鍵字" class="input keyword" />
        <div class="login search">搜尋</div>
    </div>
    <div class="content_box">
        <table>
            <tr class="tab_head_s">
                <td>活動名稱</td>
                <td>領獎時間</td>
            </tr>
            @foreach ($list as $value)
                <tr>
                    @if ($value->type == 'active')
                        <td><a href="{{ route('prize', $value['id']) }}" class="event">{{ $value['title'] }}</a></td>
                        <td>{{ $value['start'] }}　～　{{ $value['end'] }}</td>
                    @else
                        <td><a href="{{ route('giftContent', $value['id']) }}" class="event">{{ $value['title'] }}</a></td>
                        <td>{{ $value['start'] }}　～　{{ $value['end'] }}</td>
                    @endif
                </tr>
            @endforeach
        </table>
    </div>
    {{-- 頁碼 --}}
    {!! $list->links() !!}

    {{-- <div class="event_gift_box">
    <div class="title">標題</div>
    <div class="line"></div>
    <div class="login_box">
        <div class="login_text">請先登入</div>
        <div class="login">登入</div>
    </div>
    <div class="logout_box">
        <div class="name">Hi!帳號xxxx</div>
        <div class="logout">登出</div>
    </div>
    <table>
        <tr class="tab_head_s">
            <td>活動名稱</td>
            <td>活動獎勵</td>
            <td>說明</td>
            <td>領取狀態</td>
        </tr>
        <tr>
            <td rowspan="2">連續登入一天</td>
            <td>寶物x3</td>
            <td>說明說明說明</td>
            <td>
                <div class="btn_s">領取</div>
            </td>
        </tr>
        <tr>
            <td>寶物x3</td>
            <td>說明說明說明</td>
            <td>
                <div class="btn_s_gray">領取</div>
            </td>
        </tr>
        <tr>
            <td>連續登入一天</td>
            <td>寶物x3</td>
            <td>說明說明說明</td>
            <td>
                <div class="btn_s">領取</div>
            </td>
        </tr>
    </table>
</div> --}}

@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script>
        $('.search').on('click', function() {
            location.href = '/giftSearch/' + $('.year').val() + '/' + $('.month').val() +
                '/' + $('.keyword').val()
        })
    </script>
@endsection
