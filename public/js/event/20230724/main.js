// 開啟時間7/28 18:00 出來的月份會是6
const openDate = new Date('2023, 7, 28, 18: 0: 0');
// 玩家當前時間 7月 同樣會出現6
const nowDate = new Date();

function jumpToReserve(){
    const timeNum = openDate - nowDate ;
    if ( timeNum >0 ){
        $('.popText').html('尚未開啟，敬請期待');
        $('.pop').show();
    }else if( timeNum <= 0 ){
        window.location.href="https://cbo.digeam.com/20230803";
    }
}

$(".popup_close").click(function() {
    $(".mask").fadeOut(200);
});