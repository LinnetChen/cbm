var arrayT = [
    sec1_1,
    sec1_2,
    sec1_3,
    sec2_1,
    sec2_2,
    sec2_3,
    sec3_1,
    sec3_2,
    sec3_3,
    sec3_4,
    sec4_1,
];

var arrayC = [
    { contain: "" },
    { contain: "" },
    { contain: "" },
    { contain: "" },
    { contain: "" },
    { contain: "" },
    { contain: "" },
    { contain: "" },
    { contain: "" },
    { contain: "" },
    { contain: "" },
];

// 產跳窗資訊
for ($i = 0; $i < arrayT.length; $i++) {
    $.each(arrayT[$i], function (key, value) {
        var matches = key.match(/([a-zA-Z]+)([0-9]+)/);
        var englishPart = matches[1];

        switch (englishPart) {
            case "text":
                value = '<div class="text">' + value + "</div>";
                break;
            case "img":
                value = '<img src="/img/event/20231030/' + value + '.jpg">';
                break;
            case "title":
                value = '<div class="title">' + value + "</div>";
                break;
            case "table":
                value = '<img src="/img/event/20231030/table/' + value + '.jpg">';
                // value;
                break;
        }
        arrayC[$i].contain += value;
    });
}

tabA(0);
tab_mA(1);

function pop(num) {
    $("html").css("overflow", "hidden");
    if (num == 1) {
        tabA(0);
        tab_mA(1);

        $(".info1").html(arrayC[0].contain);
        $(".info2").html(arrayC[1].contain);
        $(".info3").html(arrayC[2].contain);
        $(".title").show();
        $(".title4").hide();

        $(".tab").show();
        $(".tab4").hide();
        for ($i = 0; $i < 3; $i++) {
            $(".title" + ($i + 1)).html(sec1Title[$i]);
            $(".title" + ($i + 1)).attr("onclick", "tabA(" + $i + ")");
            $(".tab" + ($i + 1)).html(ms1T[$i].num);
            $(".tab" + ($i + 1)).attr("onclick", "tab_mA(" + ($i + 1) + ")");
        }
        $(".tab1").html(ms1T[0].chi);
    } else if (num == 2) {
        tabB(0);
        tab_mB(1);
        $(".info1").html(arrayC[3].contain);
        $(".info2").html(arrayC[4].contain);
        $(".info3").html(arrayC[5].contain);
        $(".title").show();
        $(".title4").hide();

        $(".tab").show();
        $(".tab4").hide();
        for ($i = 0; $i < 3; $i++) {
            $(".title" + ($i + 1)).html(sec2Title[$i]);
            $(".title" + ($i + 1)).attr("onclick", "tabB(" + $i + ")");
            $(".tab" + ($i + 1)).html(ms1T[$i].num);
            $(".tab" + ($i + 1)).attr("onclick", "tab_mB(" + ($i + 1) + ")");
        }
        $(".tab1").html(ms2T[0].chi);
    } else if (num == 3) {
        tabC(0);
        tab_mC(1);

        $(".info1").html(arrayC[6].contain);
        $(".info2").html(arrayC[7].contain);
        $(".info3").html(arrayC[8].contain);
        $(".info4").html(arrayC[9].contain);
        $(".title").show();

        $(".tab").show();
        for ($i = 0; $i < 4; $i++) {
            $(".title" + ($i + 1)).html(sec3Title[$i]);
            $(".title" + ($i + 1)).attr("onclick", "tabC(" + $i + ")");
            $(".tab" + ($i + 1)).html(ms3T[$i].num);
            $(".tab" + ($i + 1)).attr("onclick", "tab_mC(" + ($i + 1) + ")");
        }
        $(".tab1").html(ms3T[0].chi);
    } else if (num == 4) {
        tabD(0);
        tab_mD(1);

        $(".info1").html(arrayC[10].contain);
        $(".title").hide();
        $(".title1").show();
        $(".title1").html(sec4Title[0]);
        $(".title1").attr("onclick", "tabD(1)");
        $(".tab1").attr("onclick", "tab_mD(1)");
        $(".tab1").html(ms4T[0].chi);

        $(".tab").hide();
        $(".tab1").show();
    }
    setTimeout(function(){
        $(".popup").show();
    },40)
}

function closePopup() {
    $(".popup").fadeOut();
    $("html").css("overflow-y", "scroll");
}

//
function tabA(i) {
    // $(".tab.active").css("background-color", "#762b1f");

    $(".title").removeClass("active activeA activeB activeC activeD ");
    $(".title" + (i + 1)).addClass("activeA");
    $(".info").hide();
    $(".info" + (i + 1)).fadeIn();
}
function tabB(i) {
    // $(".tab.active").css("background-color", "#31ae57");

    $(".title").removeClass("active activeA activeB activeC activeD ");
    $(".title" + (i + 1)).addClass("activeB");
    $(".info").hide();
    $(".info" + (i + 1)).fadeIn();
}
function tabC(i) {
    // $(".tab.active").css("background-color", "#18aec7");

    $(".title").removeClass("activeA activeB activeC activeD");
    $(".title" + (i + 1)).addClass("activeC");
    $(".info").hide();
    $(".info" + (i + 1)).fadeIn();
}
function tabD(i) {
    // $(".tab.active").css("background-color", "#756086");

    $(".title").removeClass("activeA activeB activeC activeD");
    $(".title" + (i + 1)).addClass("activeD");
    $(".info").hide();
    $(".info" + (i + 1)).fadeIn();
}

function tab_mA(i) {
    $(".tab").removeClass("active activeB activeC activeD ");
    for ($i = 1; $i < 4; $i++) {
        $(".tab" + $i).html(ms1T[$i - 1].num);
    }
    $(".tab" + i).html(ms1T[i - 1].chi);
    $(".tab" + i).addClass("active");
    $(".info").hide();
    $(".info" + i).fadeIn();
}
function tab_mB(i) {
    $(".tab").removeClass("active activeB activeC activeD ");
    for ($i = 1; $i < 4; $i++) {
        $(".tab" + $i).html(ms2T[$i - 1].num);
    }
    $(".tab" + i).html(ms2T[i - 1].chi);
    $(".tab" + i).addClass("active activeB");
    $(".info").hide();
    $(".info" + i).fadeIn();
}
function tab_mC(i) {
    $(".tab").removeClass("active activeB activeC activeD ");
    for ($i = 1; $i < 5; $i++) {
        $(".tab" + $i).html(ms3T[$i - 1].num);
    }
    $(".tab" + i).html(ms3T[i - 1].chi);
    $(".tab" + i).addClass("active activeC");
    $(".info").hide();
    $(".info" + i).fadeIn();
}
function tab_mD(i) {
    $(".tab").css("background-color", "");
    $(".tab").removeClass("active activeB activeC activeD ");
    $(".tab1").html(ms4T[0].chi);
    $(".tab1").addClass("active activeD");
    $(".info").hide();
    $(".info" + i).fadeIn();
}

// 電腦版btn hover
$("#main .inner .columns .image").mouseover(function () {
    const classes = $(this).attr("class").split(" ");
    $(this)
        .find("img")
        .attr("src", "/img/event/20231030/" + classes[2] + "_h.png");
});
$("#main .inner .columns .image").mouseout(function () {
    const classes = $(this).attr("class").split(" ");
    $(this)
        .find("img")
        .attr("src", "/img/event/20231030/" + classes[2] + ".png");
});
