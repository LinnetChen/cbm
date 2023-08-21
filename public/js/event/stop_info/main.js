// 開啟時間7/28 18:00 出來的月份會是6
const openDate = new Date('2023, 7, 28, 18: 0: 0');
// 玩家當前時間 7月 同樣會出現6
const nowDate = new Date();


function onloadpop(){
    $('.popText').html('<div style="text-align: left;"><br><br><br>&nbsp;&nbsp;各位《黑色契約》的玩家您好：\
    <br><br>&nbsp;&nbsp;《黑色契約》會員轉移系統正在維護中，期間<br>&nbsp;&nbsp;將暫停轉移申請。請稍後再嘗試。\
    </div>');
    $('.pop').show();
}

function jumpToReserve(){
    const timeNum = openDate - nowDate ;
    if ( timeNum >0 ){
        $('.popText').html('預計7/28日18:00開始，敬請期待');
        $('.pop').show();
    }else if( timeNum <= 0 ){
        window.location.href="https://cbo.digeam.com/MembershipTransfer";
    }
}

$(".popup_close").click(function() {
    $(".mask").fadeOut(200);
});

window.onload = onloadpop;
