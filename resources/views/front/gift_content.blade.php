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

    <div class="event_gift_box">
        <div class="title">{{ $giftCreate['title'] }}</div>
        <div class="line"></div>



        @if (isset($_COOKIE['StrID']) && isset($_COOKIE['StrID']) != null)
            <form id="logout-form" action="https://www.digeam.com/logout" method="POST" style="display: none;">
                <input type="hidden" name="return_url" id="return_url"
                    value={{ base64_encode('https://cbo.digeam.com/gift') }}>
            </form>
            <div class="logout_box">
                <div class="name">Hi! 目前登入的帳號是 ：{{ $_COOKIE['StrID'] }}</div>
                <div class="logout">登出</div>
            </div>
        @else
            <div class="login_box">
                <div class="login_text">請先登入</div>
                <div class="login" id='login'>登入</div>
            </div>
        @endif


        <table>
            <tr class="tab_head_s">
                <td width='90'>活動名稱</td>
                <td width='150'>活動獎勵</td>
                <td width='150'>說明</td>
                <td width='10'>領取狀態</td>
            </tr>

            @foreach ($giftGroup as $value)
                <tr>
                    <td style="text-align: left;">{{ $value['title'] }}</td>
                    <td style="text-align: left;">{!! nl2br($value['item']) !!}</td>
                    <td style="text-align: left;">{!! nl2br($value['desc']) !!}</td>
                    <td>
                        @if (isset($_COOKIE['StrID']) && isset($_COOKIE['StrID']) != null)
                            @if ($value['already_get'] == 'n')
                                <div class="btn_s" data-val={{ $value['id'] }}>領取</div>
                            @else
                                <div class="btn_s_gray">已領取</div>
                            @endif
                        @else
                            <div class="btn_s_gray">領取</div>
                        @endif
                    </td>
                </tr>
            @endforeach



        </table>
    </div>

@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/js/home_page/gift.js?v1.33"></script>
@endsection
