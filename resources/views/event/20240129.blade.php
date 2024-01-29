<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta property="og:title" content="《黑色契約CABAL Online》穹空戰場：試煉之巔" />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="《黑色契約CABAL Online》穹空戰場：試煉之巔" />
    <meta property="og:url" content="《黑色契約CABAL Online》穹空戰場：試煉之巔" />
    <meta property="og:site_name" content="" />
    <meta property="og:locale" content="zh_tw" />
    <meta property="article:author" content="" />
    <meta property="og:image" content="/img/event/20240129/shareBg.png" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="628" />
    <meta name="author" content="DiGeam" />
    <meta name="Resource-type" content="Document" />
    <link rel="icon" sizes="192x192" href="/img/event/20230728/favicon.ico">
    <meta name="description" content="《黑色契約CABAL Online》穹空戰場：試煉之巔" />
    <title>《黑色契約CABAL Online》穹空戰場：試煉之巔</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vue3-slick-carousel@1.0.6/src/slick-theme.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/event/20240129/style.css?v11.11">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
</head>

<body>
    <div class="wrap" id="wrap">

        <header class="header" id="header">
            <nav class="nav">
                <a href="http://cbo.digeam.com/index" target="_blank" class="logo"></a>
                <div class="linkBox">
                    <a href="https://forum.gamer.com.tw/A.php?bsn=9189" class="baha" target="_blank"></a>
                    <a href="https://www.facebook.com/DiGeamCabal/" class="fb" target="_blank"></a>
                    <a href="https://discord.gg/YyPkJrwqvs" class="discord" target="_blank"></a>
                </div>
            </nav>
            <div class="linkBox2">
                <a href="https://www.digeam.com/register"target="_blank">會員註冊</a>
                <a href="https://cbo.digeam.com/game"target="_blank">遊戲下載</a>
            </div>
        </header>


        <aside class="aside" :class="{ active: !aside }">
            <div class="arrow" @click="asideHide()">
                <img src="img/event/20240129/menuClose.png" alt="">
            </div>
            <ul>
                <li><a href="#sec01">穹空遺跡</a></li>
                <li><a href="#sec02">全新副本</a></li>
                <li><a href="#sec03">活動快訊</a></li>
            </ul>
            <a href="#header" class="top">TOP</a>
        </aside>

        <aside class="link" v-if="openLink == true">
            <a href="https://cbo.digeam.com/20240205"></a>
        </aside>

        <section class="sec01" id="sec01">
            <div class="sec01Title"></div>
            <div class="sec01TabBox">
                <button :class="{ active: tabData[0].type == '01' }" @click="tab('01', '01')">地圖介紹</button>
                <button :class="{ active: tabData[0].type == '02' }" @click="tab('01', '02')">戰場分布</button>
            </div>
            <div class="sec01Content">

                <div class="contentBox center" v-if="tabData[0].type == '01'">
                    <br>
                    <pre>穹空遺跡首度分割PVP/PVE戰場，玩家可在中央聖殿區域和敵對國家大打出手，</pre>
                    <pre>也可在下層聖殿共同角逐強力增益效果，為各自的國家貢獻一己之力！</pre>
                    <pre>除此之外，還可利用戰場上的草叢隱藏自己的蹤跡，給對手來個突襲Gank！</pre>

                    <h2 class="title">地圖資訊</h2>
                    <div class="line"></div>
                    <pre>入場戰鬥力：900,000​</pre>
                    <pre>人數限制：100名​</pre>
                    <pre>對戰時間：30分鐘（備戰廳等待時間4分鐘）</pre>​
                    <img src="img/event/20240129/img_field1.jpg" alt="穹空遺跡地圖介紹及說明" class="w70 br">
                    <br>
                </div>
                <div class="contentBox" v-if="tabData[0].type == '02'">
                    <br>
                    <img src="img/event/20240129/s2Pic2.png" alt="穹空遺跡戰場分布及說明">
                    <p>更多副本詳細資訊請見<a href="https://cbo.digeam.com/wiki/126" target="_blank">穹空遺跡遊戲百科</a></p>
                    <br>
                </div>
            </div>

        </section>

        <section class="sec02" id="sec02">
            <div class="sec02Title"></div>
            <div class="sec02TabBox">
                <button :class="{ active: tabData[1].type == '01' }" @click="tab('02', '01')">兩服共通</button>
                <button :class="{ active: tabData[1].type == '02' }" @click="tab('02', '02')">黑恆星限定</button>
            </div>
            <div class="sec02Content">
                <div class="contentBox twoBox" v-if="tabData[1].type == '01'">
                    <div class="left">
                        <div class="swiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide"><img src="img/event/20240129/img_inside1.jpg"
                                        alt="兩服共通副本資訊圖片"></div>
                                <div class="swiper-slide"><img src="img/event/20240129/img_inside2.jpg"
                                        alt="兩服共通副本資訊圖片"></div>
                                <div class="swiper-slide"><img src="img/event/20240129/img_inside3.jpg"
                                        alt="兩服共通副本資訊圖片"></div>
                                <div class="swiper-slide"><img src="img/event/20240129/img_inside4.jpg"
                                        alt="兩服共通副本資訊圖片"></div>
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                    <div class="right">
                        <h2 class="title">副本資訊</h2>
                        <div class="line"></div>
                        <pre>副本名稱：無限試煉</pre>
                        <pre>入場道具：試煉的卷軸<img src="img/event/20240129/s3Roll.png" alt="試煉的卷軸圖示"></pre>
                        <pre>副本位置：血色冰峰 (X:66 , Y:22)​</pre>
                        <h2 class="title">副本介紹</h2>
                        <div class="line"></div>
                        <pre>全新爬塔式個人通關賽季副本！</pre>
                        <pre>玩家需在時限內完成指定通關條件，才可進行下一場試煉。</pre>
                        <pre>越往上走會有越多更兇悍的怪物在等著，</pre>
                        <pre>賽季結束後將根據排名結果告訴大家誰才是真正的前段班玩家！​​</pre>

                        <p>更多副本詳細資訊請見<a href="https://cbo.digeam.com/wiki/127" target="_blank">無限試煉遊戲百科</a></p>
                    </div>

                </div>
                <div class="contentBox center" v-if="tabData[1].type == '02'">
                    <h2 class="title">本次開放副本</h2>
                    <div class="line"></div>
                    <pre>地獄競技場、地下幻影之城(外傳)、幽靈之地</pre>
                    <pre>幻影之城-光之殿(外傳)、遺棄的城市、惡魔之塔(Part2)</pre>
                    <div class="imgBox">
                        <a href="https://cbo.digeam.com/wiki/143​" target="_blank"><img src="img/event/20240129/s3Pic02.png"
                                alt="地獄競技場"></a>
                        <a href="https://cbo.digeam.com/wiki/144" target="_blank"><img src="img/event/20240129/s3Pic03.png"
                                alt="地下幻影之城(外傳)"></a>
                        <a href="https://cbo.digeam.com/wiki/145" target="_blank"><img src="img/event/20240129/s3Pic04.png"
                                alt="幽靈之地"></a>
                        <a href="https://cbo.digeam.com/wiki/146" target="_blank"><img src="img/event/20240129/s3Pic05.png"
                                alt="幻影之城-光之殿(外傳)"></a>
                        <a href="https://cbo.digeam.com/wiki/147" target="_blank"><img src="img/event/20240129/s3Pic06.png"
                                alt="遺棄的城市"></a>
                        <a href="https://cbo.digeam.com/wiki/148" target="_blank"><img src="img/event/20240129/s3Pic07.png"
                                alt="惡魔之塔(Part2)"></a>
                    </div>
                </div>
            </div>
        </section>

        <section class="sec03">
            <div class="sec03Title" id="sec03"></div>
            <div class="sec03TabBox">
                <button :class="{ active: tabData[2].type == '01' }" @click="tab('03', '01')">紅包大作戰</button>
                <button :class="{ active: tabData[2].type == '02' }" @click="tab('03', '02')">長輩的關心</button>
                <button :class="{ active: tabData[2].type == '03' }" @click="tab('03', '03')">開運年菜</button>
                <button :class="{ active: tabData[2].type == '04' }" @click="tab('03', '04')">加倍慶龍年</button>
            </div>
            <div class="sec03Content">
                <div class="contentBox center" v-if="tabData[2].type == '01'">
                    <h2 class="title">紅包大作戰</h2>
                    <div class="line"></div>
                    <h3 class="sub">活動時間</h3>
                    <p>2024/01/30(二) 16:00 ~ 2024/02/27(二) 12:00</p>
                    <h3 class="sub">活動說明</h3>
                    <p>活動期間內，請留心遊戲中的每一個小角落，您將有機會在任何地方發現神秘的紅包序號！</br>
                        只要在官網的「<a href="https://cbo.digeam.com/number_exchange" target="_blank">序號專區</a>」輸入紅包序號，即可獲得「黑色契約紅包袋」，內含隨機一份小禮物！</br>
                        此外，02/18(日) 23:59前發現並領取最多紅包的玩家，還可獲得額外的限定稱號「黑契財神爺」！</p>
                    <h3 class="sub">黑色契約紅包袋內容物</h3>
                    <img src="img/event/20240129/tab1_table_1.png" alt="黑色契約紅包袋內容物">
                    <h3 class="sub">排名獎勵列表</h3>
                    <img src="img/event/20240129/tab1_table_22.png" alt="排名獎勵列表">
                    <h3 class="sub">稱號「黑契財神爺」能力值</h3>
                    <img src="img/event/20240129/tab1_img_1.jpg" alt="稱號「黑契財神爺」能力值">
                    <h3 class="sub">注意事項</h3>
                    <ul>
                        <li>一組序號於同一帳號內僅可使用一次，使用後無法再重複領取同一組序號。​​每組序號可被兌換150次。​​</li>
                        <li>除「寵物突變卡 - 海盜鸚鵡」，所有獎勵皆為帳號綁定，並且部分獎勵設有等級、時效等限制。實際道具設定以遊戲中獲取為準。</li>
                        <li>序號兌換數量相同者，將以最後一筆序號兌換時間為依據，依時間先後決定最終排名。</li>
                        <li>序號排名獎勵將於02/20(二)維護時統一發送，並於當日在<a href="https://www.facebook.com/DiGeamCabal/" target="_blank">官方粉絲專頁</a>上公告所有紅包序號的位置。</li>
                        <li>排名獎勵的活動稱號具有使用期限，並且從2/20維護時開始生效。稱號將發送至維護當下帳號內所有角色。</li>
                        <li>活動道具「黑色契約紅包袋」將於2/27(二) 12:00後統一刪除，請特別留意。</li>
                        <li>掘夢網保留變更、取消或終止本活動的權利，包括但不限於本活動條款及活動辦法。</li>
                    </ul>
                </div>
                <div class="contentBox center" v-if="tabData[2].type == '02'">
                    <h2 class="title">長輩的關心</h2>
                    <div class="line"></div>
                    <h3 class="sub">活動時間</h3>
                    <p>2024/01/30(二) 16:00 ~ 2024/02/27(二) 12:00</p>
                    <h3 class="sub">活動說明</h3>
                    <p>活動期間內，1~5線血色冰峰與呼嘯沙漠門口處將出現活動怪物「靈魂深處的拷問者」，<br>
                        活動怪物被擊殺後，將出現各種長輩的關心。開啟後即可獲得「絢爛的珠寶箱(翠玉)(1日)」。<br>各種長輩們的熱情關懷，讓你在黑色契約也能感受到家的溫暖！</p>
                    <h3 class="sub">絢爛的珠寶箱(翠玉)能力值</h3>
                    <img src="img/event/20240129/tab2_img_1.png" alt="絢爛的珠寶箱(翠玉)能力值">
                    <h3 class="sub">注意事項</h3>
                    <ul>
                        <li>活動怪物只會出現在1~5線血色冰峰與呼嘯沙漠門口處，約12小時重生一次，每次重生後最多停留1小時。</li>
                        <li>活動怪掉落道具所有玩家皆可拾取，拾取後需在30分鐘內使用完畢。</li>
                        <li>一個角色身上最多只能裝備一個「絢爛的珠寶箱(翠玉)」。</li>
                        <li>獎勵獲取的道具可能有等級、綁定、時效等限制，實際道具設定以遊戲中獲取為準。</li>
                        <li>掘夢網保留變更、取消或終止本活動的權利，包括但不限於本活動條款及活動辦法。</li>
                    </ul>
                </div>
                <div class="contentBox center" v-if="tabData[2].type == '03'">
                    <h2 class="title">開運年菜</h2>
                    <div class="line"></div>
                    <h3 class="sub">活動時間</h3>
                    <p>2024/01/30(二) 16:00 ~ 2024/02/27(二) 12:00</p>
                    <h3 class="sub">活動說明</h3>
                    <p>活動期間內開啟副本的寶箱時，有機會額外獲得活動道具「貴妃龍蝦佛跳牆」、「金饌燒酒魚翅羹」、「鴻運發財菜頭湯」。<br>蒐集指定數量的開運年菜，即可和活動NPC兌換「龍年新春禮箱」，以及各種實用道具。
                    </p>
                    <h3 class="sub">活動NPC兌換道具列表</h3>
                    <img src="img/event/20240129/tab3_table_1.png" alt="活動NPC兌換道具列表">
                    <h3 class="sub">龍年新春禮箱內容物</h3>
                    <img src="img/event/20240129/tab3_table_2.png" alt="龍年新春禮箱內容物">
                    <h3 class="sub">注意事項</h3>
                    <ul>
                        <li>活動道具「貴妃龍蝦佛跳牆」,「金饌燒酒魚翅羹」,「鴻運發財菜頭湯」將於活動結束後統一刪除。</li>
                        <li>未使用的「龍年新春禮箱」於活動結束後將一併刪除，請戰士們留意道具使用期限。
                        </li>
                        <li>本活動的副本不包含混沌競技場、褪色/弱化副本。</li>
                        <li>部分獎勵設有每周兌換次數限制，每周兌換限制將於周二12:00重置次數。</li>
                        <li>獎勵獲取的道具可能有等級、綁定、時效等限制，實際道具設定以遊戲中獲取為準。</li>
                        <li>掘夢網保留變更、取消或終止本活動的權利，包括但不限於本活動條款及活動辦法。</li>
                    </ul>
                </div>
                <div class="contentBox center" v-if="tabData[2].type == '04'">
                    <h2 class="title">加倍慶龍年</h2>
                    <div class="line"></div>
                    <h3 class="sub">活動時間</h3>
                    <p>2024/02/06(二) 16:00 ~ 2024/02/18(日) 23:59</p>
                    <h3 class="sub">活動說明</h3>
                    <p>活動期間內，全伺服器將於特定時段開啟經驗值、技能經驗值、AXP、出現Alz堆率、掉寶率加倍。<br>已啟用任一種VIP服務的玩家，經驗值、技能經驗值、AXP、出現Alz堆率、掉寶率再額外增加50%！
                    </p>
                    <br>
                    <img src="img/event/20240129/tab4_table_1.png" alt="龍年新春禮箱內容物">
                    <h3 class="sub">注意事項</h3>
                    <ul>
                        <li>發現活動或領獎機制出現系統或其他異常時，請於第一時間透過「<a href="https://www.digeam.com/cs">客服中心</a>」進行回報，<br>
                            若逕行利用該異常取得非屬原活動機制應得之獎勵者，本公司有權終止其進行遊戲及會員服務資格。</li>
                        <li>掘夢網保留變更、取消或終止本活動的權利，包括但不限於本活動條款及活動辦法。</li>
                    </ul>
                </div>
            </div>
        </section>

        <footer class="footer">
            <a href="https://www.digeam.com/index" target="_blank" class="digeam">
            </a>
            <div class="est"></div>
            <div class="fooLink">
                <a href="https://www.digeam.com/terms?_gl=1*prkbqn*_ga*MTI0MjkwMTA3Mi4xNjg3MjI2NjQx*_ga_3YHH2V2WHK*MTY5Mjc4MTA3My4xNy4wLjE2OTI3ODEwNzMuNjAuMC4w"
                    target="_blank" class="linkp">會員服務條款</a>
                <a href="https://www.digeam.com/terms2?_gl=1*c9toqi*_ga*MTI0MjkwMTA3Mi4xNjg3MjI2NjQx*_ga_3YHH2V2WHK*MTY5Mjc4MTA3My4xNy4wLjE2OTI3ODEwNzMuNjAuMC4w"
                    target="_blank" class="linkp">隱私條款</a>
                <a href="https://www.digeam.com/cs" target="_blank" class="linkp">客服中心</a>
                <div class="copyright">
                    <p>Copyright © ESTgames Corp. All rights reserved.</p>
                    <p>%[ new Date().getFullYear() ]Licensed and published for Taiwan, Hong Kong and Macau by DiGeam
                        Co.,Ltd</p>
                    <p>CABAL Online is a registered trademark of ESTgames Corp (and the logo of ESTgames).</p>
                </div>
            </div>
            <div class="age"></div>
            <div class="fooinfo">
                <p>本遊戲為免費使用，部分內容涉及暴力情節。</p>
                <p>遊戲內另提供購買虛擬遊戲幣、物品等付費服務。</p>
                <p>請注意遊戲時間，避免沉迷。</p>
                <p><span>本遊戲服務區域包含台灣、香港、澳門。</span></p>
            </div>
        </footer>

    </div>

</body>
<script src="js/event/base/vue-3.2.4.global.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="js/event/20240129/main.js"></script>

</html>
