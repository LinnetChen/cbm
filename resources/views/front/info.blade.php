@extends('layouts.app2')
@section('title',"《黑色契約CABAL Online》遊戲公告")
@section('link')
<link rel="stylesheet" href="/css/home_page/info_style.css">
@endsection
@section('main_title',"遊戲公告")
@section('content')
<div class="info">
    <div class="info_topbox">
        <div class="info_tab">
            <button class="active tab_button" data-target="#info_all">
                綜合
            </button>
            <button class="tab_button" data-target="#info_event">活動</button>
            <button class="tab_button" data-target="#info_system">系統</button>
        </div>
    </div>
    <div class="info_container">
        <div class="info_box active" id="info_all">
            <ul class="textUITOP">
                <li><a class="textbox" href="https://rco.digeam.com/">
                        <div class="info_title">公告內容內容內容內容內容內容內容內容內容內容</div>
                        <div class="info_date">2023/08/29</div>
                    </a></li>
            </ul>
            <ul class="textUINEW">
                <li><a class="textbox" href="https://rco.digeam.com/">
                        <div class="info_title">公告內容內容內容內容內容內容內容內容內容內容</div>
                        <div class="info_date">2023/08/29</div>
                    </a></li>
            </ul>
            <ul class="textUInormal">
                <li><a class="textbox" href="https://rco.digeam.com/">
                        <div class="info_title">公告內容內容內容內容內容內容內容內容內容內容</div>
                        <div class="info_date">2023/08/29</div>
                    </a></li>
            </ul>
            <ul class="textUInormal">
                <li><a class="textbox" href="https://rco.digeam.com/">
                        <div class="info_title">公告內容內容內容內容內容內容內容內容內容內容</div>
                        <div class="info_date">2023/08/29</div>
                    </a></li>
            </ul>
            <ul class="textUInormal">
                <li><a class="textbox" href="https://rco.digeam.com/">
                        <div class="info_title">公告內容內容內容內容內容內容內容內容內容內容</div>
                        <div class="info_date">2023/08/29</div>
                    </a></li>
            </ul>
            <ul class="textUInormal">
                <li><a class="textbox" href="https://rco.digeam.com/">
                        <div class="info_title">公告內容內容內容內容內容內容內容內容內容內容</div>
                        <div class="info_date">2023/08/29</div>
                    </a></li>
            </ul>
            <ul class="textUInormal">
                <li><a class="textbox" href="https://rco.digeam.com/">
                        <div class="info_title">公告內容內容內容內容內容內容內容內容內容內容</div>
                        <div class="info_date">2023/08/29</div>
                    </a></li>
            </ul>
            <ul class="textUInormal">
                <li><a class="textbox" href="https://rco.digeam.com/">
                        <div class="info_title">公告內容內容內容內容內容內容內容內容內容內容</div>
                        <div class="info_date">2023/08/29</div>
                    </a></li>
            </ul>
            <ul class="textUInormal">
                <li><a class="textbox" href="https://rco.digeam.com/">
                        <div class="info_title">公告內容內容內容內容內容內容內容內容內容內容</div>
                        <div class="info_date">2023/08/29</div>
                    </a></li>
            </ul>
            <ul class="textUInormal">
                <li><a class="textbox" href="https://rco.digeam.com/">
                        <div class="info_title">公告內容內容內容內容內容內容內容內容內容內容</div>
                        <div class="info_date">2023/08/29</div>
                    </a></li>
            </ul>
        </div>
        <div class="info_box" id="info_event">
            <ul class="textUITOP">
                <li><a class="textbox" href="https://rco.digeam.com/">
                        <div class="info_title">公告內容內容內容內容內容內容內容內容內容內容</div>
                        <div class="info_date">2023/08/29</div>
                    </a></li>
            </ul>
        </div>
        <div class="info_box" id="info_system">
            <ul class="textUINEW">
                <li><a class="textbox" href="https://rco.digeam.com/">
                        <div class="info_title">公告內容內容內容內容內容內容內容內容內容內容</div>
                        <div class="info_date">2023/08/29</div>
                    </a></li>
            </ul>
        </div>
    </div>
    <!--頁碼-->
<!--     <nav>
        <ul class="pagination">
            <li class="page-item disabled" aria-disabled="true" aria-label="« Previous">
                 <a class="page-link" href="" rel="next" aria-label="Next »">上一頁</span>
            </li>
            <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
            <li class="page-item"><a class="page-link" href="">2</a></li>
            <li class="page-item">
                <a class="page-link" href="" rel="next" aria-label="Next »">下一頁</a>
            </li>
        </ul>
    </nav> -->
</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    $('.tab_button').click(function() {
        var target = $(this).data('target');
        $(target).show().siblings('.info_box').hide();
        $(this).addClass('active').siblings('.active').removeClass('active');
    });
</script>
@endsection