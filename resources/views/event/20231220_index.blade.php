<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta property="og:title" content="《黑色契約CABAL Online》聖誕消費節 夜夜瘋搶購" />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="《黑色契約CABAL Online》 聖誕消費節 夜夜瘋搶購" />
    <meta property="og:url" content="《黑色契約CABAL Online》 聖誕消費節 夜夜瘋搶購" />
    <meta property="og:site_name" content="" />
    <meta property="og:locale" content="zh_tw" />
    <meta property="article:author" content="" />
    <meta property="og:image" content="/img/event/20231220/share_bg.jpg" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="628" />
    <meta name="author" content="DiGeam" />
    <meta name="Resource-type" content="Document" />
    <link rel="icon" sizes="192x192" href="/img/event/20230728/favicon.ico">
    <meta name="description" content="《黑色契約CABAL Online》 聖誕消費節 夜夜瘋搶購" />
    <title>《黑色契約CABAL Online》聖誕消費節 夜夜瘋搶購</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/event/20231220/style.css">
</head>

<body>
    <div class="pop">
        <div class="pop_wrap">
        </div>
        <button class="btn" onclick="close_pop()">確定</button>
    </div>
    <div class="pop_s">
        <div class="pop_wrap">
        </div>
        <button class="btn" onclick="close_pop()">確定</button>
    </div>

    <div class="pop_buy">
        <div class="pop_wrap">
        </div>
        <div class="btn_box">
        </div>
    </div>
    <div class="refresh_text">
        <p class="text">賣場刷新中...</p>
    </div>
    <div class="mask"></div>
    <div class="inner">
        <div class="star_light"></div>
        <div class="star_light2"></div>
        <!-- top_bar -->
        <a href="https://cbo.digeam.com/" target="_blank">
            <div class="logo"></div>
        </a>
        <div class="line_box">
            <div class="line1"></div>
            <div class="line2"></div>
            <div class="line3"></div>
        </div>

        <!-- 判斷登入 -->
         @if (isset($_COOKIE['StrID']) && isset($_COOKIE['StrID']) != null)
        <form id="logout-form" action="https://www.digeam.com/logout" method="POST" style="display: none;">
            <input type="hidden" name="return_url" id="return_url" value={{ base64_encode('https://cbo.digeam.com/MembershipTransfer') }}>
        </form>
        <div class="ball_name">
            <p class="blue">當前帳號</p>
            <p class="name">{{ $_COOKIE['StrID'] }}</p>
        </div>
        <div class="ball_point">
            <p class="blue">持有點數</p>
            <p class="point"></p>
        </div>
        <a href="https://www.digeam.com/logout" class="ball_a">
            <div class="ball_logout">登出</div>
        </a>
        @else
        <form id="logout-form" action="https://www.digeam.com/logout" method="POST" style="display: none;">
            <input type="hidden" name="return_url" id="return_url" value={{ base64_encode('https://cbo.digeam.com/MembershipTransfer') }}>
        </form>
        <div class="ball_name_n">
        </div>
        <div class="ball_point_n">
        </div>
        <a href="https://www.digeam.com/login" class="ball_a">
            <div class="ball_login">登入</div>
        </a>
        @endif

        <!--<div class="ball_name">
            <p class="blue">當前帳號</p>
            <p class="name">skyfull0411</p>
        </div>
        <div class="ball_point">
            <p class="blue">持有點數</p>
            <p class="point"></p>
        </div>
        <a href="https://www.digeam.com/logout" class="ball_a">
            <div class="ball_logout">登出</div>
        </a> -->

        <!-- 側bar -->
        <div class="right_bar">
            <div class="right_btn_pop" data-pop="event">活動說明</div>
            <div class="right_btn_pop history">購買紀錄</div>
            <a href="https://digeam.com/member/billing" target="_blank">
                <div class="right_btn">立即儲值</div>
            </a>
        </div>
        <div class="title"></div>
        <div class="info_tab">
            <div class="tab_btn active" data-target="#ice">冰珀星</div>
            <div class="tab_btn" data-target="#black">黑恆星</div>
        </div>
        <!--  賣場 -->
        <div class="sell_box_bg">
            <div class="time_mask">
                <p>活動尚未開始</p>
                <p><span>（活動時間：12/20–12/25每晚18–22點）</span></p>
            </div>
            <!-- 冰珀星 -->
            <div class="sell" id="ice">
                <div class="item_box">
                    <div class="content">
                        <div class="item" data-id="">
                            <div class="hover_info">
                            </div>
                        </div>
                        <div class="sell_info">
                            <p>當前價格<span class="price"></span></p>
                            <p>剩餘數量<span class="quantity"></span></p>
                        </div>
                    </div>
                    <button class="btn" id="">購買</button>
                </div>
                <div class="item_box">
                    <div class="content">
                        <div class="item" data-id="">
                            <div class="hover_info">
                            </div>
                        </div>
                        <div class="sell_info">
                            <p>當前價格<span class="price"></span></p>
                            <p>剩餘數量<span class="quantity"></span></p>
                        </div>
                    </div>
                    <button class="btn" id="">購買</button>
                </div>
                <div class="item_box">
                    <div class="content">
                        <div class="item" data-id="">
                            <div class="hover_info">
                            </div>
                        </div>
                        <div class="sell_info">
                            <p>當前價格<span class="price"></span></p>
                            <p>剩餘數量<span class="quantity"></span></p>
                        </div>
                    </div>
                    <button class="btn" id="">購買</button>
                </div>
                <div class="item_box">
                    <div class="content">
                        <div class="item" data-id="">
                            <div class="hover_info">
                            </div>
                        </div>
                        <div class="sell_info">
                            <p>當前價格<span class="price"></span></p>
                            <p>剩餘數量<span class="quantity"></span></p>
                        </div>
                    </div>
                    <button class="btn" id="">購買</button>
                </div>
                <div class="item_box">
                    <div class="content">
                        <div class="item" data-id="">
                            <div class="hover_info">
                            </div>
                        </div>
                        <div class="sell_info">
                            <p>當前價格<span class="price"></span></p>
                            <p>剩餘數量<span class="quantity"></span></p>
                        </div>
                    </div>
                    <button class="btn" id="">購買</button>
                </div>
                <div class="item_box">
                    <div class="content">
                        <div class="item" data-id="">
                            <div class="hover_info">
                            </div>
                        </div>
                        <div class="sell_info">
                            <p>當前價格<span class="price"></span></p>
                            <p>剩餘數量<span class="quantity"></span></p>
                        </div>
                    </div>
                    <button class="btn" id="">購買</button>
                </div>
            </div>
            <!-- 黑恆星 -->
            <div class="sell" id="black">
                <div class="item_box">
                    <div class="content">
                        <div class="item" data-id="">
                            <div class="hover_info">
                            </div>
                        </div>
                        <div class="sell_info">
                            <p>當前價格<span class="price"></span></p>
                            <p>剩餘數量<span class="quantity"></span></p>
                        </div>
                    </div>
                    <button class="btn" id="">購買</button>
                </div>
                <div class="item_box">
                    <div class="content">
                        <div class="item" data-id="">
                            <div class="hover_info">
                            </div>
                        </div>
                        <div class="sell_info">
                            <p>當前價格<span class="price"></span></p>
                            <p>剩餘數量<span class="quantity"></span></p>
                        </div>
                    </div>
                    <button class="btn" id="">購買</button>
                </div>
                <div class="item_box">
                    <div class="content">
                        <div class="item" data-id="">
                            <div class="hover_info">
                            </div>
                        </div>
                        <div class="sell_info">
                            <p>當前價格<span class="price"></span></p>
                            <p>剩餘數量<span class="quantity"></span></p>
                        </div>
                    </div>
                    <button class="btn" id="">購買</button>
                </div>
                <div class="item_box">
                    <div class="content">
                        <div class="item" data-id="">
                            <div class="hover_info">
                            </div>
                        </div>
                        <div class="sell_info">
                            <p>當前價格<span class="price"></span></p>
                            <p>剩餘數量<span class="quantity"></span></p>
                        </div>
                    </div>
                    <button class="btn" id="">購買</button>
                </div>
                <div class="item_box">
                    <div class="content">
                        <div class="item" data-id="">
                            <div class="hover_info">
                            </div>
                        </div>
                        <div class="sell_info">
                            <p>當前價格<span class="price"></span></p>
                            <p>剩餘數量<span class="quantity"></span></p>
                        </div>
                    </div>
                    <button class="btn" id="">購買</button>
                </div>
                <div class="item_box">
                    <div class="content">
                        <div class="item" data-id="">
                            <div class="hover_info">
                            </div>
                        </div>
                        <div class="sell_info">
                            <p>當前價格<span class="price"></span></p>
                            <p>剩餘數量<span class="quantity"></span></p>
                        </div>
                    </div>
                    <button class="btn" id="">購買</button>
                </div>
            </div>
            <!-- 1元商品 -->
            <div class="item_box_1">
                <div class="content">
                    <div class="ribbon_content">
                        <span class="ribbon">每小時刷新</span>
                    </div>
                    <div class="item" data-id="">
                        <div class="hover_info">
                        </div>
                    </div>
                    <div class="sell_info">
                        <p>價格<span>1</span></p>
                    </div>
                </div>
                <button class="btn" id="">購買</button>
            </div>
            <div class="tip">將滑鼠移動到商品圖示上</br>可查看詳細說明。</div>
            <div class="refresh_btn"></div>
        </div>
        <div class="footer">
            <a href="https://www.digeam.com/index" target="_blank">
                <div class="digeam"></div>
            </a>
            <div class="est"></div>
            <div>
                <a href="https://www.digeam.com/terms?_gl=1*prkbqn*_ga*MTI0MjkwMTA3Mi4xNjg3MjI2NjQx*_ga_3YHH2V2WHK*MTY5Mjc4MTA3My4xNy4wLjE2OTI3ODEwNzMuNjAuMC4w" target="_blank" class="linkp">會員服務條款</a>
                <a href="https://www.digeam.com/terms2?_gl=1*c9toqi*_ga*MTI0MjkwMTA3Mi4xNjg3MjI2NjQx*_ga_3YHH2V2WHK*MTY5Mjc4MTA3My4xNy4wLjE2OTI3ODEwNzMuNjAuMC4w" target="_blank" class="linkp">隱私條款</a>
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
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
<script src="js/event/base/jquery-3.6.0.min.js"></script>
<!-- <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script> -->
<script src="js/event/20231220/main.js?v=1.0.8"></script>
<script src="js/event/20231220/view.js"></script>

</html>