<?php $_COOKIE['StrID'] = 'jacky0996';
?>
@extends('layouts.app2')
@section('title', '《黑色契約CABAL Online》序號兌換')
@section('link')
    <link rel="stylesheet" href="/css/home_page/number_exchange_style.css?v1.1">
@endsection
@section('main_title', '序號兌換')
@section('content')
    <div class="content_box">
        @if (isset($_COOKIE['StrID']) && isset($_COOKIE['StrID']) != null)
            <form id="logout-form" action="https://www.digeam.com/logout" method="POST" style="display: none;">
                <input type="hidden" name="return_url" id="return_url"
                    value={{ base64_encode('https://cbo.digeam.com/number_exchange') }}>
            </form>
            <div class="logout_box">
                <div class="name">Hi! 目前登入的帳號是 ：{{ $_COOKIE['StrID'] }}</div>
                <div class="logout">登出</div>
            </div>
        @else
            <div class="login_box">
                <div class="login_text">請先登入</div>
                <div class="login">登入</div>
            </div>
        @endif
        <div class="bottom-box">
            <div class="left_box">
                <div class="input_box">
                    <p>序號</p>
                    <input type="text" placeholder="請輸入序號" class="input" />
                </div>
                <div class="btn_box_s">
                    {{-- <a href="https://www.digeam.com/member/coupon" target="_blank">
                        <div class="btn_s">序號查詢</div>
                    </a> --}}
                    @if (isset($_COOKIE['StrID']) && isset($_COOKIE['StrID']) != null)
                        <div class="btn_s already_login">確定兌換</div>
                    @else
                        <div class="btn_s not_login">確定兌換</div>
                    @endif
                </div>
            </div>
            <div class="right_box">
                <p>注意事項</p>
                <ol>
                    <li>序號兌換成功後，系統將以信件方式發送獎勵，請登入遊戲內進行領取。​</li>
                    <li>請留意序號使用條件及兌換期限，若未達到使用條件或超過兌換期限將無法進行兌換。​</li>
                    <li>一組序號於同一帳號內僅可使用一次，使用後無法再重複領取同一組序號。​</li>
                    <li>若有任何疑問，請聯繫「客服中心」提供協助。​</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // 已登入
        $('.already_login').on('click', function() {
            $.post('/api/exchange', {
                'number': $('.input').val()
            }, function(res) {
                if (res.status == -99) {
                    Swal.fire({
                        icon: 'error',
                        title: '兌換失敗',
                        text: '您還沒有遊戲角色,請先開始遊戲後再兌換',
                    })
                } else if (res.status == -98) {
                    Swal.fire({
                        icon: 'error',
                        title: '兌換失敗',
                        text: '請確認輸入的序號是否正確',
                    })
                } else if (res.status == -97) {
                    Swal.fire({
                        icon: 'error',
                        title: '兌換失敗',
                        text: '此序號已被使用',
                    })
                } else if (res.status == -96) {
                    Swal.fire({
                        icon: 'error',
                        title: '兌換失敗',
                        text: '序號不在可使用時間內',
                    })
                } else if (res.status == -95) {
                    Swal.fire({
                        icon: 'error',
                        title: '兌換失敗',
                        text: '您已參加過活動囉',
                    })
                } else if (res.status == -94) {
                    Swal.fire({
                        icon: 'error',
                        title: '兌換失敗',
                        text: '序號已兌換完畢',
                    })
                } else if (res.status == 1) {
                    Swal.fire('兌換成功！請至遊戲內收取道具')
                }
            })
        })
        // 未登入
        $('.not_login').on('click', function() {
            Swal.fire('請先登入')
        })

        // 登出
        $('.logout').on('click', function() {
            $('#logout-form').submit()
        })
        // 登入
        $('.login').on('click', function() {
            location.href = 'https://digeam.com/login'
        })
    </script>
@endsection
