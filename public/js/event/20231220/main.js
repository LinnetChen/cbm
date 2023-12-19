
var reslogin = {
    status: 1,
    time: "n",
    point: 100,
    ice_iteminfo: [{ id: 1, price: "11000", quantity: "1" },
    { id: 6, price: "10000", quantity: "1" },
    { id: 2, price: "9000", quantity: "1" },
    { id: 3, price: "6000", quantity: "1" },
    { id: 4, price: "500", quantity: "1" },
    { id: 5, price: "300", quantity: "1" },],
    black_iteminfo: [{ id: 7, price: "11000", quantity: "1" },
    { id: 8, price: "20000", quantity: "1" },
    { id: 9, price: "4000", quantity: "1" },
    { id: 10, price: "6500", quantity: "1" },
    { id: 11, price: "510", quantity: "1" },
    { id: 12, price: "120", quantity: "1" },],
    iteminfo_1: 13,
    itemsell_1: "y",
};

var resbuy_recode = {
    status: 1,
    list: [
    { name: "憤怒藥水(特大) x 100", price: "100", server: "冰珀星", date: "12/25 20:00" },
    { name: "打磨道具(高級)", price: "11000", server: "黑恆星", date: "12/30 18:00" },
    { name: "GM的祝福(LV.4)聖水 x 30", price: "3000", server: "黑恆星", date: "12/25 18:00" },
    { name: "狂暴戒指 +4", price: "100", server: "黑恆星", date: "12/25 20:00" },
    { name: "瑪瑙珠+12", price: "11000", server: "冰珀星", date: "12/30 18:00" },
    { name: "混沌護身符+10", price: "3000", server: "冰珀星", date: "12/25 18:00" },
    { name: "極限磁心Lv.12", price: "100", server: "黑恆星", date: "12/25 20:00" },
    { name: "極限強化封印石(精良):防具+3", price: "11000", server: "黑恆星", date: "12/30 18:00" },
    { name: "喇叭 x 5", price: "1", server: "共通", date: "12/25 18:00" },
    ],
}

var resbuy = {
    status: -98,
}


// 登出
$('.ball_logout').on("click", function logout_dg() {
    $("#logout-form").submit();
});


// var user = "skyfull0411";
var user = $('.name').text();


var data_api = '/api/event231220_api';

get_setting();

function get_setting() {
    $.post(data_api, {
        type: "login",
        user: user,
    }, function (_res) {
        var res = _res;
        // let res = reslogin;
        if (res.time == "n") {
            //非活動時間
            $(".time_mask").css({ display: "block" });
            $('.price').html("?");
            $('.quantity').html("?");
            $('.item').removeClass(function(index, className) {
                return (className.match(/\bicon\d+/g) || []).join(' ');
            });
            $('.item').addClass("icon");
            $('sell').find('button').removeClass("btn_no").addClass("btn").html("購買");
            //活動時間
        } else if (res.time == "y") {
            //冰珀星資料
            for (let i = 0; i < res.ice_iteminfo.length; i++) {
                let iceItemBox = $('#ice').find('.item_box').eq(i);

                if (res.ice_iteminfo[i].quantity == 0) {
                    iceItemBox.find('button')
                        .html("售完")
                        .removeClass("btn")
                        .addClass("btn_no");
                } ;
                iceItemBox.find('.price').html(res.ice_iteminfo[i].price);
                iceItemBox.find('.quantity').html(res.ice_iteminfo[i].quantity);
                iceItemBox.find('.item').attr('data-id', res.ice_iteminfo[i].id);
                iceItemBox.find('.item').addClass("icon" + res.ice_iteminfo[i].id);
                iceItemBox.find('.btn').attr('id', res.ice_iteminfo[i].id);
            }
            //黑恆星資料
            for (let i = 0; i < res.black_iteminfo.length; i++) {
                let blackItemBox = $('#black').find('.item_box').eq(i);

                if (res.black_iteminfo[i].quantity == 0) {
                    blackItemBox.find('button')
                        .html("售完")
                        .removeClass("btn")
                        .addClass("btn_no");
                } ;
                blackItemBox.find('.price').html(res.black_iteminfo[i].price);
                blackItemBox.find('.quantity').html(res.black_iteminfo[i].quantity);
                blackItemBox.find('.item').attr('data-id', res.black_iteminfo[i].id);
                blackItemBox.find('.item').addClass("icon" + res.black_iteminfo[i].id);
                blackItemBox.find('.btn').attr('id', res.black_iteminfo[i].id);
            }
            //1元商品資料
            $('.item_box_1').find('.item').attr('data-id', res.iteminfo_1);
            $('.item_box_1').find('.item').addClass("icon" + res.iteminfo_1);
            $('.item_box_1').find('.btn').attr('id', res.iteminfo_1);
        }
        if (res.status == -99) {
            //未登入
            $('.item_box,.item_box_1').find('.btn').on("click", function () {
                $(".mask").fadeIn();
                $(".pop_s").fadeIn();
                $(".pop_s").find(".pop_wrap").html(
                    `<p>
                請先登入會員
            </p>`
                );
            });
        }
        else if (res.status == 1) {
            //已登入
            $('.point').html(res.point);
            //商品確認購買
            var cheaklock = "open";
            $('.item_box').find('.btn').on("click", function () {
                if (cheaklock == 'open') {
                    cheaklock = 'lock';
                    var price = $(this).closest('.item_box').find('.price').text();
                    var server = $('.active').text();
                    var id = $(this).attr("id");
                    switch (id) {
                        case "1":
                            title = "防具屬性賦予書(超越)-<span>刀劍</span>技能增幅";
                            break;
                        case "2":
                            title = "防具屬性賦予書(超越)-<span>魔法</span>技能增幅";
                            break;
                        case "3":
                            title = "防具屬性賦予書(超越)-<span>所有</span>技能增幅";
                            break;
                        case "4":
                            title = "打磨道具(最高級)";
                            break;
                        case "5":
                            title = "GM的祝福(LV.5)聖水 x 30";
                            break;
                        case "6":
                            title = "憤怒藥水(特大) x 100";
                            break;
                        case "7":
                            title = "防具屬性賦予書(最高級)-<span>刀劍</span>技能增幅";
                            break;
                        case "8":
                            title = "防具屬性賦予書(最高級)-<span>魔法</span>技能增幅";
                            break;
                        case "9":
                            title = "防具屬性賦予書(最高級)-<span>所有</span>技能增幅";
                            break;
                        case "10":
                            title = "打磨道具(高級)";
                            break;
                        case "11":
                            title = "GM的祝福(LV.4)聖水 x 30";
                            break;
                        case "12":
                            title = "憤怒藥水(大) x 200";
                            break;
                        case "14":
                            title = "瑪瑙珠+20";
                            break;
                        case "15":
                            title = "混沌的奧秘+17";
                            break;
                        case "16":
                            title = "末日混沌護身符";
                            break;
                        case "17":
                            title = "狂暴戒指 +4";
                            break;
                        case "18":
                            title = "神性藥水(未達100級) 25%";
                            break;
                        case "19":
                            title = "卡瑪符文石兌換券箱(紫) x 5";
                            break;
                        case "20":
                            title = "瑪瑙珠+12";
                            break;
                        case "21":
                            title = "混沌的奧秘+12";
                            break;
                        case "22":
                            title = "混沌護身符+10";
                            break;
                        case "23":
                            title = "防止強化等級下降輔助劑(最高級) x 5";
                            break;
                        case "24":
                            title = "極限磁心Lv.12";
                            break;
                        case "25":
                            title = "AP儲存箱(1500/1500)";
                            break;
                        case "27":
                            title = "極限強化封印石(精良):防具+3";
                            break;
                        case "28":
                            title = "極限強化封印石(精良):單手武器+3";
                            break;
                        case "29":
                            title = "極限強化封印石(精良):星際飛車+4";
                            break;
                        case "30":
                            title = "極限強化封印石(精良)";
                            break;
                        case "31":
                            title = "神聖靈石組合 x 999";
                            break;
                        case "32":
                            title = "符文打磨道具 - 初階";
                            break;
                        case "33":
                            title = "防止強化等級下降輔助劑(混沌)";
                            break;
                        case "34":
                            title = "星際飛車卡 - PW5";
                            break;
                        case "35":
                            title = "極限強化封印石(精良):防具+3";
                            break;
                        case "36":
                            title = "注視之鏡(金)";
                            break;
                        case "37":
                            title = "完美磁心(最高級)";
                            break;
                        case "38":
                            title = "特效屬性強化晶片(最高級)";
                            break;
                    };
                    $(".mask").fadeIn();
                    $(".pop_buy").fadeIn();
                    $(".pop_buy").find(".pop_wrap").html(
                        `<p>您確定要以<span>` + price + `</span>元購買
                </br>
                <span>`+ server + `</span>伺服器的
                </br>
                <span>`+ title + `</span>嗎？
            </p>`
                    );
                    $(".pop_buy").find(".btn_box").html(
                        ` <button class="btn" onclick="buy(` + id + `)">確定</button>
            <button class="btn_green" onclick="close_pop()">取消</button>`
                    );
                    cheaklock = 'open';
                }
            });
            //1元商品是否可購買
            if (res.itemsell_1 == "n") {
                $('.item_box_1').find('button')
                    .html("售完")
                    .removeClass("btn")
                    .addClass("btn_no");
            } else {
                $('.item_box_1').find('button')
                    .html("購買")
                    .removeClass("btn_no")
                    .addClass("btn");
            };
            //1元商品確認購買
            var cheak_1_lock = "open";
            $('.item_box_1').find('.btn').on("click", function () {
                if (cheak_1_lock == 'open') {
                    cheak_1_lock = 'lock';
                    var id = $(this).attr("id");
                    switch (id) {
                        case "13":
                            title = "貝拉德里克斯的加護 x 5";
                            break;
                        case "26":
                            title = "喇叭 x 5";
                            break;
                        case "39":
                            title = "打磨道具(中級)";
                            break;
                    }
                    $(".mask").fadeIn();
                    $(".pop_buy").fadeIn();
                    $(".pop_buy").find(".pop_wrap").html(
                        `<p>您確定要以<span>1</span>元購買
                    </br>
                    <span>`+ title + `</span>嗎？
                </p>`
                    );
                    $(".pop_buy").find(".btn_box").html(
                        ` <button class="btn" onclick="buy(` + id + `)">確定</button>
                <button class="btn_green" onclick="close_pop()">取消</button>`
                    );
                    cheak_1_lock = 'open';
                }
            });
        }
    }
    )
}


//購買商品
var buylock = "open";
function buy(i) {
    if (buylock == 'open') {
        buylock = 'lock';
        $.post(data_api, {
            type: "buy",
            user: user,
            buy_item: i,
        }, function (_res) {
            var res = _res;
            // let res = resbuy;
            $(".pop_buy").fadeOut();
            switch (res.status) {
                case -99:
                    text = "請先登入會員";
                    break;
                case -98:
                    text = "點數不足";
                    break;
                case -97:
                    text = "商品已售完";
                    break;
                case -96:
                    text = "非活動時間";
                    break;
                case 1:
                    text = "購買成功";
                    break;
            }
            $(".mask").fadeIn();
            $(".pop_s").fadeIn();
            $(".pop_s").find(".pop_wrap").html(
                `<p>
                    `+ text + `
                </p>`);
            $(".pop_s").find(".btn").attr("onclick", "close_pop_reload()");
        }
        );
    }
}


//購買紀錄
$('.history').on("click", function () {
    $.post(data_api, {
        type: "buy_recode",
        user: user,
    }, function (_res) {
        var res = _res;
        // let res = resbuy_recode;
        if (res.status == -99) {
            $(".mask").fadeIn();
            $(".pop_s").fadeIn();
            $(".pop_s").find(".pop_wrap").html(
                `<p>
                請先登入會員
            </p>`
            );
        } else if (res.status == 1) {
            if(res.list){
            $(".mask").fadeIn();
            let str = "";
            res.list.forEach((i) => {
                str += `<tr>
                 <td>${i.name}</td>
                 <td>${i.price}</td>
                 <td>${i.server}</td>
                 <td>${i.date}</td>
             </tr>`;
            });
            $(".pop").fadeIn();
            $(".pop_wrap").html(
                `<div class="pop_title">購買紀錄</div>
                <div class="pop_content">
                <table class="table2">
                    <thead>
                        <tr>
                            <th>道具名</th>
                            <th>金額</th>
                            <th>伺服器</th>
                            <th>購買時間</th>
                        </tr>
                    </thead>
                    <tbody>
                       `+ str + `
                    </tbody>
                </table>
                </div>`);
            }else{
                $(".mask").fadeIn();
                $(".pop_s").fadeIn();
                $(".pop_s").find(".pop_wrap").html(
                    `<p>
                    尚無購買紀錄。
                </p>`
                );
            }
        }
    })
})
;

//刷新賣場
$('.refresh_btn').on("click", function () {
    $(".mask").fadeIn();
    $(".refresh_text").fadeIn();
    //文字動畫
    var textWrapper = document.querySelector('.text');
    textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");
    anime.timeline({ loop: true })
        .add({
            targets: '.text .letter',
            translateX: [40, 0],
            translateZ: 0,
            opacity: [0, 1],
            easing: "easeOutExpo",
            duration: 1000,
            delay: (el, i) => 500 + 100 * i
        }).add({
            targets: '.text .letter',
            translateX: [0, -30],
            opacity: [1, 0],
            easing: "easeInExpo",
            duration: 900,
            delay: (el, i) => 100 + 100 * i
        });
    get_setting();
    setTimeout(function () {
        $(".mask").fadeOut();
        $(".refresh_text").fadeOut();
    }, 4000);
})





