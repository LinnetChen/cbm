<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta property="og:title" content="《黑色契約CABAL Online》涅瓦雷斯人才招募中心啟動" />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="《黑色契約CABAL Online》涅瓦雷斯人才招募中心啟動" />
    <meta property="og:url" content="《黑色契約CABAL Online》涅瓦雷斯人才招募中心啟動" />
    <meta property="og:site_name" content="" />
    <meta property="og:locale" content="zh_tw" />
    <meta property="article:author" content="" />
    <meta property="og:image" content="/img/event/20240329/fb_share.png" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="628" />
    <meta name="author" content="DiGeam" />
    <meta name="Resource-type" content="Document" />
    <link rel="icon" sizes="192x192" href="/img/event/20230728/favicon.ico">
    <meta name="description" content="《黑色契約CABAL Online》涅瓦雷斯人才招募中心啟動" />
    <title>《黑色契約CABAL Online》涅瓦雷斯人才招募中心啟動</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vue3-slick-carousel@1.0.6/src/slick-theme.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/event/20240329/style.css">
</head>
<body>
    <div class="pop">
        <div class="pop_wrap">
            
        </div>
        <button class="close" onclick="close_pop()">✖</button>
    </div>
    <div class="popL">
        <div class="pop_wrap">
            
        </div>
        <button class="btn" onclick="close_pop()">確定</button>
    </div>
    <div class="popS">
        <div class="pop_wrapS">
        </div>
    </div>
    <div class="mask"></div>
    <div class="wrap" id="wrap">
        <div class="topBar">
            <div class="topBox">
                <a class="topBtn" href="">Mobile事前預約</a>
                <p class="topLine">|</p>
                <a class="topBtn" href="">聯動活動</a>
                <p class="topLine">|</p>
                <a class="topBtn_h" href="">涅瓦雷斯人才招募中心​</a>
            </div>            
        </div>
        <div class="section01">
            <img class="s1Tit" src="img/event/20240329/s1Tit.png" >
            <a class="logo" href="https://cbo.digeam.com/index" target="_blank"></a>
            <div class="s1BtnBox">
                <a class="s1Btn" href="https://www.digeam.com/register"target="_blank">會員註冊</a>
                <a class="s1Btn" href="https://cbo.digeam.com/game"target="_blank">遊戲下載</a>
            </div>
        </div>
        <div class="section02">
            <div class="s2Content">
                <div class="imgContainer">
                    <div data-aos="zoom-in-up">
                        <img class="s2People" src="img/event/20240329/s2People.png" >
                    </div>
                    <div data-aos="zoom-in-up">
                        <img class="s2Tit" src="img/event/20240329/s2Tit.png">
                    </div>
                    
                </div>
                <div class="s2Container">
                    <div class="actBox">
                        @if(isset($_COOKIE['StrID']))
                        <p class="loginUser" style="display: none">{{ $_COOKIE['StrID'] }}</p>
                        @endif
                        <p class="s2FontBlue">【EVENT 1　這小老弟我罩的】</p>
                        <p class="s2FontRed">綁定活躍玩家，立即領取專屬獎勵！</p>
                        <div class="s2BtnBox">
                            <button class="s2Btn event01" id="event01">進行綁定</button>
                            <button class="s2Act act01">如何獲取綁定碼</button>
                        </div>
                        <div class="line"></div>
                        <p class="s2FontBlue">【EVENT 2　洞六洞洞，部隊起床】</p>
                        <p class="s2FontRed">每日6點後達成指定條件<br>活躍玩家與新手/回歸玩家一起獲取大量資源補給卡！</p>
                        <div class="s2BtnBox">
                            <button class="s2Btn event02" id="event02">獎勵領取 </button>
                            <button class="s2Act act02">活動說明</button>
                        </div>
                        <div class="line"></div>
                        <p class="s2FontBlue">【EVENT 3　師長，給他一張志願留營表】</p>
                        <p class="s2FontRed">購買「白金之翼(30日)」享買一送一優惠。<br>綁定的活躍玩家再獲得「白金之翼(30日)75折折扣券」！</p>
                        <div class="s2BtnBox">
                            <button class="s2Btn event03" id="event03">領取獎勵 </button>
                            <button class="s2Act act03">活動說明</button>
                        </div>
                        <div class="line"></div>
                        <p class="s2FontBlue">【EVENT 4　升級好禮拿不完】</p>
                        <p class="s2FontRed">160級前享300%經驗值加成<br>達到指定等級再獲得大量獎勵道具！</p>
                        <div class="s2BtnBox">
                            <button class="s2Act act04">詳細資訊</button>
                        </div>
                        
                    </div>
                    
                </div>   
            </div>
        </div>
        <footer>
            <div class="footerbox">
                <div class="footerbox_logo">
                    <a href="https://www.digeam.com/index" target="_blank" class="logo_digeam"><img class="digeamlogo" src="img/event/20240329/logo_digeam.png"></a>
                    <a class="logo_rw"><img class="ESTlogo" src="img/event/20240329/est.png"></a>
                </div>
                <div class="spec">
                    <a href="https://www.digeam.com/terms" target="_blank">會員服務條款</a>
                    <a href="https://www.digeam.com/terms2" target="_blank">隱私條款</a>
                    <a href="https://www.digeam.com/cs" target="_blank">客服中心</a>
                    <p class="Copyright">Copyright © ESTgames Corp. All rights reserved.<br />2023 Licensed and
                        publishedfor Taiwan, Hong Kong and Macau by DiGeam Co.,Ltd<br />CABAL Online is a registered trademark of
                        ESTgames Corp (and the logo of ESTgames).</p>
                </div>
                <div class="classlavel">
                    <div><img src="img/event/20240329/icon_15.png" alt="輔15級"></div>
                    <ul>
                        <li>本遊戲為免費使用，部分內容涉及暴力情節。</li>
                        <li>遊戲內另提供購買虛擬遊戲幣、物品等付費服務。</li>
                        <li>請注意遊戲時間，避免沉迷。</li>
                        <li style="color: rgb(159, 229, 255);">本遊戲服務區域包含台灣、香港、澳門。</li>
                    </ul>
                </div>
            </div>
        </footer>
        
    </div>
    <script src="js/event/base/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="js/event/20240329/view.js"></script>    
    <script src="js/event/20240329/main.js?v=1.1.5"></script>    
    <script>
        $(function(){
            AOS.init();
        })
    </script>
</body>
</html>