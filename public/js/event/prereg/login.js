let api = '/api/prereg_api';
let user = $('.StrID').data('val');
get_setting();

function showLoading() {
    var $loading = $('<div class="loading-spinner"><div class="dots"><div></div><div></div><div></div></div></div>').appendTo('body');
    return $loading;
}

function get_setting() {
    var $loading = showLoading();
    $.post(
        api,
        {
            type: 'login',
            user: user,
        },
        function (res) {

            console.log(res);
            data = res.postBoard[0];

            for (let i = 1; i <= 12; i++) {
                $('.post_' + i).html(`<p class="txt">${res.postBoard[i]?.post_txt}</p>
                <span class="name">By.${res.postBoard[i]?.post_name}</span>`)
            }

            if (res.status == -99) {
                $('.user_post , .rwd_user_post , .submit , .addPost').on('click', function () {
                    $('.mask , .pop_s').fadeIn();
                    $('.pop_txt').html(s1_login);
                })
                console.log(1);
            } else if (res.status == 1) {
                if (res.reserve == false) {
                    $('.user_post, .rwd_user_post , .addPost').on('click', function () {
                        $('.mask , .pop_s').fadeIn();
                        $('.pop_txt').html(book_msg);
                    })
                } else {

                    if (data.post_name !== '' && data.post_txt !== '') {
                        $('.user_post , .rwd_user_post').html(`<div class="txt">${res.postBoard[0]?.post_txt}</div>
                        <span class="name">By.${res.postBoard[0]?.post_name}</span>`)
                    } else {
                        $('.addPost').on('click', function () {
                            $('.mask ,.pop_page').fadeIn();
                        })
                    }
                }
            }




        }, "json"
    ).always(function () {
        $loading.remove();
    });
}

$(".your_name").on("change", function () {
    var user_name = $(this).val();
    $('.none_name').text(user_name);
})

$(".your_msg").on("change", function () {
    var user_msg = $(this).val();
    $('.none_msg').text(user_msg);
})

//電話號碼檢查
function checkMobile() {
    var _phone = $('#mobile').val();
    var _area = $('#mobile_area').val();
    // 台灣號碼為9碼
    if (_area == '+886') {
        if (_phone.length == 9 && !isNaN(_phone)) {
            return _area + _phone;
        } else if (_phone.length == 10 && !isNaN(_phone)) {
            // 有可能輸入09開頭,判斷第一碼是否為0
            if (_phone.substring(0, 1) != 0) {
                return -99
            } else {
                // 整理號碼,回傳0以外後9碼
                return _area + _phone.substring(1, 10);
            }
        } else {
            return -99
        }
        // 香港澳門號碼為8碼
    } else if (_area == '+852' || _area == '+853') {
        if (_phone.length == 8 && !isNaN(_phone)) {
            return _area + _phone;
        } else {
            return -99
        }
    } else {
        return -99;
    }
}


function submit() {
    // 判斷
    var _phone = checkMobile();
    var _agree = $('#checkbox').prop("checked");
    var _send = false;

    if (_agree != true) {
        $('.pop_s').fadeIn(200);
        $('.pop_s_wrap').html(s1_read)
        $('.mask').fadeIn(200)
    } else if (_phone == -99) {
        $('.pop_s').fadeIn(200);
        $('.pop_s_wrap').html(s1_phone)
        $('.mask').fadeIn(200)
    } else {
        _send = true
    }
    if (_send == true) {
        $.post(api, {
            type: 'reserve',
            user: user,
            phone: _phone,
        }, function (res) {
            console.log(res);
            console.log(_phone);
            $('.pop_s').fadeIn(200);
            $('.mask').fadeIn(200);
            if (res.status == -99) {
                $('.pop_s_wrap').html(s1_login)
            } else if (res.status == -98) {
                $('.pop_s_wrap').html(s1_phone)
            } else if (res.status == -97) {
                $('.pop_s_wrap').html(s1_done)
            } else if (res.status == -96) {
                $('.pop_s_wrap').html(s1_phone_use)
            } else if (res.status == 1) {
                $('.mask').fadeOut(200);
                $('.pop_s_wrap').html(s1_done);
                $('.maskR').fadeIn(200);
            } else if (res.status == 90) {
                $('.pop_s_wrap').html('<h3>活動已結束</h3>')
            } else {
                $('.pop_s_wrap').html('<h3>程式錯誤,請聯絡客服人員</h3>')
            }
        })
    }
}


function addPost() {
    var user_name = $('.none_name').text();
    var user_msg = $('.none_msg').text();
    if (user_name == '' && user_msg == '') {
        $('.alret').html('*名字及訊息不得為空！');
        return
    };
    var $loading = showLoading();
    $.post(
        api,
        {
            type: 'post',
            user: user,
            post_name: $('.none_name').text(),
            post_txt: $('.none_msg').text()
        },
        function (res) {
            console.log(res);
            if (res.status == 1) {
                $('.mask').fadeOut();
                $('.maskR').fadeIn();
                $('.pop_page_wrap').html(post_done);
            } else if (res.status == -95) {
                $('.maskR').fadeIn();
                $('.pop_page_wrap').html('<h2>你已留言過!</h2>');
            }


        }, "json"
    ).always(function () {
        $loading.remove();
    });
}
