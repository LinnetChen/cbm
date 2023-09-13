

$(function () {
  $('.tab_content , .rwd_tab_content').hide();
  $('.tab_content[data-tab="tab1"]').show().addClass('active');
  $('.tab[data-tab="tab1"]').addClass('active');

  $('.rwd_tab_content[data-rwd="tab1"]').show().addClass('active');
  $('.rwd_tab[data-rwd="tab1"]').addClass('active');

  $('.tab').click(function () {
    var tabData = $(this).data('tab');

    if (tabData == 'tab2') {
 
      $('.book_wrap').css('background-image', 'url(../../../img/event/prereg/book2.png)');
      $('.refresh').hide();
    } else if (tabData == 'tab1') {
      $('.refresh').show();
      $('.book_wrap').css('background-image', 'url(../../../img/event/prereg/book.png)')
    }
    $('.tab_content').hide().removeClass('active');
    $('.tab').removeClass('active');
    $('.tab_content[data-tab="' + tabData + '"]').show().addClass('active');
    $('.tab[data-tab="' + tabData + '"]').addClass('active');
  });

  $('.rwd_tab').click(function () {
    var tabData = $(this).data('rwd');
    $('.rwd_refresh').hide();
    if (tabData == 'tab1') {
      $('.rwd_refresh').show();
    }
    $('.rwd_tab_content').hide().removeClass('active');
    $('.tab').removeClass('active');
    $('.rwd_tab_content[data-rwd="' + tabData + '"]').show().addClass('active');
    $('.rwd_tab[data-rwd="' + tabData + '"]').addClass('active');
  });
});

// menu開關
$(".menu_toggle , .sec").on('click', function () {
  $('.menu_toggle').toggleClass("on");
  $('.menu_section').toggleClass("on");
});





$('.maskR').on("click", function () {
  reload();
});

function reload() {
  cancel();
  location.reload();
}


function cancel() {
  $('.pop_b, .mask2, .pop_s, .pop_page , .mask').fadeOut();
}

$('.close , .mask2 , .mask').on("click", function () {
  cancel();
});

let s1_phone = `
<h2>請填寫正確的手機號碼</h2>
<br>
<span>請檢查是否符合以下限制：<br>
    台灣玩家的號碼，為不含特殊符號的半形數字10碼<br>
    港/澳玩家的號碼，為不含符號的半形數字8碼
</span>`

let s1_login = `
<h2>請先登入掘夢網會員</h2>
`


let s1_read = `
<h3>請閱讀並同意隱私權政策及接收獎勵資訊​</h3>
`

let s1_done = `
<h2>您已完成事前預約！​</h2>
<span>記得隨時關注 <a href="https://www.facebook.com/DiGeamCabal/" target="_blank">粉絲團</a>，掌握遊戲第一手消息。<span>
`


let s1_phone_use = `
<h2>該手機門號已被使用！​</h2>
<span>請使用其他門號參加事前預約活動​。<span>
`


let s1_acc_use = `
<h2>該帳號已參加過事前預約！​</h2>
`


let error = `
<h2>發生不明錯誤！</h2>
<span>請重整頁面或連繫客服<span>
`


let book_msg = `
<h2>請先完成事前預約再留言！</h2>
`

let post_done = `  <div class="page_tit"></div>
<h3>您已完成活動，記得按讚<a href="https://www.facebook.com/DiGeamCabal/" target="_blank">粉絲團</a><br>掌握第一手開獎資訊！</h3>`


let post_done_again = `  <div class="page_tit"></div>
<h3>您已寫下留言，記得按讚<a href="https://www.facebook.com/DiGeamCabal/" target="_blank">粉絲團</a><br>掌握第一手開獎資訊！</h3>`

$('.pop').on("click", function () {
  var pop = $(this).data('pop');
  $('.mask , .pop_b').fadeIn();
  if (pop == 1) {
    $('.pop_b_wrap').html(`<h2>【時裝箱】軍事黑制服(30日)​</h2>
     <h3>開啟後，可獲得軍事黑制服服裝與頭飾(30日)。​</br>
         不可交易，時裝箱需於領取後30日內使用。</h3>
     <div class="img_box">
         <img src="../../../img/event/prereg/male2.png" alt="">
         <img src="../../../img/event/prereg/female1.png" alt="">
     </div>`)
  } else if (pop == 2) {
    $('.pop_b_wrap').html(`<h2>【祝福寶珠】經驗值增加(50%) 12小時​</h2>
    <h3>使用後，可在12小時內增加50%經驗值獲得量。<br>
        道具效果可套用在同組帳號下的所有角色。<br>
        不可交易，道具需於領取後30日內使用。</h3>`)
  } else if (pop == 3) {
    $('.pop_b_wrap').html(`<h2>憤怒藥水(大)x50​</h2>
    <h3>使用後可大幅提升SP，不可交易。</h3>`)
  } else if (pop == 4) {
    $('.pop_b_wrap').html(`  <h2>注意事項​</h2>
    <ul>
        <li>
            1.若輸入無意義文字，或包含歧視、辱罵、政治等敏感議題與個人資訊的內容，可能使您的留言受到封鎖並失去活動資格。掘夢網將不另行通知。
        </li>
        <li>
            2.每個帳號只能參與一次活動並獲得一次獎勵。獎勵將於正式開服後一週內透過官網領獎專區發放。
        </li>
        <li>
            3.留言內容一經送出後即無法修改。
        </li>
        <li>
            4.實體獎勵將於每週五於粉絲專頁公布得獎名單。得獎名單公布後，受獎者須於七日內依相關法規填寫<a href="https://drive.google.com/file/d/1XF57KAVloQ3q_pQCJ4UvMEMnc-Lg26GG/view">機會中獎憑證</a>並回傳<a href="https://digeam.com/cs">客服中心</a>，否則視同放棄得獎資格。
        </li>
        <li>
            5.實體獎品寄送地址僅限台港澳地區，如地址不符合上述條件，恕無法寄出。
        </li>
        <li>
            6.本活動為機會中獎活動，參與活動不代表即可獲得特定商品。
        </li>
        <li>
            7.本活動各項辦法及規定，以官方說明為準，掘夢網公司擁有活動最終保留、變更、修改或撤回、取消獎項發送之權利。
        </li>
        <li>
            8.本活動的參加與獲獎紀錄依掘夢網後台紀錄為主。
        </li>
    </ul>`)
  }
})




$('.single-item').slick({
  dots: true,
  infinite: true,
  speed: 200,
  slidesToShow: 1,
  slidesToScroll: 1,

});