

var _read = 'false';

// 已閱讀 換icon
function allRead(){
    if ($('.allRead').attr('data-allRead') == "false") {
        $('.allRead').html(` <i class="fa-solid fa-square-check" style="color: #fff"></i>`);
        $('.allRead').attr('data-allRead', "true");
        _read = 'true';
    } else if ($('.allRead').attr('data-allRead') == "true") {
        $('.allRead').html(`<i class="fa-regular fa-square" style="color: #fff"></i>`);
        $('.allRead').attr('data-allRead', "false");
        _read = 'false';
    }
}

// 綁定確認
function confirm(){
    if( _read == 'false'){
        // 未閱讀
        noticecheck();
    }else if (_read == 'true'){
        // 已閱讀
        $('.popText').html(`
        確定要將掘夢網帳號<span>`+$('.step1Text span').text()+`</span><br>
        綁定黑色契約遊戲帳號<span>`+$('input[name="user"]').val()+`</span>嗎?<br><br>
        帳號一經綁定便無法更動。確定要進行綁定嗎?
        `)
        $('.btnYes').attr('onclick','cabal_login()')
        $('.pop').show();
    }
}
// 黑契判定
function cabal_login(){
    $('.pop').hide();

    // $.post(api,{
    // type : 'cabal_login',
    // cabal_user :$('input[name="user"]').val() ,
    // cabal_pwd :$('input[name="pwd"]').val() ,
    // cabal_pwd2 :$('input[name="pwd2"]').val()

    // },function(_res){
        let res = resCabal;
        //     let res = JSON.parse(_res);

        if( res.status == -99 ){
            // 帳密錯誤
            if( res.error_times < 5 ){
                error();
            }else if( res.error_times >=5 ){
                $('.popBText').html(`
                帳號密碼輸入錯誤次數過多，無法登入。<br/>
                請<span>`+(res.error_CD/3600).toFixed(1)+`小時</span>稍後再嘗試
                `)
                $('.popB').show();
            }

        }else if( res.status == -98 ){
            // 已被綁定
            console.log(123);
            $('.popBText').html(`
            該遊戲帳號已完成綁定，無法再進行綁定。<br/>綁定帳號：<span>`+res.user_other[0]+res.user_other[1]+`****`+res.user_other[2]+res.user_other[3]+`</span>
            `)
            $('.popB').show();
        }else if( res.status == 1 ){
            // 成功綁定
            $('.boxB').html(`
            <div class="popBText">
            綁定完成!<br>
            記得<a href="https://www.facebook.com/DiGeamCabal" target="_blank">追蹤粉絲專頁</a>隨時
            <br>獲取遊戲最新消息。</div>
            `)
            $('.popB').show();
            setTimeout(function(){
                location.reload()
            },2000)
        }

    // })
}



//header
$(window).scroll(function () {
    var scrollTop = $(this).scrollTop(); //頁面top位置
    var scrollHeight = $(".title").height();//p1高度

    
    screen.width > 820 ? scrollTop >= scrollHeight ? $('.barBG').fadeIn(300) : $('.barBG').hide() : $('.barBG').fadeIn(300);

    if(screen.width <= 820){
        if(scrollTop >= scrollHeight){
            $('.barBG').css({
                backgroundImage:`linear-gradient(to bottom, rgb(0, 0, 0, 0.5), rgba(0, 0, 0, 0.25))`,
                borderBottom: `#ffffff 3px solid`
            })
            if(screen.width <= 425){
                $('.barBG').css({
                    backgroundImage:`linear-gradient(to bottom, rgb(0, 0, 0, 0.5), rgba(0, 0, 0, 0.25))`,
                    borderBottom: `#ffffff 3px solid`,
                    height:'60px'
                })
            }
        }else{
            $('.barBG').css({
                backgroundImage:`none`,
                borderBottom: `none`
            })
        }
    }
});

// rwdMenu開關
var menuSwitch = 1
function rwdMenu(){
    console.log(1);
    if(menuSwitch == 1){
        $('.rwdMenuBtn').addClass('on')
        $('.mobel_mask').animate({left: '0vw'},500);
        $('.links,.sociallink').delay(300).fadeIn(300);
        $('.footer-btn').fadeOut(300);
        menuSwitch = -1;
    }else{
        $('.rwdMenuBtn').removeClass('on')
        $('.mobel_mask').delay(100).animate({left: '-100vw'},500);
        $('.links,.sociallink').fadeOut(300);
        $('.footer-btn').delay(350).fadeIn(300);
        menuSwitch = 1;
    }
}



//footer隱藏按鈕
let c = 0;
$('.footer-btnbox').on('click',function(){
    //入
    if(c == 0){
        c += 1;
        $('footer').fadeIn(500);
        $('.footer-btn').css({
            opacity: '0.5'
        });
        $('.footer-btn p').delay(150).fadeOut(500);
        $('.footer-btnball').animate({
            marginLeft:'29px',
            rotate:'90deg'
        },500);
    }
    //出
    else{
        c -= 1;
        $('footer').fadeOut(800);
        $('.footer-btn').css({
            opacity: '1'
        });
        $('.footer-btnbox').css({
            "background-color":"rgba(194, 194, 194, 1)"
        });
        $('.footer-btn p').fadeIn(500);
        $('.footer-btnball').animate({
            marginLeft:'3px',
            rotate:'0deg'
        },500);
    }
});
if(screen.width <= 820){
    $('.footer-btn').hide();
    $('footer').show();
}



//注意事項
function noticeIn(){
    
    $('.XX,.noticeframe .checkbtn').on("click", function() {
        $('.notice').fadeOut(500);
    });
    $('.step3notice').on("click", function() {
        $('.notice').fadeIn(500);
    });
    $('.notice').fadeIn(500);
}

// 移到page2
function move() {
    $('html,body').animate({
        scrollTop: $('.page2').offset().top
    }, 10);
}

//請先閱讀注意事項
function noticecheck(){
    $('.popBText').html('請先閱讀並同意<span>會員轉移注意事項</span>')
    $('.popB').show();
}

// 錯誤提示
function error(){
    $('.popBText').html(`
    遊戲帳號密碼或二次密碼輸入錯誤。<br>
    輸入錯誤次數過多可能導致您被暫時封鎖，請特別留意。`)
    $('.popB').show();
}

// 關跳窗
function popClose(){
    $(".mask").fadeOut(200);
}

