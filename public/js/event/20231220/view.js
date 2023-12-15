//彈窗
$(function () {
    $('.right_btn_pop').on("click", function () {
        $(".mask").fadeIn();
        let popID = $(this).data("pop");
        if (popID == "event") {
            $(".pop").fadeIn();
            $(".pop_wrap").html(
                `<div class="pop_title">活動說明</div>
                <div class="pop_content">
                    <h2>活動時間：</h2>
                    <p>2023/12/20~2023/12/25每晚1800~2200​</p>
                    <h2>活動進行方式：</h2>
                    <ol>
                        <li>1. 活動期間內，活動頁面將於每晚18~22點販售7項限定商品。其中包含6項「搶購商品」與1項「1元商品」。</li>
                        <li>2. 「1元商品」每個帳號每小時限購1次，整點刷新購買次數。</li>
                        <li>3. 「搶購商品」的販售數量有限，並且每過20分鐘就會降價一次，直至全部售完為止。玩家可在活動頁面上查看當前價格與剩餘數量。</li>
                        <li>4. 每晚22時，將停止販售所有商品。</li>
                    </ol>
                    <h2>販售商品：</h2>
                    <table class="table1">
                        <thead>
                            <tr>
                                <th width="23px">日期</th>
                                <th width="20px">伺服器</th>
                                <th width="50px">商品名稱</th>
                                <th width="20px">初始</br>價格</th>
                                <th width="18px">每次降價金額</th>
                                <th width="18px">全服限購數量</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td rowspan="13">12/20</br>12/21</td>
                                <td rowspan="6" class="ice_td">冰珀星</td>
                                <td>防具屬性賦予書(超越)-刀劍技能增幅</td>
                                <td>20000</td>
                                <td>1600</td>
                                <td>3</td>
                            </tr>
                            <tr>
                                <td>防具屬性賦予書(超越)-魔法技能增幅</td>
                                <td>20000</td>
                                <td>1600</td>
                                <td>3</td>
                            </tr>
                            <tr>
                                <td>防具屬性賦予書(超越)-所有技能增幅</td>
                                <td>30000</td>
                                <td>2500</td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td>打磨道具(最高級)</td>
                                <td>3000</td>
                                <td>260</td>
                                <td>30</td>
                            </tr>
                            <tr>
                                <td>GM的祝福(LV.5)聖水 x 30</td>
                                <td>1500</td>
                                <td>130</td>
                                <td>50</td>
                            </tr>
                            <tr>
                                <td>憤怒藥水(特大) x 100</td>
                                <td>1000</td>
                                <td>90</td>
                                <td>80</td>
                            </tr>
                            <tr>
                                <td rowspan="6" class="black_td">黑恆星</td>
                                <td>防具屬性賦予書(最高級)-刀劍技能增幅</td>
                                <td>20000</td>
                                <td>1600</td>
                                <td>3</td>
                            </tr>
                            <tr>
                                <td>防具屬性賦予書(最高級)-魔法技能增幅</td>
                                <td>20000</td>
                                <td>1600</td>
                                <td>3</td>
                            </tr>
                            <tr>
                                <td>防具屬性賦予書(最高級)-所有技能增幅</td>
                                <td>30000</td>
                                <td>2500</td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td>打磨道具(高級)</td>
                                <td>3000</td>
                                <td>260</td>
                                <td>30</td>
                            </tr>
                            <tr>
                                <td>GM的祝福(LV.4)聖水 x 30</td>
                                <td>1500</td>
                                <td>130</td>
                                <td>50</td>
                            </tr>
                            <tr>
                                <td>憤怒藥水(大) x 200</td>
                                <td>1000</td>
                                <td>90</td>
                                <td>80</td>
                            </tr>
                            <tr>
                                <td>1元</br>商品</td>
                                <td>貝拉德里克斯的加護 x 5</td>
                                <td>1</td>
                                <td>--</td>
                                <td>--</td>
                            </tr>
                            <tr>
                                <td rowspan="13">12/22</br>12/23</td>
                                <td rowspan="6" class="ice_td">冰珀星</td>
                                <td>瑪瑙珠+20</td>
                                <td>20000</td>
                                <td>1600</td>
                                <td>3</td>
                            </tr>
                            <tr>
                                <td>混沌的奧秘+17</td>
                                <td>20000</td>
                                <td>1600</td>
                                <td>3</td>
                            </tr>
                            <tr>
                                <td>末日混沌護身符</td>
                                <td>30000</td>
                                <td>2500</td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td>狂暴戒指 +4</td>
                                <td>3000</td>
                                <td>260</td>
                                <td>30</td>
                            </tr>
                            <tr>
                                <td>神性藥水(未達100級) 25%</td>
                                <td>1500</td>
                                <td>130</td>
                                <td>50</td>
                            </tr>
                            <tr>
                                <td>卡瑪符文石兌換券箱(紫) x 5</td>
                                <td>1000</td>
                                <td>90</td>
                                <td>80</td>
                            </tr>
                            <tr>
                                <td rowspan="6" class="black_td">黑恆星</td>
                                <td>瑪瑙珠+12</td>
                                <td>20000</td>
                                <td>1600</td>
                                <td>3</td>
                            </tr>
                            <tr>
                                <td>混沌的奧秘+12</td>
                                <td>20000</td>
                                <td>1600</td>
                                <td>3</td>
                            </tr>
                            <tr>
                                <td>混沌護身符+10</td>
                                <td>30000</td>
                                <td>2500</td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td>防止強化等級下降輔助劑(最高級) x 5</td>
                                <td>3000</td>
                                <td>260</td>
                                <td>30</td>
                            </tr>
                            <tr>
                                <td>極限磁心Lv.12</td>
                                <td>1500</td>
                                <td>130</td>
                                <td>50</td>
                            </tr>
                            <tr>
                                <td>AP儲存箱(1500/1500)</td>
                                <td>1000</td>
                                <td>90</td>
                                <td>80</td>
                            </tr>
                            <tr>
                                <td>1元</br>商品</td>
                                <td>喇叭 x 5</td>
                                <td>1</td>
                                <td>--</td>
                                <td>--</td>
                            </tr>
                            <tr>
                                <td rowspan="13">12/24</br>12/25</td>
                                <td rowspan="6" class="ice_td">冰珀星</td>
                                <td>極限強化封印石(精良):防具+3</td>
                                <td>20000</td>
                                <td>1600</td>
                                <td>3</td>
                            </tr>
                            <tr>
                                <td>極限強化封印石(精良):單手武器+3</td>
                                <td>20000</td>
                                <td>1600</td>
                                <td>3</td>
                            </tr>
                            <tr>
                                <td>極限強化封印石(精良):星際飛車+4</td>
                                <td>30000</td>
                                <td>2500</td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td>極限強化封印石(精良)</td>
                                <td>3000</td>
                                <td>260</td>
                                <td>30</td>
                            </tr>
                            <tr>
                                <td>神聖靈石組合 x 999</td>
                                <td>1500</td>
                                <td>130</td>
                                <td>50</td>
                            </tr>
                            <tr>
                                <td>符文打磨道具 - 初階</td>
                                <td>1000</td>
                                <td>90</td>
                                <td>80</td>
                            </tr>
                            <tr>
                                <td rowspan="6" class="black_td">黑恆星</td>
                                <td>防止強化等級下降輔助劑(混沌)</td>
                                <td>20000</td>
                                <td>1600</td>
                                <td>3</td>
                            </tr>
                            <tr>
                                <td>星際飛車卡 - PW5</td>
                                <td>20000</td>
                                <td>1600</td>
                                <td>3</td>
                            </tr>
                            <tr>
                                <td>極限強化封印石(精良):防具+3</td>
                                <td>30000</td>
                                <td>2500</td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td>注視之鏡(金)</td>
                                <td>3000</td>
                                <td>260</td>
                                <td>30</td>
                            </tr>
                            <tr>
                                <td>完美磁心(最高級)</td>
                                <td>1500</td>
                                <td>130</td>
                                <td>50</td>
                            </tr>
                            <tr>
                                <td>特效屬性強化晶片(最高級)</td>
                                <td>1000</td>
                                <td>90</td>
                                <td>80</td>
                            </tr>
                            <tr>
                                <td>1元</br>商品</td>
                                <td>打磨道具(中級)</td>
                                <td>1</td>
                                <td>--</td>
                                <td>--</td>
                            </tr>
                        </tbody>
                    </table>
                    <h2>注意事項：</h2>
                    <ol>
                        <li>1. 商品售出後，玩家會在CASH背包中收到對應商品的兌換券道具。玩家須在<span>2024年1月9日維護前</span>將道具領出，並和血色冰峰的活動NPC兌換對應商品，否則視同放棄。​</li>
                        <li>2. 由於冰珀星、黑恆星伺服器的CASH背包相通，若玩家在錯誤的伺服器領取兌換券，將導致道具無法正常兌換，請務必留意。​</li>
                        <li>3. 所有商品的實際售價及剩餘數量，依購買時的伺服器紀錄為準。玩家可重整活動頁面來查看最新的價格與數量。​</li>
                        <li>4. 本活動各項辦法及規定，以本公司官方說明為準，本公司擁有解釋、變更、修改本活動之權利。若因遇不可抗力之因素，本公司有暫停、延後、取消部分或全部活動之權利。如有其他未盡事宜，本公司有權隨時補充或修正，並以最新公告為主。​</li>
                    </ol>
                </div>`
            );
        }
    });
});

function close_pop() {
    $(".pop, .pop_s, .mask, .pop_buy").fadeOut();
}
function close_pop_reload() {
    $(".pop_s, .mask").fadeOut();
    location.reload();
}

//道具說明
$(".hover_info").hide();
$(".item").on("mouseenter", function () {
    var id = $(this).data("id");
    switch (id) {
        case 1:
            title = "防具屬性賦予書(超越)-<span>刀劍</span>技能增幅";
            text = "為超越級防具的插槽賦予特殊屬性時使用的賦予書。";
            break;
        case 2:
            title = "防具屬性賦予書(超越)-<span>魔法</span>技能增幅";
            text = "為超越級防具的插槽賦予特殊屬性時使用的賦予書。";
            break;
        case 3:
            title = "防具屬性賦予書(超越)-<span>所有</span>技能增幅";
            text = "為超越級防具的插槽賦予特殊屬性時使用的賦予書。";
            break;
        case 4:
            title = "打磨道具(最高級)";
            text = "可對最高級的裝備使用。使用後可擴充1格特殊屬性插槽，並提升特殊屬性的能力。使用後該道具和帳號綁定。";
            break;
        case 5:
            title = "GM的祝福(LV.5)聖水 x 30";
            text = "使用後可獲得以下Buff效果，持續1小時。帳號綁定。</br>HP +1000</br>防禦力 +200</br>攻擊率 + 2500</br>防禦率 +1000</br>致命傷害 +40%</br>致命機率 + 8%</br>HP吸收上限 +20</br>致命機率上限 +3%</br>HP吸收量 +5%</br>HP恢復率 +25每2秒</br>額外傷害 +2%</br>額外減傷 +2%</br>無視貫穿 +130</br>傷害減少 +80</br>命中 +1000</br>貫穿 +120</br>所有攻擊力 +180</br>所有技能增幅 +17%";
            break;
        case 6:
            title = "憤怒藥水(特大) x 100";
            text = "使用後可恢復10000點的SP。";
            break;
        case 7:
            title = "防具屬性賦予書(最高級)-<span>刀劍</span>技能增幅";
            text = "為最高級防具的插槽賦予特殊屬性時使用的賦予書。";
            break;
        case 8:
            title = "防具屬性賦予書(最高級)-<span>魔法</span>技能增幅";
            text = "為最高級防具的插槽賦予特殊屬性時使用的賦予書。";
            break;
        case 9:
            title = "防具屬性賦予書(最高級)-<span>所有</span>技能增幅";
            text = "為最高級防具的插槽賦予特殊屬性時使用的賦予書。";
            break;
        case 10:
            title = "打磨道具(高級)";
            text = "可對高級的裝備使用。使用後可擴充1格特殊屬性插槽，並提升特殊屬性的能力。使用後該道具和帳號綁定。";
            break;
        case 11:
            title = "GM的祝福(LV.4)聖水 x 30";
            text = "使用後可獲得以下Buff效果，持續1小時。帳號綁定。</br>HP +700</br>防禦力 +135</br>攻擊率 + 1800</br>防禦率 +700</br>致命傷害 +30%</br>致命機率 + 6%</br>HP吸收上限 +15</br>致命機率上限 +1%</br>HP吸收量 +4%</br>HP恢復率 +20每2秒</br>額外傷害 +1%</br>額外減傷 +1%</br>無視貫穿 +80</br>傷害減少 +60</br>命中 +600</br>貫穿 +70</br>所有攻擊力 +120</br>所有技能增幅 +13%";
            break;
        case 12:
            title = "憤怒藥水(大) x 200";
            text = "使用後可恢復5000點的SP。";
            break;
        case 13:
            title = "貝拉德里克斯的加護 x 5";
            text = "在使用的狀態下HP變成0時會恢復成100%，以避免死亡。只能在副本內使用。離開副本後效果消失。此商品為帳號綁定。";
            break;
        case 14:
            title = "瑪瑙珠+20";
            text = "HP+50</br>防禦力 +170</br>防禦率 +350</br>傷害減少 +70</br>增加致命傷害 +16%</br>所有技能增幅 +10%</br>貫穿 +60</br>HP藥水恢復量 +30%</br>HP +250";
            break;
        case 15:
            title = "混沌的奧秘+17";
            text = "HP +50</br>所有攻擊力 +120</br>致命傷害 +22%</br>所有技能增幅 +14%</br>命中 +120</br>貫穿 +50</br>HP +80</br>無視傷害減少 +15</br>抵銷無視貫穿 +9";
            break;
        case 16:
            title = "末日混沌護身符";
            text = "HP +170</br>防禦力 +60</br>所有攻擊力 +50</br>技能增幅抵抗 +15%</br>單次攻擊吸收HP量上限 +25</br>所有技能增幅 +6%</br>額外減傷 +7%</br>額外增傷 +6%";
            break;
        case 17:
            title = "狂暴戒指 +4";
            text = "致命傷害 +20%</br>無視致命傷害抵抗 +2%";
            break;
        case 18:
            title = "神性藥水(未達100級) 25%";
            text = "MXP +25%";
            break;
        case 19:
            title = "卡瑪符文石兌換券箱(紫) x 5";
            text = "箱子內含4~20個卡瑪符文石兌換券。帳號綁定";
            break;
        case 20:
            title = "瑪瑙珠+12";
            text = "HP+50</br>防禦力 +70</br>防禦率 +160</br>傷害減少 +25</br>增加致命傷害 +5%</br>所有技能增幅 +4%</br>HP藥水恢復量 +15%";
            break;
        case 21:
            title = "混沌的奧秘+12";
            text = "HP +50</br>所有攻擊力 +70</br>致命傷害 +12%</br>所有技能增幅 +9%</br>命中 +40</br>貫穿 +10";
            break;
        case 22:
            title = "混沌護身符+10";
            text = "HP +150</br>防禦力 +50</br>所有攻擊力 +40</br>技能增幅抵抗 +10%</br>單次攻擊吸收HP量上限 +20</br>所有技能增幅 +5%</br>額外減傷 +6%</br>額外增傷 +5%";
            break;
        case 23:
            title = "防止強化等級下降輔助劑(最高級) x 5";
            text = "強化時登錄此道具，可防止強化最高級裝備時，因強化失敗造成強化等級下降。注意：若登錄的數量不足將視同未使用道具，強化後仍有機率造成強化等級下降。";
            break;
        case 24:
            title = "極限磁心Lv.12";
            text = "極限強化時使用。使用愈高等級的極限磁心可提升極限強化的成功機率。";
            break;
        case 25:
            title = "AP儲存箱(1500/1500)";
            text = "使用後可獲的1500的AP。";
            break;
        case 26:
            title = "喇叭 x 5";
            text = "可在全頻道廣播(國戰頻道無法使用)。此商品為帳號綁定。";
            break;
        case 27:
            title = "極限強化封印石(精良):防具+3";
            text = "將裝備的極限強化等級封印後，用於交易的道具(防具+3)。";
            break;
        case 28:
            title = "極限強化封印石(精良):單手武器+3";
            text = "將裝備的極限強化等級封印後，用於交易的道具(單手武器+3)。";
            break;
        case 29:
            title = "極限強化封印石(精良):星際飛車+4";
            text = "將裝備的極限強化等級封印後，用於交易的道具(星際飛車+4)。";
            break;
        case 30:
            title = "極限強化封印石(精良)";
            text = "可將裝備上3~7級的極限強化等級進行封印，並用於交易的道具。";
            break;
        case 31:
            title = "神聖靈石組合 x 999";
            text = "可用於神聖強化。";
            break;
        case 32:
            title = "符文打磨道具 - 初階";
            text = "可擴充初階符文插槽(最多擴充至44個)。";
            break;
        case 33:
            title = "防止強化等級下降輔助劑(混沌)";
            text = "防止混沌強化時被破壞，或混沌屬性被重置(包含耳環、項鍊、手鐲)。可透過道具強化視窗使用，消耗數量依強化等級不同而異。";
            break;
        case 34:
            title = "星際飛車卡 - PW5";
            text = "原始文明時代的遺產磁心技術的精華，可用於召喚星際飛車。";
            break;
        case 35:
            title = "極限強化封印石(精良):防具+3";
            text = "將裝備的極限強化等級封印後，用於交易的道具(防具+3)。";
            break;
        case 36:
            title = "注視之鏡(金)";
            text = "鑑定強效器所使用的道具。注視之鏡等級愈高，鑑定時獲得高級效果的機率也愈高。";
            break;
        case 37:
            title = "完美磁心(最高級)";
            text = "可用於強化最高級裝備，成功機率100%。";
            break;
        case 38:
            title = "特效屬性強化晶片(最高級)";
            text = "使用後有一定機率提升最高級裝備的特效屬性能力。並且不論成功與否道具都將自動消失。";
            break;
        case 39:
            title = "打磨道具(中級)";
            text = "可對中級的裝備使用。使用後可擴充1格特殊屬性插槽，並提升特殊屬性的能力。使用後該道具和帳號綁定。此商品為帳號綁定商品。";
            break;
    }
    $(this).find(".hover_info").show();
    $(this).find(".hover_info").html(
        `<div class="hover_info_title">` + title + `</div>
    <p>`+ text + `</p>`);
});

$(".item").on("mouseleave", function () {
    $(".hover_info").hide();
});

//tab切換
// 檢查 Cookie 是否保存了選擇狀態
var selectedTab = $.cookie('selectedTab');

// 如果 Cookie 中有保存選擇狀態，則顯示對應的 tab
if (selectedTab) {
    $(selectedTab).show().siblings('.sell').hide();
    $('.tab_btn[data-target="' + selectedTab + '"]').addClass('active');
} else {
    // 如果 Cookie 中沒有保存選擇狀態，就讓 #ice 被選中
    $('#ice').show().siblings('.sell').hide();
    $('.tab_btn[data-target="#ice"]').addClass('active');
}

// 處理 tab 點擊事件
$('.tab_btn').click(function() {
    var target = $(this).data('target');
    $(target).show().siblings('.sell').hide();
    $(this).addClass('active').siblings('.tab_btn').removeClass('active');

    // 保存選擇狀態到 Cookie
    $.cookie('selectedTab', target);
});

