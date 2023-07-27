<?php
if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
    $real_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
}else{
    $real_ip = $_SERVER["REMOTE_ADDR"];
}
if($real_ip != '211.23.144.219'){
exit();
}
?>
<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta property="og:title" content="《黑色契約CABAL Online》會員轉移" />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="歡迎回到涅瓦雷斯大陸，我們的旅途尚未結束..." />
    <meta property="og:url" content="" />
    <meta property="og:site_name" content="" />
    <meta property="og:locale" content="zh_tw" />
    <meta property="article:author" content="" />
    <meta property="og:image" content="../../../img/event/20230728/fb_share.jpg" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="628" />
    <meta name="author" content="DiGeam" />
    <meta name="Resource-type" content="Document" />
    <link rel="icon" sizes="192x192" href="../../../img/event/20230728/favicon.ico">
    <meta name="description" content="《黑色契約CABAL Online》會員轉移" />
    <link rel="pingback" href="" />
    <title>《黑色契約CABAL Online》會員轉移</title>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/event/20230728/style.css">
</head>

<body>
    <header>
        <div class="bar">
            <div class="mobel_mask"></div>
            <div class="barBG"></div>
            <button class="rwdMenuBtn" onclick="rwdMenu()">
                <div class="one"></div>
                <div class="two"></div>
            </button>
            <a class="digeamwlogo" href="https://digeam.com/index" target="_blank"></a>
            <div class="links">
                <a href="https://digeam.com/register" target="_blank">會員註冊</a>
                <a href="https://digeam.com/cs" target="_blank">客服中心</a>
                <a href="https://digeam.com/cs/faq" target="_blank">常見問題</a>
            </div>
            <div class="sociallink">
                <a class="fblink" href="https://www.facebook.com/DiGeamCabal" target="_blank"><img
                        src="../../../img/event/20230728/header/fb_icon.png"></a>
                <a class="bhlink" href="https://forum.gamer.com.tw/A.php?bsn=9189" target="_blank"><img
                        src="../../../img/event/20230728/header/bh_icon.png"></a>
            </div>
        </div>
    </header>

    {{-- 跳窗 --}}
    <div class="pop mask" id="pop">
        <div class="blacklayer"></div>
        <div class="box">
            <div class="popText"></div>
            <div class="btnBox">
                <button class="btnClose" onclick="popClose()">取&nbsp;消</button>
                <button class="btnYes">確&nbsp;認</button>
            </div>
        </div>
    </div>
    <div class="popB mask" id="popB">
        <div class="blacklayer"></div>
        <div class="boxB">
            <div class="popBText"></div>
            <button class="btnClose" onclick="popClose()">關&nbsp;閉</button>
        </div>
    </div>

    <div class="notice">
        <div class="noticeframe">
            <p class="noticeTitle">會員轉移注意事項</p>
            <ul>
                <li>轉移登記期間為7/28~10/31。每個掘夢網帳號僅能綁定一個黑色契約遊戲帳號，且一經綁定後即無法更改</li>
                <li>遊戲帳號資料轉移時，不會轉移原持有的遊戲點數或力量晶石。遊戲點數或力量晶石將於重新開服時歸零，請特別留意。</li>
                <li>在伺服器重新開啟前，具時效性的道具仍會正常計時。​​</li>
                <li>因違反遊戲規章而受到封禁懲處的帳號，於轉移後仍會繼續受到封禁。</li>
                <li>玩家進行帳號轉移時所輸入的遊戲帳號密碼資料皆為九禾遊戲企業股份有限公司所有。掘夢網無法核實遊戲帳號的真實所有人，亦無法受理綁定時針對遊戲帳號的相關問題。（如忘記密碼、帳號盜用等）</li>
                <li>掘夢網無法對前代理商於代理期間所發生的消費問題或遊戲過程提供相關客服服務。​</li>
                <li>完成帳號轉移的玩家，即可於正式開服後獲得以下掘夢網專屬獎勵。獎勵預計於遊戲正式開服後兩周內發放至角色信箱。</li>
                <li>轉移專屬獎勵「尊榮皇家小雞坐騎(30日)」為角色專屬道具；會員轉移專屬稱號則為帳號內所有角色共通。裝備稱號時，可提升PVE傷害2%、所有攻擊力+15。
                    <table>
                        <thead>
                            <tr>
                                <td>尊榮皇家小雞坐騎(30日)</td>
                                <td>會員轉移專屬稱號</td>
                            </tr>
                        </thead>
                        <tr>
                            <td><img src="../../../img/event/20230728/chicken.png"></td>
                            <td>再戰十年</td>
                        </tr>
                    </table>
                </li>
                <li>掘夢網保留變更、取消或終止本活動的權利，包括但不限於本活動條款及活動辦法。​</li>
                <li>其他會員轉移相關問題，請參考<a href="https://digeam.com/cs/faq" target="_blank">常見問題</a>。​</li>
            </ul>
            <div class="XX"></div>
            <div class="checkbtn">確&nbsp;認</div>
        </div>
    </div>

    <div class="main">
        <div class="toppage">
            <div class="topBG"></div>
            <div class="title"></div>
            <button class="startbtn" onclick="move()"></button>
            <div class="page2" id="starttochange">
                <div class="mainpic " data-aos="fade-up"></div>
                <div class="stepBox1">
                    <img class="awardText" src="../../../img/event/20230728/mainpicslogn.png">
                    <div class="stepBox2">
                        {{-- <div class="step1" data-aos="fade-up"> --}}
                        <div class="step1">
                            <div class="titleText1">請登入掘夢網帳號</div>


                            @if (isset($_COOKIE['StrID']) && isset($_COOKIE['StrID']) != null)
                                <form id="logout-form" action="https://www.digeam.com/logout" method="POST"
                                    style="display: none;">
                                    <input type="hidden" name="return_url" id="return_url"
                                        value={{ base64_encode('https://cbo.digeam.com/MembershipTransfer') }}>
                                </form>
                                <div class="step1Text">
                                    <p>您已登入掘夢網帳號<br>
                                        <span class='StrID'
                                            data-val={{ $_COOKIE['StrID'] }}>{{ $_COOKIE['StrID'] }}</span>
                                        <button class="step1_register logout" onclick="logout_dg()">登出</button>
                                    </p>
                                </div>
                            @else
                                <div class="step1Text">
                                    <div class="btnBox">
                                        <a class="step1_login" href="https://digeam.com/login">前往登入</a>
                                        <a class="step1_register" href="https://digeam.com/register">立即申請</a>
                                    </div>
                                </div>
                            @endif


                        </div>
                        <div class="step2">
                            <div class="titleText2">請輸入黑色契約<br>遊戲帳號密碼</div>
                            <div class="step2Text"></div>
                        </div>
                        <div class="step3">
                            <div class="step3checkbox">
                                <button class="btnReadAll" onclick="allRead()">
                                    <div data-allRead="false" class="allRead"><i class="fa-regular fa-square"
                                            style="color: #fff"></i>
                                    </div>
                                </button>
                                <div class="step3checkText">
                                    <p>我已閱讀並同意<br>
                                        <span class="step3notice" onclick="noticeIn()">會員轉移注意事項</span>
                                    </p>
                                </div>
                            </div>
                            <div class="step3checkbtn" id="step3checkbtn">確認綁定</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!----- 版權聲明開關 --------->
    <div class="footer-btn">
        <p>版權訊息</p>
        <div class="footer-btnbox">
            <div class="footer-btnball">©</div>
        </div>
    </div>
    <footer>
        <div class="footerbox">
            <div class="footerbox_logo">
                <a class="logo_digeam"><img class="digeamlogo"
                        src="../../../img/event/20230728/footer/digeam_logo.png"></a>
                <a class="logo_rw"><img class="ESTlogo"
                        src="../../../img/event/20230728/footer/ESTgames_logo.png"></a>
            </div>
            <div class="spec">
                <a href="https://www.digeam.com/terms">會員服務條款</a>
                <a href="https://www.digeam.com/terms2">隱私條款</a>
                <a href="https://www.digeam.com/cs">客服中心</a>
                <p class="Copyright">Copyright © ESTgames Corp. All rights reserved.<br />2023 Licensed and published
                    for Taiwan, Hong Kong and Macau by DiGeam Co.,Ltd<br />CABAL Online is a registered trademark of
                    ESTgames Corp (and the logo of ESTgames).</p>
            </div>
            <div class="classlavel">
                <img src="../../../img/event/20230728/footer/15plus.png" alt="輔15級">
                <ul>
                    <li>本遊戲為免費使用，部分內容涉及暴力情節。</li>
                    <li>遊戲內另提供購買虛擬遊戲幣、物品等付費服務。</li>
                    <li>請注意遊戲時間，避免沉迷。</li>
                    <li>本遊戲服務區域包含台灣、香港、澳門。</li>
                </ul>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <script src="js/event/20230728/view.js"></script>
    <script src="js/event/20230728/login.js?v1.6"></script>
    <script src="js/event/20230728/main.js"></script>

</body>

</html>
