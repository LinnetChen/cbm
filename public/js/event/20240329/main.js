//測試
// var resStatus = {
//     status: [1, -99, -98, -97, -96, -95],
// };
// var resGift = ['y','n','y','n','n','y'];

// 登出
function logout_dg() {
    $("#logout-form").submit();
}


var data_api = '/api/event240403_api';

get_setting();

function get_setting() {
    $(function () {
        var checklock = true;
        //點擊按鈕後檢查是否登入
        $("#event01, #event02, #event03").on("click", function () {
            $(".mask").fadeIn();
            $(".loading").html(`載入中......`).fadeIn();
            if (checklock == true) {
                checklock = false;
                let eventId = this.id;
                $.post(data_api, {
                    type: "login",
                }, function (_res) {
                    $(".mask").fadeOut();
                    $(".loading").html(`載入中......`).fadeOut();
                    var res = _res;
                    // let res = { status: resStatus.status[0] };
                    if (res.status == 1) {
                        switch (eventId) {
                            //綁定活躍玩家
                            case 'event01':
                                bindEventPop();
                                break;
                            //獎勵領取
                            case 'event02':
                                sendGiftPop();
                                break;
                            //白金之翼
                            case 'event03':
                                wingPop();
                                break;
                        }
                        //未登入
                    } else if (res.status == -99) {
                        $(".mask").fadeIn();
                        $(".popS").fadeIn();
                        $(".pop_wrapS").html(
                            `<div class="pop_contentS">
                            <p>您尚未登入掘夢網帳號，是否現在登入？</p>
                        </div>
                        <div class="popsBtnBox">
                            <a class="loginBtn" href="https://www.digeam.com/login">立即登入</a>
                            <button class="btn" onclick="close_pop()">取消</button>
                        </div>`
                        );
                    }
                });
                setTimeout(function () {
                    checklock = true;
                }, 2000);


            }

        })
    })

}

//綁定視窗
function bindEventPop() {
    $(function () {
        //彈窗內容
        $(".mask").fadeIn(200);
        $(".pop").fadeIn(200);
        $(".pop_wrap").html(
            `
                <div class="pop_content">
                <div class="pop_title">STEP 1.選擇欲領取綁定禮的伺服器</div>
                    <div class="section server">
                        <select name="select_server">
                            <option value="server00">請選擇伺服器</option>
                            <option value="server01">冰珀星</option>
                            <option value="server02">黑恆星</option>
                        </select>
                    </div>
                    <div class="pop_title">STEP 2.輸入欲綁定對象的綁定碼</div>
                    <div class="bindBox">
                        <input type="text" placeholder="請輸入綁定碼">
                        <button class="btn">確定</button>
                    </div>
                    <div class="pop_title">綁定說明</div>
                    <p>1.完成綁定後，新手/回歸玩家與活躍玩家可獲得以下獎勵。</p>
                    <div style="padding: 0 0 10px;"></div>
                    <p>※綁定禮</p>
                    <div class="actTableBox">
                        <table >
                            <thead>
                                <tr>
                                    <th>資格​</th>
                                    <th>道具名稱</th>
                                    <th>使用期限​</th>
                                    <th>綁定​</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td rowspan="3">活躍玩家</td>
                                    <td>GM的祝福(Lv4)聖水 x 10​</td>
                                    <td rowspan="0">永久</td>
                                    <td rowspan="0">帳號</td>
                                </tr>
                                <tr>
                                    <td>指令藥水(特大) x 5</td>
                                </tr>
                                <tr>
                                    <td>神秘寶箱(稀有) x 2</td>
                                </tr>
                                <tr>
                                    <td rowspan="3">新手/回歸玩家</td>
                                    <td>GM的祝福(Lv3)聖水 x 10​</td>
                                </tr>
                                <tr>
                                    <td>指令藥水(特大) x 5</td>
                                </tr>
                                <tr>
                                    <td>活力聖水 x 10</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <ol>
                        <li>
                            註：綁定禮需於4/30 23:59前從活動背包完成領取，否則道具將會被刪除。
                        </li>
                        <li>
                        <div style="padding: 0 0 10px;"></div>
                        2.每個新手/回歸玩家可綁定最多3名活躍玩家；每個活躍玩家最多僅能<br>&nbsp;&nbsp;&nbsp;&nbsp;被綁定1次。
                        </li>
                        <li>
                            3.綁定後，獎勵將立即發送至活動背包。活躍玩家的獎勵則會發送至對<br>&nbsp;&nbsp;&nbsp;
                            應綁定碼的伺服器中。玩家須於5/7維護前完成領取，否則獎勵將被<br>&nbsp;&nbsp;&nbsp;&nbsp;刪除。
                        </li>
                        <li>
                            4.綁定過後即無法更改/解除綁定，請特別留意。
                        </li>
                        <li>
                            5.發現活動或領獎機制出現系統或其他異常時，請於第一時間透過「<a style="color: #6493ff;" href="https://digeam.com/cs" target="_blank">線<br>&nbsp;&nbsp;
                            上客服中心</a>」進行回報，若逕行利用該異常取得非屬原活動機制應得<br>&nbsp;&nbsp;
                            之獎勵者，本公司有權回收異常道具並終止其進行遊戲及會員服務資<br>&nbsp;&nbsp;&nbsp;格。
                        </li>
                        <li>
                            6.掘夢網保留變更、取消或終止本活動的權利，包括但不限於本活動條<br>&nbsp;&nbsp;&nbsp;款及活動辦法。
                        </li>
                    </ol>
                </div>`
        );

    });
    //確定綁定彈窗
    $(".pop_wrap").on("click", ".btn", function () {
        $(".popS").fadeIn(200);
        $(".pop_wrapS").html(
            `<div class="pop_contentS">
                <p>綁定後即無法更改/解除。​<br>
                確定要綁定該玩家嗎？​</p>
            </div>
            <div class="popsBtnBox">
                <button class="sub">確定</button>
                <button class="btn" onclick="close_popS()">取消</button>
            </div>`

        );
        //送出綁定碼
        var checklock_bind = true;
        $('.sub').on("click", function () {
            $(".mask").fadeIn();
            $(".loading").html(`載入中......`).fadeIn();
            if (checklock_bind == true) {
                checklock_bind = false;
                let bindingCode = $('.bindBox input[type="text"]').val();
                let selectedServer = $('select[name="select_server"]').val();
                console.log(selectedServer, bindingCode);
                $.post(data_api, {
                    type: "binding",
                    binding_id: bindingCode,
                    server_id: selectedServer,
                }, function (_res) {
                    $(".mask").fadeOut();
                    $(".loading").html(`載入中......`).fadeOut();
                    var res = _res;
                    $(".mask").fadeIn(200);
                    $(".popS").fadeIn(200);
                    if (res.status == 1) {
                        $(".pop_wrapS").html(
                            `<div class="pop_contentS">
                                <p>綁定成功！​​</p>
                            </div>
                            <div class="popsBtnBox">
                                <button class="btn" onclick="close_popS()">確定</button>
                            </div>`
                        );
                    }
                    else if (res.status == -99) {
                        $(".pop_wrapS").html(
                            `<div class="pop_contentS">
                                <p>您已綁定3名活躍玩家，無法再綁定更多玩家。​</p>
                            </div>
                            <div class="popsBtnBox">
                                <button class="btn" onclick="close_popS()">確定</button>
                            </div>`
                        );
                    }
                    else if (res.status == -98) {
                        $(".pop_wrapS").html(
                            `<div class="pop_contentS">
                                <p>該玩家已被其他新手/回歸帳號綁定​</p>
                            </div>
                            <div class="popsBtnBox">
                                <button class="btn" onclick="close_popS()">確定</button>
                            </div>`
                        );
                    }
                    else if (res.status == -97) {
                        $(".pop_wrapS").html(
                            `<div class="pop_contentS">
                                <p>查無此綁定碼。​<br>
                                請再次確認是否輸入正確。​​</p>
                            </div>
                            <div class="popsBtnBox">
                                <button class="btn" onclick="close_popS()">確定</button>
                            </div>`
                        );
                    }
                    else if (res.status == -96) {
                        $(".pop_wrapS").html(
                            `<div class="pop_contentS">
                                <p>未選擇欲領取綁定禮的伺服器​</p>
                            </div>
                            <div class="popsBtnBox">
                                <button class="btn" onclick="close_popS()">確定</button>
                            </div>`
                        );
                    }
                    else if (res.status == -95) {
                        $(".pop_wrapS").html(
                            `<div class="pop_contentS">
                                <p>所選伺服器無效。​<br>
                                請先於所選伺服器中創建角色再進行​​</p>
                            </div>
                            <div class="popsBtnBox">
                                <button class="btn" onclick="close_popS()">確定</button>
                            </div>`
                        );
                    }
                    else if (res.status == -94) {
                        $(".pop_wrapS").html(
                            `<div class="pop_contentS">
                            <p>您是活躍玩家，請將綁定碼分享給新手/回歸玩家。​</p>
                            </div>
                            <div class="popsBtnBox">
                                <button class="btn" onclick="close_popS()">確定</button>
                            </div>`
                        );
                    }
                });
                setTimeout(function () {
                    checklock_bind = true;
                }, 2000);
            }
        })

    });




}

//獎勵領取視窗
function sendGiftPop() {
    $(function () {
        //彈窗內容
        $(".mask").fadeIn(200);
        $(".pop").fadeIn(200);
        // $('.pop_wrap').html();
        $(".pop_wrap").html(
            `<div class="pop_content">
                <div class="pop_title">獎勵領取</div>
                    <div class="section server">
                        <select name="select_server" value= 'server00'>
                            <option value="server00">請選擇伺服器</option>
                            <option value="server01">冰珀星</option>
                            <option value="server02">黑恆星</option>
                        </select>
                    </div>
                    <br>
                    <div class="tableBox">
                        <table>
                            <thead>
                                <tr>
                                    <th>領獎條件​</th>
                                    <th>說明</th>
                                    <th>獎勵領取​</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>簽到(x30)</td>
                                    <td>每日回到活動頁面，即可領取獎勵​​。</td>
                                    <td>
                                        <button class="giftBtn" value="gift01" data-id="gift_0">領取</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>保持在線(x10)</td>
                                    <td>保持在線狀態回到活動頁面，即可領取獎勵。​​</td>
                                    <td>
                                        <button class="giftBtn" value="gift02" data-id="gift_1">領取</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>加入公會(x30)</td>
                                    <td>帳號內至少有一隻角色已加入公會。</td>
                                    <td>
                                        <button class="giftBtn" value="gift03" data-id="gift_2">領取</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>消費(x50)​</td>
                                    <td>消費任意金額。​​</td>
                                    <td>
                                        <button class="giftBtn" value="gift04" data-id="gift_3">領取</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>達到100級(x50)</td>
                                    <td>帳號內有任一角色達到100級以上。​​​</td>
                                    <td>
                                        <button class="giftBtn" value="gift05" data-id="gift_4">領取</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>達到170級(x80)</td>
                                    <td>帳號內有任一角色達到170級以上。​​</td>
                                    <td>
                                        <button class="giftBtn" value="gift06" data-id="gift_5">領取</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>`
        );

        $(".giftBtn").on('click', function () {
            let selectedServer = $('select[name="select_server"]').val();
            if (selectedServer == "server00") {
                $(".mask").fadeIn(200);
                $(".popS").fadeIn(200);
                $(".pop_wrapS").html(
                    `<div class="pop_contentS">
                            <p>請選擇伺服器</p>
                        </div>
                        <div class="popsBtnBox">
                            <button class="btn" onclick="close_popS()">確定</button>
                        </div>`
                );
            } else {
                let giftId = $(this).val();
                updateGift(giftId);
            }
        });
    });
}
function updateGift(giftId) {
    //server00時更新介面，跳出彈窗
    let selectedServer = $('select[name="select_server"]').val();
    // 選擇server01或server02時
    // $.post(data_api, {
    //     type: "send_gift",
    //     server_id: selectedServer,
    // }, function (_res) {
    //     var res = _res;
    //     for ($i = 0; $i < res.length; $i++) {
    //         if (res[$i] == 'y') {
    //             $('.giftBtn').attr('data-id', 'gift_0' + $i)
    //             i.prop('disabled', true)
    //                 .text('已領獎')
    //                 .addClass('giftBtnN');
    //         }
    //         else {
    //             i.prop('disabled', false)
    //                 .text('領取')
    //                 .removeClass('giftBtnN');
    //         }
    //     }
    // })
    //領獎判定
    var checklock_gift = true;
    $(".mask").fadeIn();
    $(".loading").html(`載入中......`).fadeIn();
    if (checklock_gift == true) {
        checklock_gift = false;
        // let giftId = $('.giftBtn').val();
        let selectedServer = $('select[name="select_server"]').val();
        $.post(data_api, {
            type: "gift",
            server_id: selectedServer,
            gift_id: giftId,
        }, function (_res) {
            $(".mask").fadeOut();
            $(".loading").html(`載入中......`).fadeOut();
            var res = _res;
            // let res = { status: resStatus.status[0] };
            $(".mask").fadeIn(200);
            $(".popS").fadeIn(200);
            if (res.status == 1) {
                $(".pop_wrapS").html(
                    `<div class="pop_contentS">
                                    <p>獎勵領取成功，請查看活動背包。</p>
                                </div>
                                <div class="popsBtnBox">
                                    <button class="btn" onclick="close_popS()">確定</button>
                                </div>`
                );
                giftId.prop('disabled', true).text('已領獎').addClass('giftBtnN');

            }
            else if (res.status == -99) {
                $(".pop_wrapS").html(
                    `<div class="pop_contentS">
                                    <p>您不符合領獎資格(非新手/回歸玩家)。​</p>
                                </div>
                                <div class="popsBtnBox">
                                    <button class="btn" onclick="close_popS()">確定</button>
                                </div>`
                );
            }
            else if (res.status == -98) {
                $(".pop_wrapS").html(
                    `<div class="pop_contentS">
                                    <p>您不符合領獎資格(未達成條件)。​​</p>
                                </div>
                                <div class="popsBtnBox">
                                    <button class="btn" onclick="close_popS()">確定</button>
                                </div>`
                );
            }
            else if (res.status == -97) {
                $(".pop_wrapS").html(
                    `<div class="pop_contentS">
                                    <p>請選擇伺服器​​​</p>
                                </div>
                                <div class="popsBtnBox">
                                    <button class="btn" onclick="close_popS()">確定</button>
                                </div>`
                );
            }
            else if (res.status == -96) {
                $(".pop_wrapS").html(
                    `<div class="pop_contentS">
                                    <p>所選伺服器無效。​<br>
                                    請先於所選伺服器中創建角色再進行。​​​</p>
                                </div>
                                <div class="popsBtnBox">
                                    <button class="btn" onclick="close_popS()">確定</button>
                                </div>`
                );
            }
            else if (res.status == -95) {
                $(".pop_wrapS").html(
                    `<div class="pop_contentS">
                                    <p>您已領取過該獎勵。​​​</p>
                                </div>
                                <div class="popsBtnBox">
                                    <button class="btn" onclick="close_popS()">確定</button>
                                </div>`
                );
            }
        });
        setTimeout(function () {
            checklock_gift = true;
        }, 1000);
    }

    // 切換不同伺服器時更新
    // var checklock_update = true;
    // $('select[name="select_server"] ').on('change',function(){
    //     if(checklock_update == true) {
    //         checklock_update = false;
    //         updateGift();
    //         checklock_update = true;
    //     }
    // });

}
//白金之翼領獎
function wingPop() {
    $(function () {
        var checklock_wing = true;
        $(".mask").fadeIn();
        $(".loading").html(`載入中......`).fadeIn();
        if (checklock_wing == true) {
            checklock_wing = false;
            $.post(data_api, {
                type: "wing_gift",
            }, function (_res) {
                $(".mask").fadeOut();
                $(".loading").html(`載入中......`).fadeOut();
                var res = _res;
                // let res = { status: resStatus.status[2] };
                if (res.status == 1) {
                    $(".mask").fadeIn(200);
                    $(".popS").fadeIn(200);
                    $(".pop_wrapS").html(
                        `<div class="pop_contentS">
                            <p>獎勵領取成功，請查看CASH背包。</p>
                        </div>
                        <div class="popsBtnBox">
                            <button class="btn" onclick="close_pop()">確定</button>
                        </div>`
                    );
                } else if (res.status == -99) {
                    $(".mask").fadeIn(200);
                    $(".popS").fadeIn(200);
                    $(".pop_wrapS").html(
                        `<div class="pop_contentS">
                            <p>您不符合領獎資格(非新手/回歸玩家)。</p>
                        </div>
                        <div class="popsBtnBox">
                            <button class="btn" onclick="close_pop()">確定</button>
                        </div>`
                    );
                } else if (res.status == -98) {
                    $(".mask").fadeIn(200);
                    $(".popS").fadeIn(200);
                    $(".pop_wrapS").html(
                        `<div class="pop_contentS">
                            <p>您不符合領獎資格(未達成條件)。</p>
                        </div>
                        <div class="popsBtnBox">
                            <button class="btn" onclick="close_pop()">確定</button>
                        </div>`
                    );
                } else if (res.status == -97) {
                    $(".mask").fadeIn(200);
                    $(".popS").fadeIn(200);
                    $(".pop_wrapS").html(
                        `<div class="pop_contentS">
                            <p>您已領取過該獎勵。</p>
                        </div>
                        <div class="popsBtnBox">
                            <button class="btn" onclick="close_pop()">確定</button>
                        </div>`
                    );
                }
            });
        }

    })

}



