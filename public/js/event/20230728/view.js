// 帳號假資料

var resLogin = {
    status: -99,
};
var resCabal = {
    status: -99,
    error_times: 5,
    error_CD: 7000,
};


// .jump_prereg_btn下滑時縮小
window.addEventListener("scroll", function () {
    var scrollY = window.scrollY || window.pageYOffset;
    var windowWidth = window.innerWidth;

    if (scrollY > 500 || windowWidth <800 ) {
        if( windowWidth <400 ){
            $('.jump_prereg_btn').attr('style','scale:.3');
        }else{
            $('.jump_prereg_btn').attr('style','scale:.6');
        }
    } else if (windowWidth >800 ) {
        $('.jump_prereg_btn').attr('style','scale:.6');;
    }else if (scrollY <500 && windowWidth >800 ) {
        $('.jump_prereg_btn').attr('style','scale:1');;
    }
});
