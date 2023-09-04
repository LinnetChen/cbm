let api = '/api/prereg_api';
let user = $('.StrID').data('val');

// let api = 'http://192.168.0.41:8088/api/prereg_api'
// let user = 'digeamnatw01';
get_setting();

function logout_dg() {
    $("#logout-form").submit();
}

function showLoading() {
    var $loading = $('<div class="loading-spinner"><div class="dots"><div></div><div></div><div></div></div></div>').appendTo('body');
    return $loading;
}



function get_setting() {
    $.post(
        api,
        {
            type: 'login',
            user: user,
        },
        function (res) {
            console.log(res);
            data = res.postBoard[0];


            if (res.status == -99) {
                $('.user_post , .rwd_user_post , .submit , .addPost').on('click', function () {
                    $('.mask , .pop_s').fadeIn();
                    $('.pop_txt').html(s1_login);
                })

            } else if (res.status == 1) {

                if (res.reserve == false) {
                    $('.user_post, .rwd_user_post , .addPost').on('click', function () {
                        $('.mask , .pop_s').fadeIn();
                        $('.pop_txt').html(book_msg);
                    })
                } else {

                    if (data.post_name !== '' && data.post_txt !== '') {
                        let user_postTxt = res.postBoard[0]?.post_txt;
                        let user_postName = res.postBoard[0]?.post_name;

                        console.log(user_postTxt, user_postName);

                        let user_decodedTxt = Base64.decode(user_postTxt);
                        let user_decodedName = Base64.decode(user_postName);

                        console.log(user_decodedTxt, user_decodedName);

                        $('.user_post , .rwd_user_post').html(`<p class="txt">${user_decodedTxt}</p>
                        <span class="name">By.${user_decodedName}</span>`)
                    } else {
                        $('.addPost').on('click', function () {
                            $('.mask ,.pop_page').fadeIn();
                            console.log(res);
                        })
                    }

                }
            }

            
            for (let i = 1; i <= 12; i++) {
                let postTxt = res.postBoard[i]?.post_txt;
                let postName = res.postBoard[i]?.post_name;
                console.log(postTxt);
                console.log(postName);


                let decodedTxt = Base64.decode(postTxt);
                let decodedName = Base64.decode(postName);

                console.log(decodedTxt, decodedName);

                $('.post_' + i).html(`<p class="txt">${decodedTxt}</p>
                <span class="name">By.${decodedName}</span>`)
            }



        }, "json"
    )
}

$(".your_name").on("change", function () {
    var user_name = $(this).val();
    $('.none_name').text(user_name);
    //轉譯
    let txt = user_name;
    let en = Base64.encode(txt);
    console.log(en);
    $('.none_name').attr('data-base', en);
    let de = Base64.decode(en);
    console.log(de);
})

$(".your_msg").on("change", function () {
    var user_msg = $(this).val();
    $('.none_msg').text(user_msg);
    //轉譯
    let txt = user_msg;
    let en = Base64.encode(txt);
    console.log(en);
    $('.none_msg').attr('data-base', en);
    let de = Base64.decode(en);
    console.log(de);
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
        $('.pop_txt').html(s1_read)
        $('.mask').fadeIn(200)
    } else if (_phone == -99) {
        $('.pop_s').fadeIn(200);
        $('.pop_txt').html(s1_phone)
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
            $('.pop_s').fadeIn(200);
            $('.mask').fadeIn(200);
            if (res.status == -99) {
                $('.pop_txt').html(s1_login)
            } else if (res.status == -98) {
                $('.pop_txt').html(s1_phone)
            } else if (res.status == -97) {
                $('.pop_txt').html(s1_acc_use)
            } else if (res.status == -96) {
                $('.pop_txt').html(s1_phone_use)
            } else if (res.status == 1) {
                $('.mask').fadeOut(200);
                $('.pop_txt').html(s1_done);
                $('.maskR').fadeIn(200);
            } else if (res.status == 90) {
                $('.pop_txt').html('<h2>活動已結束</h2>')
            } else {
                $('.pop_txt').html('<h2>程式錯誤,請聯絡客服人員</h2>')
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
            post_name: $('.none_name').data('base'),
            post_txt: $('.none_msg').data('base')
        },
        function (res) {
            console.log(res);

            if (res.status == 1) {
                $('.mask').fadeOut();
                $('.maskR').fadeIn();
                $('.pop_page_wrap').html(post_done);
            } else if (res.status == -95) {
                $('.maskR').fadeIn();
                $('.pop_page_wrap').html(post_done_again);
            }


        }, "json"
    ).always(function () {
        $loading.remove();
    });
}
