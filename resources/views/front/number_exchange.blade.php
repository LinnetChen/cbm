@extends('layouts.app2')
@section('title',"《黑色契約CABAL Online》序號兌換")
@section('link')
<link rel="stylesheet" href="/css/home_page/number_exchange_style.css?v1.0">
@endsection
@section('main_title',"序號兌換")
@section('content')
<div class="content_box">
    <div class="login_box">
        <div class="login_text">請先登入</div>
        <div class="login">登入</div>
    </div>
    <div class="logout_box">
        <div class="name">Hi!帳號xxxx</div>
        <div class="logout">登出</div>
    </div>
    <div class="bottom-box">
        <div class="left_box">
            <div class="input_box">
                <p>序號</p>
                <input type="text" placeholder="請輸入序號" class="input" />
            </div>
            <div class="btn_box_s">
                <a href="https://www.digeam.com/member/coupon" target="_blank">
                    <div class="btn_s">序號查詢</div>
                </a>
                <div class="btn_s">確定兌換</div>
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
<script>
</script>
@endsection
