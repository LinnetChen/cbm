//一載入得到的初始狀態
var login = 1;  //掘夢網帳號登入?
var user_status = -99;  //掘夢網帳號綁定狀態
var cabal_status = 1;  //黑色契約帳號綁定狀態

var digeamAccount = 'abc123456';  //掘夢網帳號
var cabalAccount = 'cabal123456abc';  //黑色契約帳號

var user_CD = 7200; //被綁定剩餘時間


if(login == 1 && user_status == 1){ //已登入且已綁定
    succes();

    //step1階段三
    $('.step1Text').html(`
        您已登入掘夢網帳號<span>`+digeamAccount+`</span>
    `);

    //step2階段三
    $('.step2Text').html(`
        <div class="step2Text">您已登入黑色契約遊戲帳號<p>`+cabalAccount+`</p></div>
    `);
    
    $('.step2Text').css({
        marginTop: '20%'
    });
}else if(login == 1 && user_status == -99){ //已登入但未綁定也輸入資料
    //step1階段二
    $('.step1Text').html(`
        您已登入掘夢網帳號<p>`+digeamAccount+`</p>
        <a class="step1_register" href="">登&nbsp;出</a>
    `);
    
    //step2階段二
    $('.step2').html(`
        <h2>輸入黑色契約遊戲帳密</h2>
        <form action="" method="post" target="_blank">
            <label>
                帳號
                <input name="user">
            </label><br/>
            <label>
                密碼
                <input name="pwd">
            </label><br/>
            <label>
                二次密碼
                <input name="2ndpwd">
            </label>
        </form>
    `)

    //step3階段二
    $('.step3').html(`
        <div class="step3checkbox">
            <input type="checkbox" id="checkbox" name="noticecheck">
            <label>我已經閱讀並同意<span class="step3notice" onclick="noticeIn()">會員轉移注意事項</span></label>
        </div>
        <div class="step3checkbtn" id="step3checkbtn">確認綁定</div>
    `);

    if(screen.width <= 820){
        $('.step3').html(`
            <div class="step3checkbox">
                <input type="checkbox" name="peas">
                <label>我已經閱讀並同意<br/><span class="step3notice" onclick="noticeIn()">會員轉移注意事項</span></label>
            </div>
            <div class="step3checkbtn" id="step3checkbtn">確認綁定</div>
        `);
    }
    $('.step3checkbtn').attr('onclick','doublecheckIn(500)');

    $('.step3checkbtn').css({
        background: 'url(../img/btn_blue1.png)no-repeat',
        cursor: 'pointer'
    });

    var the_btn = document.getElementById("step3checkbtn");

    $('.step3checkbtn').on('click',function(){
        var checkbox = document.getElementById("checkbox");
        if(checkbox.checked){
        
            if(user_status == -98){//錯誤5次鎖定
                error5times();
            }else if(user_status == -99 && cabal_status == 1){//正確
                correct();
            }else if(user_status == -99 && cabal_status == -99){
                accorpwderror();
            }else if(user_status == -99 && cabal_status == -98){
                error2ndpwd();
            }else if(user_status == -99 && cabal_status == -97){
                alreadylock();
            }
        
        }else{
            noticecheck();
        }
    });

}else if ( login == 0 ){ //未登入
    //step1階段一
    $('.step1Text').html(`
        <div class="btnBox">
        <a class="step1_login" href="https://digeam.com/login" target="_blank">前往登入</a>
        <a class="step1_register" href="https://digeam.com/register" target="_blank">立即申請</a>
        </div>
    `);
    
    //step2階段一
    $('.step2Text').html(`
        <div class="step2noticebtn">請先登入掘夢網帳號</div>
    `);

    //step3階段一
    $('.step3').html(`
        <div class="step3checkbox">
            <input type="checkbox" id="checkbox" name="noticecheck">
            <label>我已經閱讀並同意<span class="step3notice" onclick="noticeIn()">會員轉移注意事項</span></label>
        </div>
        <div class="step3checkbtn" id="step3checkbtn">確認綁定</div>
    `);

    if(screen.width <= 820){
        $('.step3').html(`
            <div class="step3checkbox">
                <input type="checkbox" name="peas">
                <label>我已經閱讀並同意<br/><span class="step3notice" onclick="noticeIn()">會員轉移注意事項</span></label>
            </div>
            <div class="step3checkbtn" id="step3checkbtn">確認綁定</div>
        `);
    }

}



//回到頂層
$('.topbtn').on('click',function (){
    $('body,html').animate({scrollTop:'0px'},800);
})

//螢幕寬度820以下menu外觀
if(screen.width<=820){
    var menuSwitch = 1
    $('.barBG').show();
    $('.barBG').on('click',function(){
        if(menuSwitch == 1){
            $('.mobel_mask').animate({left: '0vw'},500);
            $('.links,.sociallink').delay(300).fadeIn(300);
            $('.footer-btn').fadeOut(300);
            menuSwitch = -1;
        }else{
            $('.mobel_mask').delay(100).animate({left: '-100vw'},500);
            $('.links,.sociallink').fadeOut(300);
            $('.footer-btn').delay(350).fadeIn(300);
            menuSwitch = 1;
        }
    });
}









//資訊正確，確認綁定?
function correct(){
    
    $('.doublecheckframe').html(`
        <div class="doublecheckText">
            確定要將掘夢網帳號<span>`+digeamAccount+`</span>綁定<br/>
            黑色契約遊戲帳號<span>`+cabalAccount+`</span>嗎?<br>
            帳號一經綁定便無法更動。確定要進行綁定嗎?
        </div>
        <div class="checkbtn" onclick="succes()">確&nbsp;定</div>
        <div class="cancelbtn" onclick="doublecheckOut()">取&nbsp;消</div>
    `);
    
    if(screen.width <= 820){
        $('.doublecheckText').html(`
            確定要將掘夢網帳號<br/><span>`+digeamAccount+`</span><br/>綁定黑色契約遊戲帳號<br/><span>`+cabalAccount+`</span>嗎?<br>
            帳號一經綁定便無法更動。確定要進行綁定嗎?
        `);
    }
    
    if(screen.width <= 425){
        $('.doublecheckText').html(`
            確定要將掘夢網帳號<br/><span>`+digeamAccount+`</span><br/>
            綁定黑色契約遊戲帳號<br/><span>`+cabalAccount+`</span>嗎?<br>
            帳號一經綁定便無法更動，<br/>確定要進行綁定嗎?
        `);
    }

}

//錯誤5次
function error5times(){

    var CDtime = user_CD/3600;
    
    $('.doublecheckframe').html(`
        <div class="doublecheckText">
            帳號密碼輸入錯誤次數過多，無法登入。<br/>
            請<span>`+CDtime+`小時</span>稍後再嘗試
        </div>
        <div class="checkbtn" onclick="doublecheckOut()">確&nbsp;定</div>
    `);
    
    if(screen.width <= 425){
        $('.doublecheckText').html(`
            帳號密碼輸入錯誤次數過多，<br/>無法登入。<br/>
            請<span>`+CDtime+`小時</span>稍後再嘗試
        `);
    }
    
    $('.checkbtn').css({
        left: '50%',
        translate: '-50%'
    });

}

//帳號或密碼錯誤
function accorpwderror(){

    $('.doublecheckframe').html(`
        <div class="doublecheckText">
            遊戲帳號或密碼輸入錯誤。
        </div>
        <div class="checkbtn" onclick="doublecheckOut()">確&nbsp;定</div>
    `);
    
    $('.checkbtn').css({
        left: '50%',
        translate: '-50%'
    });

}

//二次密碼錯誤
function error2ndpwd(){

    $('.doublecheckframe').html(`
        <div class="doublecheckText">
            二次密碼輸入錯誤。
        </div>
        <div class="checkbtn" onclick="doublecheckOut()">確&nbsp;定</div>
    `);
    
    $('.checkbtn').css({
        left: '50%',
        translate: '-50%'
    });

}

//該帳號已被綁定
function alreadylock(){

    var lockingAccount = digeamAccount.slice(0,2) + lockname() + digeamAccount.slice(-2);
    
    $('.doublecheckframe').html(`
        <div class="doublecheckText">
            該遊戲帳號已完成綁定，無法再進行綁定。<br/>綁定帳號：<span>`+lockingAccount+`</span>
        </div>
        <div class="checkbtn" onclick="doublecheckOut()">確&nbsp;定</div>
    `);
    
    if(screen.width <= 425){
        $('.doublecheckText').html(`
            該遊戲帳號已完成綁定，<br/>無法再進行綁定。<br/>綁定帳號：<span>`+lockingAccount+`</span>
        `);
    }
    
    $('.checkbtn').css({
        left: '50%',
        translate: '-50%'
    });
    
    function lockname(){
        var str = ''
        for(m = 0 ; m < digeamAccount.length-4 ; m++){
            str += '*';
        }
        return str
    }

}



//綁定完成，記得追蹤粉絲專頁
function succes(){
    doublecheckOut(0);
    $('.doublecheckframe').html(`
        <div class="doublecheckText">
            綁定完成!記得追蹤<a href="https://www.facebook.com/DiGeamCabal" target="_blank">粉絲專頁</a>，隨時獲取遊戲最新消息。
        </div>
        <div class="checkbtn" onclick="doublecheckOut()">確&nbsp;定</div>
    `);
    
    $('.checkbtn').css({
        left: '50%',
        translate: '-50%'
    });
    
    $('.doublecheckText a').css({
        color: '#adfffb',
        textDecoration: 'none'
    });

    if(screen.width <= 425){
        $('.doublecheckframe').html(`
            <div class="doublecheckText">
                綁定完成!<br/>記得追蹤<a href="https://www.facebook.com/DiGeamCabal" target="_blank">粉絲專頁</a>，<br/>隨時獲取遊戲最新消息。
            </div>
            <div class="checkbtn" onclick="doublecheckOut()">確&nbsp;定</div>
        `);
        
        $('.checkbtn').css({
            left: '50%',
            translate: '-50%'
        });
        
        $('.doublecheckText a').css({
            color: '#adfffb',
            textDecoration: 'none'
        });
    }

    doublecheckIn(500);
    
    //step3階段三
    $('.step3').html(`
        <div class="step3checkbox">
            您已成功綁定帳號!記得<a href="https://www.facebook.com/DiGeamCabal" target="_blank">按讚粉絲團</a>掌握第一手消息!
        </div>
        <div class="step3checkbtn">
            <div class="step3notice" onclick="noticeIn()">會員轉移注意事項</div>
        </div>
    `);
    
    if(screen.width <= 820){
        $('.step3').html(`
            <div class="step3checkbox">
                您已成功綁定帳號!<br/>記得<a href="https://www.facebook.com/DiGeamCabal" target="_blank">按讚粉絲團</a>掌握第一手消息!
            </div>
            <div class="step3checkbtn">
                <div class="step3notice" onclick="noticeIn()">會員轉移注意事項</div>
            </div>
        `);
    }
    
    if(screen.width <= 425){
        $('.step3').html(`
            <div class="step3checkbox">
                您已成功綁定帳號!<br/>記得<a href="https://www.facebook.com/DiGeamCabal" target="_blank">按讚粉絲團</a><br/>掌握第一手消息!
            </div>
            <div class="step3checkbtn">
                <div class="step3notice" onclick="noticeIn()">會員轉移注意事項</div>
            </div>
        `);
        $('.step3checkbtn').css({
            width: '100%',
        });
    }
    
    $('.step3checkbox').css({
        marginTop: '15%'
    });
    
    $('.step3checkbtn').css({
        background: 'none',
        marginTop: '0%',
        width: 'fit-content',
        height: 'auto',
        fontSize: '25px',
        color: '#adfffb',
        filter: 'none',
        cursor: 'pointer'
    });
}