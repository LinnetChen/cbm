<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta property="og:title" content="《黑色契約CABAL Online》" />
    <meta property="og:type" content="website" />
    <!--     <meta property="og:description" content="歡迎回到涅瓦雷斯大陸，我們的旅途尚未結束..." /> -->
    <meta property="og:url" content="" />
    <meta property="og:site_name" content="" />
    <meta property="og:locale" content="zh_tw" />
    <meta property="article:author" content="" />
    <!--     <meta property="og:image" content="../../../img/event/20230728/fb_share.jpg" /> -->
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="628" />
    <meta name="author" content="DiGeam" />
    <meta name="Resource-type" content="Document" />
    <link rel="icon" sizes="192x192" href="../../../img/event/20230728/favicon.ico">
    <meta name="description" content="《黑色契約CABAL Online》" />
    <link rel="pingback" href="" />
    <link href="/css/home_page/app3_style.css?v1.0" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC&family=Noto+Serif+TC:wght@500&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.1.0/css/swiper.min.css" rel="stylesheet" />
    <!-- 自定義標題 -->
    <title>@yield('title')</title>
    @yield('link')
</head>

<body>
    <div class="top_bar">
        <a class="logo" href="{{ route('index') }}" 2><img src="/img/home_page/CabalLogo.png"></a>
        <div class="menu">
            <a href="{{ route('info') }}">遊戲公告</a>
            <a href="{{ route('wiki') }}">遊戲百科</a>
            <a href="{{ route('download') }}">下載專區</a>
            <a href="">國家戰爭</a>
            <a href="">獎勵專區</a>
            <a href="">會員中心</a>
        </div>
        <div class="icon_menu">
            <a href="https://discord.com/invite/YyPkJrwqvs" target="_blank"><img src="/img/home_page/dc_icon.png"></a>
            <a href="https://forum.gamer.com.tw/A.php?bsn=9189" target="_blank"><img
                    src="/img/home_page/baha_icon.png"></a>
            <a href="https://www.facebook.com/DiGeamCabal/" target="_blank"><img src="/img/home_page/fb_icon.png"></a>
        </div>
    </div>
    <div class="top_box">
        <div class="menu_box">
            <div class="menu_box_s">
                <a href="{{ route('info') }}">綜合公告</a>
                <a href="{{ route('info') }}">活動公告</a>
                <a href="{{ route('info') }}">系統公告</a>
            </div>
            <div class="menu_box_s"></div>
            <div class="menu_box_s">
                <a href="{{ route('download') }}">遊戲主程式</a>
                <a href="{{ route('wallpaper_download') }}">精選桌布</a>
            </div>
            <div class="menu_box_s"></div>
            <div class="menu_box_s">
                <a href="{{ route('gift') }}">領獎專區</a>
                <a href="{{ route('number_exchange') }}">序號兌換</a>
            </div>
            <div class="menu_box_s">
                <a href="https://www.digeam.com/register">註冊會員</a>
                <a href="https://www.digeam.com/member/billing">儲值中心</a>
                <a href="https://www.digeam.com/cs/faq">FAQ</a>
                <a href="{{ route('game_religion') }}">遊戲規章</a>
                <a href="https://www.digeam.com/cs">聯繫客服</a>
                <a href="{{ route('suspension_list') }}">停權名單</a>
            </div>
        </div>
    </div>
    <div class="bg">
        <div class="main_box">
            <div class="main_btn">
                <a href="https://rco.digeam.com/">
                    <div class="download"></div>
                </a>
                <a href="https://www.digeam.com/register">
                    <div class="btn"><img src="/img/home_page/icon_rgister.png">帳號註冊</div>
                </a>
                <a href="https://www.digeam.com/member/billing">
                    <div class="btn"><img src="/img/home_page/icon_add.png">儲值中心</div>
                </a>
                <div class="btn_two">
                    <a href="https://www.digeam.com/member/enable">
                        <div class="btn_small"><img src="/img/home_page/icon_otp.png">OTP申請</div>
                    </a>
                    <a href="https://www.digeam.com/cs">
                        <div class="btn_small"><img src="/img/home_page/icon_customer.png">聯繫客服</div>
                    </a>
                </div>
            </div>
            <div class="container_box">
                <div class="main_title">
                    @yield('main_title')
                </div>
                <div class="container">
                    @yield('content')
                </div>
            </div>
        </div>
        <div class="footer">
            <a href="https://www.digeam.com/index" target="_blank">
                <div class="digeam"></div>
            </a>
            <div class="est"></div>
            <div>
                <a href="https://www.digeam.com/terms?_gl=1*prkbqn*_ga*MTI0MjkwMTA3Mi4xNjg3MjI2NjQx*_ga_3YHH2V2WHK*MTY5Mjc4MTA3My4xNy4wLjE2OTI3ODEwNzMuNjAuMC4w"
                    target="_blank" class="linkp">會員服務條款</a>
                <a href="https://www.digeam.com/terms2?_gl=1*c9toqi*_ga*MTI0MjkwMTA3Mi4xNjg3MjI2NjQx*_ga_3YHH2V2WHK*MTY5Mjc4MTA3My4xNy4wLjE2OTI3ODEwNzMuNjAuMC4w"
                    target="_blank" class="linkp">隱私條款</a>
                <a href="https://www.digeam.com/cs" target="_blank" class="linkp">客服中心</a>
                <div class="copyright">
                    <p>Copyright © ESTgames Corp. All rights reserved.</p>
                    <p>2023 Licensed and published for Taiwan, Hong Kong and Macau by DiGeam Co.,Ltd</p>
                    <p>CABAL Online is a registered trademark of ESTgames Corp (and the logo of ESTgames).</p>
                </div>
            </div>
            <div class="age"></div>
            <div>
                <p>本遊戲為免費使用，部分內容涉及暴力情節。</p>
                <p>遊戲內另提供購買虛擬遊戲幣、物品等付費服務。</p>
                <p>請注意遊戲時間，避免沉迷。</p>
                <p><span>本遊戲服務區域包含台灣、香港、澳門。</span></p>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script>
        $(function() {
            var _this = $('.top_box').find('*');
            $(_this).hover(function() {
                $('.top_box').css('height', "390px");
            });
        });
        $('.top_box').hover(function() {
            $(this).css('height', "390px");
            $('.menu_box').css('display', "flex");
        }, function() {
            $('.top_box').css('height', "0px");
        });
        $(function() {
            $('.menu').hover(function() {
                $('.top_box').css('height', "390px");
            });
        });
    </script>

    <!-- 自定義js -->
    @yield('js')
</body>

</html>
