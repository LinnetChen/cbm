var api = 'api/login';
var api2 = 'api/cabal_login';


// 登出
function logout_dg() {
    $("#logout-form").submit();
}
function loginAccount() {
    window.open("https://www.digeam.com/login", "_self");
}

get_setting();

function get_setting() {
    $.post(api,{
        type : 'login',
        user : $(".step1Text span").text() // 抓帳號

    },function(res){
        // let res = _resLogin;
        // let res = JSON.parse(_res);
        if ( res.status == -99 ){
            $('.step2Text').html(`
            <p><span>請先登入掘夢網帳號</span></p>
            `);
            $('.step3checkbtn').addClass('step3checkbtnA');
        }else if ( res.status == 1 ){
            $('.step3checkbtn').removeClass('step3checkbtnA');
            $('.step3checkbtn').addClass('step3checkbtnB');

            if ( res.cabal_status == -99 ){
                // 未綁
                $('.step2Text').html(`
                <form action="" method="post" target="_blank">
                    <label>
                        遊戲帳號
                        <input name="user">
                    </label><br/>
                    <label>
                        遊戲密碼
                        <input name="pwd" type="password">
                    </label><br/>
                    <label>
                        安全密碼
                        <input name="pwd2"  type="password">
                    </label>
                </form>
                `);

                $('.step3checkbtn').attr('onclick','confirm()');

            }else if ( res.cabal_status == 1 ){
                // 已綁
                $('.step2Text').html(`
                <div class="step2Text"><p>您已登入黑色契約遊戲帳號<br><span>`+res.account_locking+`</span></p></div>
                `);
                $('.step3').html(`
                <div class="step3Success">
                <p class="step3SuccessText">您已成功綁定帳號!<br>
                記得<a class="hrefFB" href="https://www.facebook.com/DiGeamCabal" target="_blank">按讚粉絲團</a>掌握<br>
                第一手消息!</p>
                <div class="step3notice" onclick="noticeIn()">會員轉移注意事項</div></div>
                `);
            }
        }

    })
}
