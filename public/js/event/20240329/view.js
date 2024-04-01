//說明彈窗
$(function() {
    function infoPopUp(content) {
        $(".mask, .popL").fadeIn();
        $(".pop_wrap").html(`
            ${content}
        `);
    }
    $('.act01').on("click", function() {
        const content = `
            <div class="pop_content">
            <div class="pop_title">活躍玩家如何獲取綁定碼？ </div>
            <p>活躍玩家資格：於2024/3/1至3/31間，有《黑色契約》遊戲登入紀錄的玩家。<br></p>
            <div style="padding: 0 0 10px;"></div>
            <p>綁定碼取得方式：<br></p>
            <ol>
                <li>
                1.活動期間內，活躍玩家可前往<a style="color: #6493ff;" href="https://cbo.digeam.com/giftContent/21" target="_blank">領獎專區</a>，領取「活躍玩家簽到禮」。            
                </li>
                <li>
                2.活躍玩家簽到禮將發送至活動背包中，並於獎勵標題顯示綁定碼。
                </li>
                <li>
                <img src="img/event/20240329/sendGift.jpg" ><br>
                </li>
                <li>
                3.請注意，同一帳號一、二服的綁定碼不同，並且每個帳號僅能被綁定<br>&nbsp;&nbsp;&nbsp;一次。發放綁定相關獎勵時，會依據回歸/新手玩家輸入的綁定碼，<br>&nbsp;&nbsp;&nbsp;發送至對應的伺服器。
                </li>
            </ol>                
            </div>`;
            infoPopUp(content);
    });

    $('.act02').on("click", function() {
        const content = `<div class="pop_content">
        <div class="pop_title">活動說明</div>
        <ol>
            <li>
            1.4/2維護後至4/30 12:00前，每日達成以下條件，即可於活動頁面領<br>&nbsp;&nbsp;&nbsp;
            取「資源補給卡」。資源補給卡可透過血色冰峰的活動執行員猶珥兌<br>&nbsp;&nbsp;&nbsp;
            換GM的祝福藥水、祝福寶珠等實用道具。
            </li>
        </ol>
        <div style="padding: 0 0 10px;"></div>
        <p style=" text-align: center;">領獎條件</p>
        <div class="actTableBox">
            <table >
                <thead>
                    <tr>
                        <th>領獎條件​</th>
                        <th>說明</th>
                        <th>補給卡數量​</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>簽到</td>
                        <td>每日回到活動頁面，即可領取獎勵。​</td>
                        <td>30</td>
                    </tr>
                    <tr>
                        <td>保持在線</td>
                        <td>保持在線狀態回到活動頁面，即可領取獎勵。​</td>
                        <td>10</td>
                    </tr>
                    <tr>
                        <td>加入公會</td>
                        <td>帳號內至少有一隻角色已加入公會。​</td>
                        <td>30</td>
                    </tr>
                    <tr>
                        <td>消費</td>
                        <td>消費任意金額。​</td>
                        <td>50</td>
                    </tr>
                    <tr>
                        <td>達到100級</td>
                        <td>帳號內有任一角色達到100級以上。​</td>
                        <td>50</td>
                    </tr>
                    <tr>
                        <td>達到170級</td>
                        <td>帳號內有任一角色達到170級以上。​</td>
                        <td>80</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="padding: 0 0 10px;"></div>
        <p style=" text-align: center;">資源補給卡可兌換獎勵</p>
        <div class="actTableBox">
            <table >
                <thead>
                    <tr>
                        <th>道具名稱</th>
                        <th>綁定</th>
                        <th>補給卡數量</th>
                        <th>使用期限</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>祝福寶珠 - 經驗值增加(80%) 2小時 x 1</td>
                        <td>帳號​</td>
                        <td>15</td>
                        <td>7日</td>
                    </tr>
                    <tr>
                        <td>祝福寶珠 - Wexp增加(75%) 2小時 x 1</td>
                        <td>帳號​</td>
                        <td>15</td>
                        <td>7日</td>
                    </tr>
                    <tr>
                        <td>副本入場道具寶箱 x 1</td>
                        <td>-​</td>
                        <td>20</td>
                        <td>無限制</td>
                    </tr>
                    <tr>
                        <td>GM的祝福(Lv4)聖水 x 1</td>
                        <td>帳號​</td>
                        <td>40</td>
                        <td>7日</td>
                    </tr>
                    <tr>
                        <td>祝福寶珠 - 掉落率增加(50%) 2小時 x 1</td>
                        <td>帳號​</td>
                        <td>50</td>
                        <td>7日</td>
                    </tr>
                    <tr>
                        <td>祝福寶珠 - 寶箱掉落率增加(100%) 2小時 x 1</td>
                        <td>帳號​</td>
                        <td>60</td>
                        <td>7日</td>
                    </tr>
                    <tr>
                        <td>特殊兌換券 x 200</td>
                        <td>帳號​</td>
                        <td>80</td>
                        <td>7日</td>
                    </tr>
                    <tr>
                        <td>憤怒藥水(大) x 15</td>
                        <td>帳號​</td>
                        <td>80</td>
                        <td>無限制</td>
                    </tr>
                    <tr>
                        <td>[服裝]軍事黑制服 x 1</td>
                        <td>帳號​</td>
                        <td>100</td>
                        <td>1日</td>
                    </tr>
                    <tr>
                        <td>彩繪克隆 x 3</td>
                        <td>帳號​</td>
                        <td>100</td>
                        <td>無限制</td>
                    </tr>
                    <tr>
                        <td>鍛鍊的煉金藥(131級以上) 1000萬 x 1</td>
                        <td>帳號​</td>
                        <td>100</td>
                        <td>無限制</td>
                    </tr>
                    <tr>
                        <td>犧牲的誓約(5小時) x 1</td>
                        <td>帳號​</td>
                        <td>200</td>
                        <td>無限制</td>
                    </tr>
                    <tr>
                        <td>保護的誓約(5小時) x 1</td>
                        <td>帳號​</td>
                        <td>200</td>
                        <td>無限制</td>
                    </tr>
                    <tr>
                        <td>防止強化等級下降輔助劑(高級) x 1</td>
                        <td>帳號​</td>
                        <td>450</td>
                        <td>1個月</td>
                    </tr>
                    <tr>
                        <td>完美磁心(高級) x 1</td>
                        <td>帳號​</td>
                        <td>800</td>
                        <td>1個月</td>
                    </tr>
                    <tr>
                        <td>插槽擴充器(中級飛車) x 1</td>
                        <td>帳號​</td>
                        <td>1500</td>
                        <td>無限制</td>
                    </tr>
                    <tr>
                        <td>封印的暴君戒指 x 1</td>
                        <td>帳號​</td>
                        <td>1500</td>
                        <td>無限制</td>
                    </tr>
                    <tr>
                        <td>星際飛車卡 - BLUE x 1</td>
                        <td>角色​</td>
                        <td>2000</td>
                        <td>無限制</td>
                    </tr>                          
                </tbody>                        
            </table>
            </div>
            <div style="padding: 0 0 10px;"></div>
            <ol>
                <li>
                    2.新手/回歸玩家每次領獎時，被綁定的帳號亦可同時獲得一半的資源<br>&nbsp;&nbsp;&nbsp;補給卡。
                </li>
                <li>
                    3.本活動每日早上6點重置領獎。未及時領取者視同放棄領獎資格。
                </li>
                <li>
                    4.於活動中途綁定的活躍玩家，將不會補發綁定前已發送的資源補給<br>&nbsp;&nbsp;&nbsp;卡，請特別留意。
                </li>
                <li>
                    5.本活動獎勵「資源補給卡」將發送至活動背包，並將於4/30維護後刪<br>&nbsp;&nbsp;&nbsp;除。
                </li>
                <li>
                    6.發現活動或領獎機制出現系統或其他異常時，請於第一時間透過「<a style="color: #6493ff;" href="https://digeam.com/cs" target="_blank">線<br>&nbsp;&nbsp;
                    上客服中心</a>」進行回報，若逕行利用該異常取得非屬原活動機制應得<br>&nbsp;&nbsp;
                    之獎勵者，本公司有權回收異常道具並終止其進行遊戲及會員服務資<br>&nbsp;&nbsp;&nbsp;格。
                </li>
                <li>
                7.掘夢網保留變更、取消或終止本活動的權利，包括但不限於本活動條<br>&nbsp;&nbsp;&nbsp;款及活動辦法。
                </li>
            </ol>
    </div>`;
        infoPopUp(content);
    });

    $('.act03').on("click", function() {
        const content = `<div class="pop_content">
        <div class="pop_title">活動說明</div>
        <ol>
                <li>
                    1.4/30前，回歸/新手玩家只要於契約小舖購買「白金之翼(30日)」，<br>&nbsp;&nbsp;
                    即可於活動頁面再領取一個「VIP啟動道具：白金之翼(30日)(不可交<br>&nbsp;&nbsp;
                    易)」。回歸/新手玩家領取獎勵後，所有綁定的活躍玩家皆可同時獲<br>&nbsp;&nbsp;
                    得一個「白金之翼(30日)75折折扣券」。
                </li>
                <li>
                    2.活動獎勵「VIP啟動道具：白金之翼(30日)」將發送至Cash背包中。<br>&nbsp;&nbsp;
                    折扣券則可透過契約小舖中的「Coupon」圖示查看。
                </li>
                <li>
                    3.於回歸/新手玩家領獎後才綁定的活躍玩家，亦會在綁定當下補發折<br>&nbsp;&nbsp;&nbsp;扣券。
                </li>
                <li>
                    4.本活動僅限購買「白金之翼(30日)」的新手/回歸玩家符合領獎資格<br>&nbsp;&nbsp;
                    。非新手/回歸玩家購買「白金之翼(30日)」，或購買「VIP啟動道<br>&nbsp;&nbsp;
                    具：白金之翼(30日)」皆不符合領獎資格，請特別留意。
                </li>
                <li>
                    5.所有獎勵皆不可交易。
                </li>
                <li>
                    6.發現活動或領獎機制出現系統或其他異常時，請於第一時間透過「<a style="color: #6493ff;" href="https://digeam.com/cs" target="_blank">線<br>&nbsp;&nbsp;
                    上客服中心</a>」進行回報，若逕行利用該異常取得非屬原活動機制應得<br>&nbsp;&nbsp;
                    之獎勵者，本公司有權回收異常道具並終止其進行遊戲及會員服務資<br>&nbsp;&nbsp;&nbsp;格。
                </li>
                <li>
                    7.掘夢網保留變更、取消或終止本活動的權利，包括但不限於本活動條<br>&nbsp;&nbsp;&nbsp;款及活動辦法。
                </li>

            </ol>
        </div>`;
        infoPopUp(content);
    });

    $('.act04').on("click", function() {
        const content = `<div class="pop_content">
        <div class="pop_title">升級好禮拿不完</div>
        <p>
        活動時間：4/2 12:00~4/30 12:00<br>
        活動說明：<br>
        </p>
        <div style="padding: 0 0 10px;"></div>
        <ol>
            <li>
                1.活動期間內160級以下角色，可全天候享有經驗值300%加成。
            </li>
            <li>
                2.活動期間達到指定等級，即可獲得以下獎勵。
            </li>
        </ol>
        <div class="actTableBox">
            <table style="text-align: center;">
                <thead>
                    <tr>
                        <th>等級​</th>
                        <th>獎勵內容</th>
                        <th>道具效果​</th>
                    </tr>
                </thead>
                <tbody style="text-align: center;">
                    <tr>
                        <td>Lv.10</td>
                        <td>旅行者聖水 x10​</td>
                        <td>移動速度+150，持續15分鐘。</td>
                    </tr>
                    <tr>
                        <td rowspan="2">Lv.20</td>
                        <td>MP藥水(中) x100​</td>
                        <td>使用後可恢復350的MP。</td>
                    </tr>
                    <tr>
                        <td>HP藥水(中) x100​</td>
                        <td>使用後可恢復350的HP。</td>
                    </tr>
                    <tr>
                        <td rowspan="2">Lv.30</td>
                        <td>憤怒藥水(中) x10​</td>
                        <td>使用後可恢復1000的SP。</td>
                    </tr>
                    <tr>
                        <td>強化磁心(初級)組合(10)​</td>
                        <td>相當於可疊加的10個強化磁心(初級)。</td>
                    </tr>
                    <tr>
                        <td rowspan="2">Lv.40</td>
                        <td>英雄聖水(15分鐘) x10​</td>
                        <td>使用後可提升40防禦力、40所有攻擊力、7%所有技能增幅。</td>
                    </tr>
                    <tr>
                        <td>抵抗聖水(15分鐘) x10​</td>
                        <td>提升狀態異常抵抗能力的聖水。</td>
                    </tr>
                    <tr>
                        <td>Lv.50</td>
                        <td>涅瓦雷斯 冒險家的證據 (14天)​</td>
                        <td>裝備後技能經驗值+8，經驗值增加+25，所有攻擊力增加+10，防禦力+20，HP+50。</td>
                    </tr>
                    <tr>
                        <td>Lv.60</td>
                        <td>星際滑板卡片 - K Sky (14天)​</td>
                        <td>HP+50，防禦力+18，移動速度600。</td>
                    </tr>
                    <tr>
                        <td rowspan="2">Lv.70</td>
                        <td>強化磁心(中級)組合(10)​</td>
                        <td>相當於可疊加的10個強化磁心(中級)。</td>
                    </tr>
                    <tr>
                        <td>守護的赤焰護肩 (7天)​</td>
                        <td>裝備後防禦力+25，防禦率+30，迴避+150，HP+150，傷害減少+5。</td>
                    </tr>
                    <tr>
                        <td rowspan="2">Lv.80</td>
                        <td>GM祝福(Lv.1)聖水 x10​</td>
                        <td>裝有GM祝福的聖水，使用後可獲得Buff效果。</td>
                    </tr>
                    <tr>
                        <td>復活結晶 x15​</td>
                        <td>儲存角色靈魂的護符，死亡後可在原地復活。</td>
                    </tr>
                    <tr>
                        <td rowspan="2">Lv.90</td>
                        <td>強化磁心(高級)組合(10)​</td>
                        <td>相當於可疊加的10個強化磁心(高級)。</td>
                    </tr>
                    <tr>
                        <td>活力聖水 x20​</td>
                        <td>可100%恢復HP和MP的聖水。</td>
                    </tr>
                    <tr>
                        <td>Lv.100</td>
                        <td>涅瓦雷斯戰士的證明 (14天)​</td>
                        <td>裝備後技能經驗值+12，經驗值增加+50，所有攻擊力增加+15，防禦力+30，HP+100。</td>
                    </tr>
                    <tr>
                        <td>Lv.110</td>
                        <td>名譽的特效藥(800萬)​</td>
                        <td>使用後，可獲得800萬的名譽點數。</td>
                    </tr>
                    <tr>
                        <td>Lv.120</td>
                        <td>[服裝]新手冒險家小雞坐騎(14天)​</td>
                        <td>致命傷害+3%、貫穿+20、HP+200。</td>
                    </tr>
                    <tr>
                        <td>Lv.130</td>
                        <td>幸運的特效藥(1000萬)​</td>
                        <td>使用後，可獲得1000萬Alz。</td>
                    </tr>
                    <tr>
                        <td>Lv.140</td>
                        <td>完美磁心(高級)​</td>
                        <td>可用於強化高級裝備，成功機率100%。</td>
                    </tr>
                    <tr>
                        <td>Lv.150</td>
                        <td>憤怒藥水(大) x 50​</td>
                        <td>使用後可大幅提升SP。</td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
        <p>
        <ol>
            <li>
                註：活動開始前，已超出指定等級的角色，不會再獲得獎勵。
            </li>
            <div style="padding: 0 0 10px;"></div>
            <li>
                4.角色達到指定等級後，獎勵將透過遊戲內郵件發送。玩家須於一周內<br>&nbsp;&nbsp;
                領取完畢。若未及時領取，郵件將被刪除。
            </li>
            <li>
                5.所有獎勵皆不可交易。
            </li>
            <li>
                6.發現活動或領獎機制出現系統或其他異常時，請於第一時間透過「<a style="color: #6493ff;" href="https://digeam.com/cs" target="_blank">線<br>&nbsp;&nbsp;
                上客服中心</a>」進行回報，若逕行利用該異常取得非屬原活動機制應得<br>&nbsp;&nbsp;
                之獎勵者，本公司有權回收異常道具並終止其進行遊戲及會員服務資<br>&nbsp;&nbsp;&nbsp;格。
            </li>
            <li>
            7.掘夢網保留變更、取消或終止本活動的權利，包括但不限於本活動條<br>&nbsp;&nbsp;&nbsp;款及活動辦法。
            </li>
        </ol>
        
    </div>`;
        infoPopUp(content);
    });
});
//敬請期待視窗
$(function(){
    $('#cbmRes, #cbmInt').on("click", function() {
        event.preventDefault();
        $(".mask").fadeIn(200);
        $(".popS").fadeIn(200);
        $(".pop_wrapS").html(
            `<div class="pop_contentS">
                <p>敬請期待。​</p>
            </div>
            <div class="popsBtnBox">
                <button class="btn" onclick="close_pop()">確定</button>
            </div>`
        );


    });
});
function close_popS() {
    $(".popS").fadeOut(200);
}
function close_pop() {
    $(".pop, .popL, .mask, .popS").fadeOut(200);
}
function close_pop_reload() {
    $(".pop, .mask").fadeOut();
    location.reload();
}