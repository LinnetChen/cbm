
$(function () {
    // nav bar--tab控制
    var _showTab = 0;
    $('ul.nav_bar_box li').eq(_showTab).addClass('active');
    $('.tab_content').hide().eq(_showTab).show();
    $('ul.nav_bar_box li').click(function () {
        var $this = $(this),
            _clickTab = $this.find('a').attr('href');
        $this.addClass('active').siblings('.active').removeClass('active');
        $(_clickTab).stop(false, true).fadeIn().siblings().hide();
        return false;
    }).find('a').focus(function () {
        this.blur();
    });

    // btn top
    $('.btntop').click(
        function () {
            $('body,html').animate({ scrollTop: '0px' }, 800)
        }
    );
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.btntop').fadeIn("fadeIn"), 800;
        } else {
            $('.btntop').fadeOut("fadeOut"), 800;
        }
    });
    // item1--menu
    $(function () {
        $('.item1_box').hide();
        $('.item1').click(function () {
            $('.item1_box').slideToggle(500);
            $('.bg-cl')
        });
    });
    $('.item1').click(
        function () {
            $('body,html').animate({ scrollTop: $("#tab1").offset().top }, 800);
            $('.item1_box').slideUp(500);
            $('.bg_color').fadeIn(500);
        }
    );
    $('.item2').click(
        function () {
            $('body,html').animate({ scrollTop: $("#tab2").offset().top }, 800);
            $('.item1_box').slideUp(500);
            $('.bg_color').fadeIn(500);
        }
    );
    $('.item3').click(
        function () {
            $('body,html').animate({ scrollTop: $("#tab3").offset().top }, 800);
            $('.item1_box').slideUp(500);
            $('.bg_color').fadeIn(500);
        }
    );
    $('.item4').click(
        function () {
            $('body,html').animate({ scrollTop: $("#tab4").offset().top }, 800);
            $('.item1_box').slideUp(500);
            $('.bg_color').fadeIn(500);
        }
    );
    $('.item5').click(
        function () {
            $('body,html').animate({ scrollTop: $("#tab5").offset().top }, 800);
            $('.item1_box').slideUp(500);
            $('.bg_color').fadeIn(500);
        }
    );
    $('.item6').click(
        function () {
            $('body,html').animate({ scrollTop: $("#tab6").offset().top }, 800);
            $('.item1_box').slideUp(500);
            $('.bg_color').fadeIn(500);
        }
    );
    $('.item7').click(
        function () {
            $('body,html').animate({ scrollTop: $("#tab7").offset().top }, 800);
            $('.item1_box').slideUp(500);
            $('.bg_color').fadeIn(500);
        }
    );

});

// nav_bar收合
$('#XX, .topmenu').click(function () {
    $('.nav_bar').toggleClass('open');
});
$(window).on("load resize", function () {
    if ($(window).width() < 1025) {
        $('.nav_bar').removeClass('open');
        $('.nav_bar_box a').click(function () {
            $('.nav_bar').removeClass('open');
        });
        $('.item1').click(function () {
            $('.nav_bar').addClass('open');
        });
    } else {
        $('.nav_bar').addClass('open');
        $('.nav_bar_box a').click(function () {
            $('.nav_bar').addClass('open');
        });
    }
});

// lightbox //
$(".popclose, .mask").click(function () {
    $('.popup').fadeOut(500);
    $("html").css("overflow", "scroll");
});
$(".pop_btn").click(function () {
    $("div[id=" + $(this).attr("data-pop") + "]").fadeIn(500);
    $("html").css("overflow", "hidden");
});

// 尚未開放系統窗--開啟後，網頁新開視窗
function he() {
    alert('敬請期待!!');
};