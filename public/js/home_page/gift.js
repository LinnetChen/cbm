// 登出
$(".logout").on("click", function () {
    $("#logout-form").submit();
});

// 登入
$("#login").on("click", function () {
    location.href = "https://digeam.com/login";
});

$(".search").on("click", function () {
    location.href =
        "/giftSearch/" +
        $(".year").val() +
        "/" +
        $(".month").val() +
        "/" +
        $(".keyword").val();
});

// 送獎
_send = true;
$(".btn_s").on("click", function () {
    let selectedServerId = $("select[name='select_server']").val();
    if(selectedServerId == "serverNone"){
        Swal.fire({
            icon: "error",
            title: "兌換失敗",
            text: "請選擇伺服器！",
        });
        return;
    }

    if (_send == true) {
        _send = false;
        $.post(
            "/api/gift",
            {
                server_id: selectedServerId,
                gift_id: $(this).data("val"),
            },
            function (res) {
                setTimeout(() => {
                    _send = true;
                }, 1000);
                if (res.status == -99) {
                    Swal.fire({
                        icon: "error",
                        title: "兌換失敗",
                        text: "您已經領取過了！",
                    });
                } else if (res.status == -98) {
                    Swal.fire({
                        icon: "error",
                        title: "兌換失敗",
                        text: "請在領獎時間內領取！",
                    });
                } else if (res.status == -97) {
                    Swal.fire({
                        icon: "error",
                        title: "兌換失敗",
                        text: "請先在遊戲內建立角色才可以領取喔！",
                    });
                } else if (res.status == -90) {
                    Swal.fire({
                        icon: "error",
                        title: "兌換失敗",
                        text: "您不符合領取資格！",
                    });
                } else if (res.status == 1) {
                    Swal.fire("兌換成功！獎勵將於5分鐘內發送至遊戲中").then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                }
            }
        );
    }
});
