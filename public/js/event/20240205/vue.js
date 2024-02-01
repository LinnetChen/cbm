var api = "/api/event240205_api";
// var api = "http://192.168.0.41:8088/api/event240205_api";
Vue.createApp({
    // 將php與vue語法衝突更換
    delimiters: ["%{", "}"],
    //data函式
    data: function () {
        return {
             // 防連點
            isClickable: true,
            logIn: {
                pointText: null,
                account: "",
                // 先判斷是否登入
                isLogin: false,
                // 活動是否已結束
                finished: false,
            },
            popXL: {
                isModalOpen: false,
                titleText: "",
                wrapText: "",
                tabExist: false,
                // tab不變換list
                listChange: null,
            },
            tab: {
                isTab: 0,
                activeContent: 0,
            },
            popS: {
                isModalOpen: false,
                titleText: "",
                wrapText: "",
                popBut1: false,
                popBut2: false,
                popBut3: false,
                butText1: "",
                butText2: "",
            },
            rewardList1: [
                {
                    actDate: "2/6",
                    item_name: "貝拉德里克斯的加護x10",
                    description:
                        "在副本內使用後，若HP變成0時會恢復成100%。只有在副本內可以使用，離開副本後效果消失。",
                },
                {
                    actDate: "2/7",
                    item_name: "喇叭x10",
                    description: "可在全頻道廣播。國戰頻道無法使用。",
                },
                {
                    actDate: "2/8",
                    item_name: "憤怒藥水(特大)x5",
                    description: "使用後可恢復10000 SP，冷卻時間5秒。",
                },
                {
                    actDate: "2/9",
                    item_name: "[服裝]賀歲龍袍護肩(7D)x1",
                    description:
                        "Alz獲取增加+40%、1槽裝備獲取機率+60%、2槽裝備獲取機率+400%，有效時間7天。",
                },
                {
                    actDate: "2/10",
                    item_name: "GM的祝福(Lv.4)聖水x5",
                    description:
                        "裝有Lv.4 GM祝福的聖水，使用後大幅提升角色能力值，持續1小時。",
                },
                {
                    actDate: "2/11",
                    item_name: "英雄聖水(30分鐘)x5",
                    description:
                        "防禦力+40、所有攻擊力增加+40、所有技能增幅增加+7%，持續30分鐘。",
                },
                {
                    actDate: "2/12",
                    item_name: "戰士聖水(30分)x5",
                    description:
                        "攻擊力+30、防禦力+30、刀劍技能增幅+5%，持續30分鐘。",
                },
                {
                    actDate: "2/13",
                    item_name: "賢者聖水(30分)x5",
                    description:
                        "魔法攻擊力+30、防禦力+30、魔法技能增幅+5%，持續30分鐘。",
                },
                {
                    actDate: "2/14",
                    item_name: "最高級復活結晶x5",
                    description:
                        "高級復活結晶內蘊藏原始文明時代遺產的改良符咒。使用後可以復活為擁有特別力量的狀態。",
                },
                {
                    actDate: "2/15",
                    item_name: "AP儲存箱(50/50)x1",
                    description: "使用後可獲得50 AP，領出AP後儲存箱會消失。",
                },
                {
                    actDate: "2/16",
                    item_name: "抵抗聖水(30分鐘)x5",
                    description:
                        "使用後所有異常狀態的抵抗能力+30%，持續30分鐘。",
                },
                {
                    actDate: "2/17",
                    item_name: "英雄的召喚x5",
                    description: "帶有古代魔力的卷軸。有著召喚隊友的功能。",
                },
                {
                    actDate: "2/18",
                    item_name: "英雄的跳躍x5",
                    description:
                        "蘊藏古代魔力的卷軸。具有傳送至指定隊員位置的功能。",
                },
                {
                    actDate: "2/19",
                    item_name: "工匠的特效藥(300)x1",
                    description: "使用後可直接獲得300點製作能量。",
                },
                {
                    actDate: "2/20",
                    item_name: "祝福寶珠-特級(1D)x1",
                    description:
                        "24小時內經驗值/技能經驗值/掉寶率/Wexp/寵物經驗值/AXP/羽翼經驗值/寶箱額外掉落機率增加，並開啟GPS傳送功能，背包頁數增加1頁。",
                },
            ],
            rewardList2: [
                {
                    item_name: "9折優惠券A",
                    description:
                        "此優惠券僅限用於折抵[契約小舖-祝福寶珠]分類的商品，有效期限3天。",
                    probability: "2.10%",
                },
                {
                    item_name: "9折優惠券B",
                    description:
                        "此優惠券僅限用於折抵[契約小舖-時裝/解綁/封印石]分類的商品，有效期限3天。",
                    probability: "2.10%",
                },
                {
                    item_name: "9折優惠券C",
                    description:
                        "此優惠券僅限用於折抵[契約小舖-強化/製作/飾品/強效器]分類的商品，有效期限3天。",
                    probability: "2.40%",
                },
                {
                    item_name: "9折優惠券D",
                    description:
                        "此優惠券僅限用於折抵[契約小舖-二月特賣]分類的商品，有效期限3天。",
                    probability: "2.70%",
                },
                {
                    item_name: "8.5折優惠券A",
                    description:
                        "此優惠券僅限用於折抵[契約小舖-祝福寶珠]分類的商品，有效期限3天。",
                    probability: "1.50%",
                },
                {
                    item_name: "8.5折優惠券B",
                    description:
                        "此優惠券僅限用於折抵[契約小舖-時裝/解綁/封印石]分類的商品，有效期限3天。",
                    probability: "1.50%",
                },
                {
                    item_name: "8.5折優惠券C",
                    description:
                        "此優惠券僅限用於折抵[契約小舖-強化/製作/飾品/強效器]分類的商品，有效期限3天。",
                    probability: "1.80%",
                },
                {
                    item_name: "8.5折優惠券D",
                    description:
                        "此優惠券僅限用於折抵[契約小舖-二月特賣]分類的商品，有效期限3天。",
                    probability: "2.10%",
                },
                {
                    item_name: "7.5折優惠券A",
                    description:
                        "此優惠券僅限用於折抵[契約小舖-祝福寶珠]分類的商品，有效期限3天。",
                    probability: "0.90%",
                },
                {
                    item_name: "7.5折優惠券B",
                    description:
                        "此優惠券僅限用於折抵[契約小舖-時裝/解綁/封印石]分類的商品，有效期限3天。",
                    probability: "0.90%",
                },
                {
                    item_name: "7.5折優惠券C",
                    description:
                        "此優惠券僅限用於折抵[契約小舖-強化/製作/飾品/強效器]分類的商品，有效期限3天。",
                    probability: "1.20%",
                },
                {
                    item_name: "7.5折優惠券D",
                    description:
                        "此優惠券僅限用於折抵[契約小舖-二月特賣]分類的商品，有效期限3天。",
                    probability: "1.50%",
                },
                {
                    item_name: "40黑魂優惠券",
                    description:
                        "此優惠券僅限用於折抵[契約小舖]41黑魂(含)以上的商品，不限分類(VIP服務除外)，有效期限3天。",
                    probability: "1.80%",
                },
                {
                    item_name: "50黑魂優惠券",
                    description:
                        "此優惠券僅限用於折抵[契約小舖]51黑魂(含)以上的商品，不限分類(VIP服務除外)，有效期限3天。",
                    probability: "2.40%",
                },
                {
                    item_name: "70黑魂優惠券",
                    description:
                        "此此優惠券僅限用於折抵[契約小舖]71黑魂(含)以上的商品，不限分類(VIP服務除外)，有效期限3天。",
                    probability: "2.40%",
                },
                {
                    item_name: "100黑魂優惠券",
                    description:
                        "此優惠券僅限用於折抵[契約小舖]101黑魂(含)以上的商品，不限分類(VIP服務除外)，有效期限3天。",
                    probability: "1.20%",
                },
                {
                    item_name: "120黑魂優惠券",
                    description:
                        "此優惠券僅限用於折抵[契約小舖]121黑魂(含)以上的商品，不限分類(VIP服務除外)，有效期限3天。",
                    probability: "0.90%",
                },
                {
                    item_name: "150黑魂優惠券",
                    description:
                        "此優惠券僅限用於折抵[契約小舖]151黑魂(含)以上的商品，不限分類(VIP服務除外)，有效期限3天。",
                    probability: "0.60%",
                },
                {
                    item_name: "100黑魂-星際滑板",
                    description:
                        "此優惠券僅限用於[契約小舖-X2系列/X系列]分類的滑板商品，使用後可以100黑魂的價格購買滑板，有效期限3天。",
                    probability: "4.00%",
                },
                {
                    item_name: "300黑魂-[禮物盒]星際滑板",
                    description:
                        "此優惠券僅限用於[契約小舖-X2系列/X系列]分類的禮物盒-滑板商品，使用後可以300黑魂的價格購買禮物盒-滑板，有效期限3天。",
                    probability: "5.00%",
                },
                {
                    item_name: "70黑魂-寵物打磨道具(30天)",
                    description:
                        "此優惠券僅限用於[契約小舖-寵物打磨道具(30天)]，使用後可以70黑魂的價格購買寵物打磨道具(30天)，有效期限3天。",
                    probability: "5.00%",
                },
                {
                    item_name: "300黑魂-勳章評價支援命令書(20個)",
                    description:
                        "此優惠券僅限用於[契約小舖-勳章評價支援命令書(20個)]，使用後可以300黑魂的價格購買勳章評價支援命令書(20個)，有效期限3天。",
                    probability: "4.00%",
                },
                {
                    item_name: "10黑魂-精煉磁心零件(超越)",
                    description:
                        "此優惠券僅限用於[契約小舖-精煉磁心零件(超越)]，使用後可以10黑魂的價格購買精煉磁心零件(超越)，有效期限3天。",
                    probability: "5.00%",
                },
                {
                    item_name: "15黑魂-特級磁心零件(超越)",
                    description:
                        "此優惠券僅限用於[契約小舖-特級磁心零件(超越)]，使用後可以15黑魂的價格購買特級磁心零件(超越)，有效期限3天。",
                    probability: "5.00%",
                },
                {
                    item_name: "5黑魂-精煉磁心零件(最高級)",
                    description:
                        "此優惠券僅限用於[契約小舖-精煉磁心零件(最高級)]，使用後可以5黑魂的價格購買精煉磁心零件(最高級)，有效期限3天。",
                    probability: "6.00%",
                },
                {
                    item_name: "10黑魂-特級磁心零件(最高級)",
                    description:
                        "此優惠券僅限用於[契約小舖-特級磁心零件(最高級)]，使用後可以10黑魂的價格購買特級磁心零件(最高級)，有效期限3天。",
                    probability: "6.00%",
                },
                {
                    item_name: "25黑魂-貝拉德里克斯的加護(10個)",
                    description:
                        "此優惠券僅限用於[契約小舖-貝拉德里克斯的加護(10個)]，使用後可以25黑魂的價格購買貝拉德里克斯的加護(10個)，有效期限3天。",
                    probability: "5.00%",
                },
                {
                    item_name: "150黑魂-傭兵卡-阿里奧奈爾",
                    description:
                        "此優惠券僅限用於[契約小舖-傭兵卡-阿里奧奈爾]，使用後可以150黑魂的價格購買傭兵卡-阿里奧奈爾，有效期限3天。",
                    probability: "5.00%",
                },
                {
                    item_name: "20黑魂-旅行者聖水/光榮藥水(大)(10個)",
                    description:
                        "此優惠券僅限用於[契約小舖-旅行者聖水(10個)/光榮藥水(大)(10個)]，使用後可以20黑魂的價格購買旅行者聖水(10個)或光榮藥水(大)(10個)，有效期限3天。",
                    probability: "4.00%",
                },
                {
                    item_name: "20黑魂-憤怒藥水(大)(10個)",
                    description:
                        "此優惠券僅限用於[契約小舖-憤怒藥水(大)(10個)]，使用後可以20黑魂的價格購買憤怒藥水(大)(10個)，有效期限3天。 ",
                    probability: "4.00%",
                },
                {
                    item_name: "5黑魂-屬性藥水(10個)",
                    description:
                        "此優惠券僅限用於[契約小舖-屬性藥水(力量)/(敏捷)/(智力) [10個]]，使用後可以5黑魂的價格購買屬性藥水(力量)/(敏捷)/(智力) [10個]任一，有效期限3天。",
                    probability: "3.00%",
                },
                {
                    item_name: "70黑魂-米納斯塔的符咒",
                    description:
                        "此優惠券僅限用於[契約小舖-米納斯塔的青玉符咒/寶石符咒/琥珀符咒/翠玉符咒/紫晶符咒]，使用後可以70黑魂的價格購買米納斯塔的青玉符咒/寶石符咒/琥珀符咒/翠玉符咒/紫晶符咒任一，有效期限3天。",
                    probability: "4.00%",
                },
                {
                    item_name: "950黑魂-米納斯塔的符咒(11個)",
                    description:
                        "此優惠券僅限用於[契約小舖-米納斯塔的青玉符咒/寶石符咒/琥珀符咒/翠玉符咒/紫晶符咒(11個)]，使用後可以950黑魂的價格購買米納斯塔的青玉符咒/寶石符咒/琥珀符咒/翠玉符咒/紫晶符咒(11個)任一，有效期限3天。",
                    probability: "3.00%",
                },
                {
                    item_name: "1黑魂-防止強化等級下降輔助劑(高級)",
                    description:
                        "此優惠券僅限用於[契約小舖-防止強化等級下降輔助劑(高級)]，使用後可以1黑魂的價格購買防止強化等級下降輔助劑(高級)，有效期限3天。",
                    probability: "0.35%",
                },
                {
                    item_name: "1黑魂-防止強化等級下降輔助劑(最高級)",
                    description:
                        "此優惠券僅限用於[契約小舖-防止強化等級下降輔助劑(最高級)]，使用後可以1黑魂的價格購買防止強化等級下降輔助劑(最高級)，有效期限3天。",
                    probability: "0.25%",
                },
                {
                    item_name: "1黑魂-防止強化等級下降輔助劑(超越)",
                    description:
                        "此優惠券僅限用於[契約小舖-防止強化等級下降輔助劑(超越)]，使用後可以1黑魂的價格購買防止強化等級下降輔助劑(超越)，有效期限3天。",
                    probability: "0.20%",
                },
                {
                    item_name: "1黑魂-強化磁心組合(初級) 100入",
                    description:
                        "此優惠券僅限用於[契約小舖-強化磁心組合(初級) 100入]，使用後可以1黑魂的價格購買強化磁心組合(初級) 100入，有效期限3天。",
                    probability: "0.45%",
                },
                {
                    item_name: "1黑魂-強化磁心組合(中級) 100入",
                    description:
                        "此優惠券僅限用於[契約小舖-強化磁心組合(中級) 100入]，使用後可以1黑魂的價格購買強化磁心組合(中級) 100入，有效期限3天。",
                    probability: "0.35%",
                },
                {
                    item_name: "1黑魂-強化磁心組合(高級) 100入",
                    description:
                        "此優惠券僅限用於[契約小舖-強化磁心組合(高級) 100入]，使用後可以1黑魂的價格購買強化磁心組合(高級) 100入，有效期限3天。",
                    probability: "0.30%",
                },
                {
                    item_name: "1黑魂 - 強化磁心組合(最高級) 100入",
                    description:
                        "此優惠券僅限用於[契約小舖-強化磁心組合(最高級) 100入]，使用後可以1黑魂的價格購買強化磁心組合(最高級) 100入，有效期限3天。",
                    probability: "0.10%",
                },
            ],
            claimHistory1: [
                {
                    coupon: "",
                    coupon_deadline: "",
                    item: "",
                },
            ],
            claimHistory2: [
                {
                    coupon: "",
                    coupon_deadline: "",
                    item: "",
                },
            ],
        };
    },
    //方法
    methods: {
        // logout
        logout_dg(){
            document.getElementById("logout-form").submit();
        },
        //popS_open
        openPop() {
            this.popS.isModalOpen = true;
        },
        //open popup
        openModal(modalData) {
            this.popXL.isModalOpen = true;
            // 設listChange為modalData 偵測 點擊哪個跳窗 就會顯示不同list
            this.popXL.listChange = modalData;
            // 讓tab回歸左邊先亮
            this.changeTab(0);
            if (modalData === 1) {
                this.popXL.tabExist = false;
                this.popXL.titleText = "活動說明";
                this.popXL.wrapText = `
          1. 活動時間：2024/02/06(二) 10:00 ~ 2024/02/20(二) 12:00​​​​<br>
          2. 活動期間內，每日遊戲累積登入時間達1小時，即可點擊『祈求庇佑』領取登入獎勵，並隨機獲得一張契約小舖優惠券，每日限領一次。​​<br>
          3. 登入時間滿1小時後，需先重新登入遊戲/切換頻道系統才會更新在線時間，並開放領取獎勵。(伺服器更新最長需要10分鐘，若當下未能領取獎勵請稍後再次嘗試)​​<br>
          4. 活動期間內，玩家可點擊『加倍祝福』按鈕，抽取一張契約小舖優惠券，每次抽取費用皆為「30 黑魂」，不限次數。每次抽取優惠券皆可額外獲得一個Buff道具獎勵。​​<br>
          5. 每日登入獎勵領取後將直接發送至遊戲內Cash背包，契約小舖優惠券將直接發送至契約小舖優惠券介面。​<br>
          <span>※ 提醒您，伺服器更新在線時間最長需要10分鐘。請盡量避免於換日前進行『祈求庇佑』活動，以致獎勵無法及時領取。</span>`;
            } else if (modalData === 2) {
                this.popXL.titleText = "獎勵一覽";
                this.popXL.tabExist = true;
                this.popXL.wrapText = ``;
            } else if (modalData === 3) {
                this.popXL.tabExist = false;
                this.popXL.titleText = "注意事項";
                this.popXL.wrapText = `
          1. 各帳號登入獎勵不限伺服器每日限領一次，若已在黑恆星伺服器累積登入達1小時並領取獎勵，即使使用冰珀星伺服器角色累積登入達指定時數，仍無法再次領取登入獎勵。​<br>
          2. 每日登入獎勵將直接發送至遊戲內Cash背包， Cash背包為冰珀星、黑恆星角色共通，請玩家自行選擇要領取的伺服器角色，獎勵一旦領取後即無法再進行更動，請玩家領取前特別留意。​​<br>
          3. 部分契約小舖優惠券設有使用限制，僅能用於指定區域的道具購買，若購買道具非指定區域內商品，結帳時將不會出現於可使用的優惠券選項內。​​<br>
          4. 契約小舖優惠券設有使用期限，已過期的優惠券將無法再繼續使用，請玩家自行留意各優惠券使用期限。​​<br>
          5. 每張優惠券僅限用於一項商品，若該項商品數量大於一時將無法使用優惠券進行折抵。每項商品限使用一張優惠券。​<br>​
          6. 本次販售之優惠券為機會中獎商品，消費者購買或參與活動不代表即可獲得特定商品。​​<br>
          7. 登入獎勵獲取的虛寶道具可能有綁定、交易、販賣或使用時間等限制，實際道具設定以遊戲獲取為準。​​<br>
          8. 發現活動或領獎機制出現系統或其他異常時，請第一時間透過<a href="https://www.digeam.com/cs" target="blank">「線上客服中心」</a>回報，若逕行利用該異常取得非屬原活動機制應得之獎勵者，本公司有權終止其進行遊戲及會員服務資格。​​<br>
          9. 本公司有權檢視各參加者之活動參與行為及得獎情形是否涉嫌，例：人為操作、惡意灌票、蓄意偽造、多開（重）帳號、短時間異常多筆參與行為、透過任何電腦程式參與活動、詐欺、任何違反會員系統服務合約及停權管理規章之情事者，或以任何其他不正當的方式意圖以進行不實或虛偽活動參與行為，參賽者因上述情形所獲得之活動資格及獎項，本公司得一概取消之，其帳號亦將停權處份。​​<br>
          10. 玩家參與本活動之同時，即同意接受本活動辦法與注意事項之規範，如不同或有違反，應視為無參加資格 ，或本公司得取消其使用資格，如因此有致生損害於本公司或其他任何第三人，本公司得向參加者請求損害賠償，參加者應負一切相關責任。​​<br>
          11. 掘夢網保留變更、取消或終止本活動的權利，包括但不限於本活動條款及活動辦法。​​<br>`;
            } else if (modalData === 4) {
                this.popXL.tabExist = true;
                this.popXL.titleText = "領取紀錄";
                this.popXL.wrapText = "";
            }
        },
        //tab
        changeTab(isTab) {
            this.tab.activeContent = isTab;
        },
        // login api
        async getSetting() {
            try {
                const response = await axios.post(api, {
                    type: "login",
                    user: this.logIn.account,
                });
                if (response.data.status == -90) {
                    this.logIn.finished = true;
                } else if (response.data.status == 1) {
                    this.logIn.pointText = response.data.point;
                    this.logIn.finished = false;
                    this.logIn.isLogin = true;
                }else if(response.data.status == -99){
                    this.logIn.isLogin = false;
                }
            } catch (err) {
                console.log(err);
            }
        },
        // prayBut click call api
        async prayClick() {
            this.popS.popBut3 = false;
            this.popS.popBut2 = false;
            this.popS.popBut1 = true;
            if(this.isClickable){
                if (this.logIn.finished == true) {
                    this.popS.titleText = "活動已結束";
                    this.popS.wrapText = "";
                    this.popS.butText1 =
                        "<a href='https://cbo.digeam.com/'><div class='popBut1'>是</div></a>";
                    this.openPop();
                } else if (this.logIn.isLogin == false) {
                    this.popS.titleText = "請先登入帳號";
                    this.popS.wrapText = "";
                    this.popS.butText1 =
                        "<a href='https://www.digeam.com/login'><div class='popBut1'>是</div></a>";
                    this.openPop();
                } else if (this.logIn.isLogin == true) {
                    this.isClickable = false;
                    try {
                        const response = await axios.post(api, {
                            type: "pray",
                            user: this.logIn.account,
                        });
                        if (response.data.status == -98) {
                            this.popS.titleText = "";
                            this.popS.wrapText =
                                "您膜拜的時間還不夠久，眾神聽不到您的祈求。<br>​本日累積在線時間：" +
                                response.data.accumulated +
                                "分";
                            this.popS.butText1 =
                                "<div class='popBut1' >晚點再來</div>";
                            this.openPop();
                        } else if (response.data.status == -97) {
                            this.popS.titleText = "您今日已經祈求過眾神的庇佑了。​";
                            this.popS.wrapText = "";
                            this.popS.butText1 =
                                "<div class='popBut1'>明天再來</div>";
                            this.openPop();
                        } else if (response.data.status == 1) {
                            this.popS.titleText = "您已獲得眾神的庇佑";
                            this.popS.wrapText =
                                `<span>` +
                                response.data.item_name +
                                `<br>【優惠券】` +
                                response.data.coupon_name +
                                `</span>`;
                            this.popS.popBut1 = false;
                            this.openPop();
                        }
                    } catch (err) {
                        console.log(err);
                    }
                    finally{
                        setTimeout(() =>{
                            this.isClickable = true ;
                        },500)
                    }
                }
            }
        },
        // blessBut click
        blessClick() {
            this.popS.popBut3 = false;
            this.popS.popBut2 = false;
            this.popS.popBut1 = true;
            if( this.logIn.finished == true){
                this.popS.titleText = "活動已結束";
                this.popS.wrapText = "";
                this.popS.butText1 =
                    "<a href='https://cbo.digeam.com/'><div class='popBut1'>是</div></a>";
                this.openPop();
            }else if (this.logIn.isLogin == false) {
                this.popS.titleText = "請先登入帳號";
                this.popS.wrapText = "";
                this.popS.butText1 =
                    "<a href='https://www.digeam.com/login'><div class='popBut1'>是</div></a>";
                this.openPop();
            } else if (this.logIn.isLogin == true) {
                this.popS.popBut3 = true;
                this.popS.popBut2 = true;
                this.popS.popBut1 = false;
                this.popS.titleText = "您是否要花費【30Cash】領取加倍祝福？";
                this.popS.wrapText = "";
                this.popS.butText2 = "<div class='popBut2'>否</div>";
                this.openPop();
            }
        },
        // blessBut click confirm call api
        async blessConfirm() {
            this.popS.titleText = "";
            this.popS.wrapText = "";
            this.popS.popBut3 = false;
            this.popS.popBut2 = false;
            this.popS.popBut1 = false;
            if( this.isClickable ){
                this.isClickable = false;
                try {
                    const response = await axios.post(api, {
                        type: "bless",
                        user: this.logIn.account,
                    });
                    if (response.data.status == -98) {
                        this.popS.popBut1 = true;
                        this.popS.titleText = "剩餘點數不足​​";
                        this.popS.wrapText = "";
                        this.popS.butText1 =
                            "<a href ='https://www.digeam.com/member/billing'><div class='popBut1'>前往儲值</div></a>";
                        this.openPop();
                    } else if (response.data.status == -97) {
                        this.popS.popBut1 = true;
                        this.popS.titleText = "您今日已經祈求過眾神的庇佑了。​";
                        this.popS.wrapText = "";
                        this.popS.butText1 = "<div class='popBut1'>明天再來</div>";
                        this.openPop();
                    } else if (response.data.status == 1) {
                        this.popS.popBut1 = true;
                        this.popS.titleText = "您已獲得加倍的祝福";
                        this.popS.wrapText =
                            `<span>` +
                            response.data.item_name +
                            `<br>【優惠券】` +
                            response.data.coupon_name +
                            `</span>`;
                        this.popS.popBut1 = false;
                        this.openPop();
                        this.getSetting();
                    }
                } catch (err) {
                    console.log(err);
                } finally {
                    setTimeout(()=>{
                        this.isClickable =true ;
                    },1000)
                }
            }
        },
        // history click call api
        async history(type) {
            try {
                const response = await axios.post(api, {
                    type: "history",
                    user: this.logIn.account,
                    history_type: type,
                });
                if (response.data.status == 1) {
                    if (type === "pray") {
                        this.claimHistory1 = response.data.list;
                    } else if (type === "bless") {
                        this.claimHistory2 = response.data.list;
                    }
                }
            } catch (err) {
                console.log(err);
            }
        },
        //close popup
        closeModal() {
            this.popXL.isModalOpen = false;
            this.popS.isModalOpen = false;
        },
    },
    //函式
    mounted: function () {
        var accTextElement = document.querySelector('.accText');
        var user =  accTextElement.innerText;
        this.logIn.account = user;
        // this.logIn.account = "digeamcbo04";
        this.getSetting();
        particlesJS("particles-js", {
            "particles": {
                "number": {
                    "value": 400,
                    "density": {
                        "enable": true,
                        "value_area": 3000
                    }
                },
                "color": {
                    "value": "#eee"
                },
                "shape": {
                    "type": "circle",
                    "stroke": {
                        "width": 0,
                        "color": "#fff"
                    },
                    "polygon": {
                        "nb_sides": 3
                    },
                    "image": {
                        "src": "img/github.svg",
                        "width": 100,
                        "height": 100
                    }
                },
                "opacity": {
                    "value": 1,
                    "random": true,
                    "anim": {
                        "enable": false,
                        "speed": 1,
                        "opacity_min": 0.3,
                        "sync": false
                    }
                },
                "size": {
                    "value": 3,
                    "random": true,
                    "anim": {
                        "enable": true,
                        "speed": 5,
                        "size_min": 0,
                        "sync": false
                    }
                },
                "line_linked": {
                    "enable": false,
                    "distance": 500,
                    "color": "#ffffff",
                    "opacity": 0.8,
                    "width": 2
                },
                "move": {
                    "enable": true,
                    "speed": 7.8914764163227265,
                    "direction": "top-right",
                    "random": true,
                    "straight": false,
                    "out_mode": "out",
                    "bounce": false,
                    "attract": {
                        "enable": false,
                        "rotateX": 600,
                        "rotateY": 1200
                    }
                }
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": {
                    "onhover": {
                        "enable": false,
                        "mode": "bubble"
                    },
                    "onclick": {
                        "enable": false,
                        "mode": "repulse"
                    },
                    "resize": true
                },
                "modes": {
                    "grab": {
                        "distance": 400,
                        "line_linked": {
                            "opacity": 0.5
                        }
                    },
                    "bubble": {
                        "distance": 400,
                        "size": 4,
                        "duration": 0.3,
                        "opacity": 1,
                        "speed": 3
                    },
                    "repulse": {
                        "distance": 200,
                        "duration": 0.4
                    },
                    "push": {
                        "particles_nb": 4
                    },
                    "remove": {
                        "particles_nb": 2
                    }
                }
            },
            "retina_detect": true

        });
    },
}).mount("#app");


