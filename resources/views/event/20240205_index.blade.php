<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:title" content="《黑色契約CABAL Online》神光庇護">
    <meta property="og:type" content="website">
    <meta property="og:description" content="《黑色契約CABAL Online》 神光庇護">
    <meta property="og:url" content="《黑色契約CABAL Online》 神光庇護">
    <meta property="og:image" content="/img/event/20240205/fb_share.png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="628">
    <meta name="author" content="DiGeam">
    <meta name="Resource-type" content="Document">
    <link rel="icon" sizes="192x192" href="/img/event/20230728/favicon.ico">
    <meta name="description" content="《黑色契約CABAL Online》 神光庇護">
    <title>《黑色契約CABAL Online》神光庇護</title>
    <link rel="stylesheet" href="/css/event/20240205/style.css?v2.2">
</head>

<body>
    <div id="app">
        {{-- 防連點遮罩 --}}
        <transition name='fade'>
            <div class="mask" v-if="popXL.isModalOpen"></div>
        </transition>
        <transition name='fade'>
            <div class="popXL" v-if="popXL.isModalOpen">
                <div class="close" @click="closeModal()">✖</div>
                <div class="popTitle">%{ popXL.titleText }</div>
                <div class="popDeco"></div>
                <div class="tabAll" v-if="popXL.tabExist">
                    <div class="tabBut">
                        <div class="tab1" @click="history('pray');changeTab(0)"
                            :class="{ active: tab.activeContent === 0 }">祈求庇佑
                        </div>
                        <div class="tab2" @click="history('bless');changeTab(1)"
                            :class="{ active: tab.activeContent === 1 }">加倍祝福
                        </div>
                    </div>
                    <div class="listChange" v-if="popXL.listChange === 2">
                        <div class="tabContent" v-if=" tab.activeContent === 0 ">
                            <table>
                                <thead>
                                    <tr>
                                        <th width="0.2%" class="th1">日期</th>
                                        <th width="1%">道具名稱</th>
                                        <th width="4%">道具說明​</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in rewardList1">
                                        <td>%{ item.actDate }</td>
                                        <td>%{ item.item_name }</td>
                                        <td class="td1">%{ item.description }</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tabContent" v-if=" tab.activeContent === 1 ">
                            <table>
                                <thead>
                                    <tr>
                                        <th width="2%">優惠券名稱</th>
                                        <th width="4%">優惠券說明</th>
                                        <th width="0.5%">機率​</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in rewardList2">
                                        <td>%{ item.item_name }</td>
                                        <td class="td1">%{ item.description }</td>
                                        <td>%{ item.probability }</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="listChange" v-if="popXL.listChange === 4">
                        <div class="tabContent" v-if=" tab.activeContent === 0 ">
                            <table>
                                <thead>
                                    <tr>
                                        <th width="2%">優惠券名稱</th>
                                        <th width="1.2%">道具名稱</th>
                                        <th width="1%">優惠券效期​</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in claimHistory1">
                                        <td>%{ item.coupon }</td>
                                        <td>%{ item.item}</td>
                                        <td>%{ item.coupon_deadline }</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tabContent" v-if=" tab.activeContent === 1 ">
                            <table>
                                <thead>
                                    <tr>
                                        <th width="2%">優惠券名稱</th>
                                        <th width="1.2%">道具名稱​</th>
                                        <th width="1%">優惠券效期​</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in claimHistory2">
                                        <td>%{ item.coupon }</td>
                                        <td>%{ item.item}</td>
                                        <td>%{ item.coupon_deadline }</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="popWrap" v-html="popXL.wrapText">
                    %{ wrapText }
                </div>
            </div>
        </transition>
        <transition name='fade'>
            <div class="mask" v-if="popS.isModalOpen"></div>
        </transition>
        <transition name='fade'>
            <div class="popS" v-if="popS.isModalOpen">
                <div class="close" @click.prevent="closeModal()">✖</div>
                <div class="popContent">
                    <div class="popTitle" v-html="popS.titleText">%{ popS.titleText }</div>
                    <div class="popResult" v-html="popS.wrapText">%{ popS.wrapText }</div>
                    <div class="popButAll">
                        <div v-if="popS.popBut1" v-html="popS.butText1" @click='closeModal()'>
                            %{ popS.butText1 }
                        </div>
                        <div class='popBut1' v-if="popS.popBut3" @click='blessConfirm()'>
                            是
                        </div>
                        <div v-if="popS.popBut2" v-html="popS.butText2" @click='closeModal()'>
                            %{ popS.butText2 }
                        </div>
                    </div>
                </div>
            </div>
        </transition>
        <div class="noticeM" v-if="isMobile">
            <p>建議您在電腦環境下操作本活動頁面。</p>
        </div>
       
        {{-- 判斷登入 --}}
        <div id="particles-js"></div>
        <div class="header">
            
            <div class="top">
                @if (isset($_COOKIE['StrID']) && isset($_COOKIE['StrID']) != null)
                    <form id="logout-form" action="https://www.digeam.com/logout" method="POST"
                        style="display: none;">
                        <input type="hidden" name="return_url" id="return_url"
                            value={{ base64_encode('https://cbo.digeam.com/20240205') }}>
                    </form>
                    <a href="https://cbo.digeam.com/" class="logo" target="blank"></a>
                    <div class="account">
                        <div class="login">
                            <div class="accText">{{ $_COOKIE['StrID'] }}</div>
                            <div class="accBtn" @click="logout_dg()"><a>登出</a></div>
                        </div>
                        <div class="point">
                            <div class="poHold">持有點數</div>
                            <div class="poText">%{ logIn.pointText }</div>
                            <div class="poBtn"><a href="https://www.digeam.com/member/billing">儲值</a></div>
                        </div>
                    </div>
            </div>
        @else
            </form>
            <a href="https://cbo.digeam.com/" class="logo" target="blank"></a>
            <div class="account">
                <div class="login">
                    <div class="accText"></div>
                    <div class="accBtn"><a href="https://www.digeam.com/login">登入</a></div>
                </div>
                <div class="point">
                    <div class="poHold">持有點數</div>
                    <div class="poText">%{ logIn.pointText }</div>
                    <div class="poBtn"><a href="https://www.digeam.com/member/billing">儲值</a></div>
                </div>
            </div>
        </div>
        @endif
        <div class="actiBut">
            <div class="prayBut" @click="prayClick()">祈求庇佑</div>
            <div class="blessBut" @click="blessClick()">加倍祝福</div>
        </div>
        <div class="sidebar">
            <div class="description" @click="openModal(1)">活動說明</div>
            <div class="gift" @click="openModal(2)">獎勵一覽</div>
            <div class="notice" @click="openModal(3)">注意事項</div>
            <div class="history" @click="history('pray');openModal(4)">領取紀錄</div>
        </div>
    </div>
    <footer>
        <div class="footerbox">
            <div class="footerbox_logo">
                <a class="logo_digeam"><img class="digeamlogo" src="/img/event/20240205/logo_digeam.png"></a>
                <a class="logo_rw"><img class="ESTlogo" src="/img/event/20240205/est.png"></a>
            </div>
            <div class="spec">
                <a href="https://www.digeam.com/terms" target="_blank">會員服務條款</a>
                <a href="https://www.digeam.com/terms2" target="_blank">隱私條款</a>
                <a href="https://www.digeam.com/cs" target="_blank">客服中心</a>
                <p class="Copyright">Copyright © ESTgames Corp. All rights reserved.<br />2023 Licensed and
                    published
                    for Taiwan, Hong Kong and Macau by DiGeam Co.,Ltd<br />CABAL Online is a registered trademark of
                    ESTgames Corp (and the logo of ESTgames).</p>
            </div>
            <div class="classlavel">
                <div><img src="/img/event/20240205/icon_15.png" alt="輔15級"></div>
                <ul>
                    <li>本遊戲為免費使用，部分內容涉及暴力情節。</li>
                    <li>遊戲內另提供購買虛擬遊戲幣、物品等付費服務。</li>
                    <li>請注意遊戲時間，避免沉迷。</li>
                    <li>本遊戲服務區域包含台灣、香港、澳門。</li>
                </ul>
            </div>
        </div>
    </footer>
    <script src="https://unpkg.com/vue@3.2.4/dist/vue.global.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script src="/js/event/20240205/vue.js?v9.25"></script>
</body>

</html>
