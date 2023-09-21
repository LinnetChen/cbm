<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta property="og:title" content="《黑色契約CABAL Online》維基百科" />
    <meta property="og:type" content="website" />
    <!--     <meta property="og:description" content="歡迎回到涅瓦雷斯大陸，我們的旅途尚未結束..." /> -->
    <meta property="og:url" content="" />
    <meta property="og:site_name" content="" />
    <meta property="og:locale" content="zh_tw" />
    <meta property="article:author" content="" />
    <meta property="og:image" content="../../../img/home_page/wiki/fb_share.jpg" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="628" />
    <meta name="author" content="DiGeam" />
    <meta name="Resource-type" content="Document" />
    <link rel="icon" sizes="192x192" href="../../../img/event/20230728/favicon.ico">
    <meta name="description" content="《黑色契約CABAL Online》維基百科" />
    <link rel="pingback" href="" />
    <link href="/css/home_page/wiki_style_search.css?v1.0" rel="stylesheet">
    <title>《黑色契約CABAL Online》維基百科</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC&display=swap" rel="stylesheet">
</head>

<body>
    <div class="bg">
        <div class="big_box">
            <div class="leftbox">
                <a class="logo" href="https://cbo.digeam.com/MembershipTransfer" target="_blank"><img
                        src="../../img/home_page/CabalLogo.png"></a>
                <form method="post" action=".php">
                    <input class="search-bar" type="search" placeholder="輸入關鍵字搜尋" name="search">
                </form>
                <ul class="container">
                    <li>
                        @foreach ($side as $key => $value)
                            @if ($value['have_cate'] == true)
                                <ul class="font_title">{{ $value['cate_title'] }}
                                    <div class="libox">
                                        @foreach ($sideContent[$key] as $value_2)
                                            <li class="font_list" data-id="{{ $value_2['id'] }}"><a
                                                    href="{{ route('wiki', $value_2['id']) }}">{{ $value_2['title'] }}</a>
                                            </li>
                                        @endforeach
                                    </div>
                                </ul>
                            @else
                                <ul class="font_title">
                                    <a href="{{ route('wiki', $value['id']) }}">{{ $value['cate_title'] }}</a>
                                </ul>
                            @endif
                        @endforeach
                    </li>
                </ul>
            </div>
            <div class="right_box">
                <div class="topbox">
                    <div class="box">
                        <p>遊戲指南</p>
                    </div>
                    <div class="menu">
                        <a href="https://cbo.digeam.com/MembershipTransfer" target="_blank"><img
                                src="../../img/home_page/home_icon.png" class="img"></a>
                        <a href="https://cbo.digeam.com/MembershipTransfer" target="_blank"><img
                                src="../../img/home_page/dc_icon.png" class="img"></a>
                        <a href="https://www.facebook.com/DiGeamCabal" target="_blank"><img
                                src="../../img/home_page/fb_icon.png" class="img"></a>
                    </div>
                </div>
                <div class="bottombox">
                    @if (count($page) == 0)
                        <div class="title">找不到</div>
                        <div class="contantbox">
                            <p>您輸入的關鍵字找不到任何相關文章喔！！</p>
                            {{-- <button class="read">繼續閱讀→</button> --}}
                        </div>
                    @else
                        @foreach ($page as $value)
                            <div class="title">{{ $value['title'] }}</div>
                            <div class="contantbox">
                                <div class='text_box'>
                                    <p>{!! $value['content'] !!}
                                </div>
                                <a>
                                    <div class="read">繼續閱讀→</div>
                                </a>
                            </div>
                        @endforeach
                    @endif

                    <hr class="hr2" />
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
                                <p>CABAL Online is a registered trademark of ESTgames Corp (and the logo of ESTgames).
                                </p>
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
            </div>
        </div>
    </div>
</body>

</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    $(".font_title").click(function() {
        var _this = $(this).find(".libox");
        _this.slideToggle();
        // $(this).find(".libox").slideToggle();
    });

    // 表單送出停止冒泡
    $('form').on('submit', function(e) {
        e.preventDefault()
        let _search = $('.search-bar').val();
        if (_search == '') {
            alert('請輸入要找尋的關鍵字喔！')
        } else {
            document.location.href = '/wiki_search/' + _search
        }
    })
</script>
