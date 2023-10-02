@extends('layouts.app')
@section('title', '《黑色契約CABAL Online》')
@section('link')
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="/css/home_page/home_page_style.css?v1.4">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection
@section('content1')
    <div id="particles-js"></div>
    <div class="main_box">
        <div class="main_btn">
            <a>
                <div class="download"></div>
            </a>
            <a href="https://www.digeam.com/register_cbo">
                <div class="btn"><img src="img/home_page/icon_rgister.png">帳號註冊</div>
            </a>
            <a href="https://www.digeam.com/member/billing">
                <div class="btn"><img src="img/home_page/icon_add.png">儲值中心</div>
            </a>
            <div class="btn_two">
                <a href="https://www.digeam.com/member/enable">
                    <div class="btn_small"><img src="img/home_page/icon_otp.png">OTP申請</div>
                </a>
                <a href="https://www.digeam.com/cs">
                    <div class="btn_small"><img src="img/home_page/icon_customer.png">聯繫客服</div>
                </a>
            </div>
        </div>
        <div class="banner">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach ($img as $value)
                        <div class="swiper-slide"><a href={{ $value['url'] }}><img src="{{ $value['file_name'] }}"></a>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination swiper-pagination-custom"></div>
            </div>
        </div>
        <div class="info">
            <div class="info_topbox">
                <div class="info_tab">
                    <button class="active tab_button" data-target="#info_all">綜合</button>
                    <button class="tab_button" data-target="#info_event">活動</button>
                    <button class="tab_button" data-target="#info_system">系統</button>
                </div>
                <a href="{{ route('info') }}">More</a>
            </div>
            <div class="info_container">
                <div class="info_box active" id="info_all">
                    @foreach ($na as $value)
                        @if ($value['top'] == 'y')
                            <ul class="textUITOP">
                            @elseif($value['new'] == 'y')
                                <ul class="textUINEW">
                                @else
                                    <ul class="textUInormal">
                        @endif
                        <li><a class="textbox" href="{{ route('info_content', $value['id']) }}">
                                @if ($value['cate_id'] == 1)
                                    <div class="info_title">【活動】{{ $value['title'] }}</div>
                                @else
                                    <div class="info_title">【系統】{{ $value['title'] }}</div>
                                @endif
                                <div class="info_date">{{ date('Y/m/d', strtotime($value['created_at'])) }}</div>
                            </a></li>
                        </ul>
                    @endforeach
                </div>

                <div class="info_box" id="info_event">
                    @foreach ($nb as $value)
                        @if ($value['top'] == 'y')
                            <ul class="textUITOP">
                            @elseif($value['new'] == 'y')
                                <ul class="textUINEW">
                                @else
                                    <ul class="textUInormal">
                        @endif
                        <li><a class="textbox" href="{{ route('info_content', $value['id']) }}">
                                <div class="info_title">【活動】{{ $value['title'] }}</div>
                                <div class="info_date">{{ date('Y/m/d', strtotime($value['created_at'])) }}</div>
                            </a></li>
                        </ul>
                    @endforeach
                </div>

                <div class="info_box" id="info_system">
                    @foreach ($nc as $value)
                        @if ($value['top'] == 'y')
                            <ul class="textUITOP">
                            @elseif($value['new'] == 'y')
                                <ul class="textUINEW">
                                @else
                                    <ul class="textUInormal">
                        @endif
                        <li><a class="textbox" href="{{ route('info_content', $value['id']) }}">
                                <div class="info_title">【系統】{{ $value['title'] }}</div>
                                <div class="info_date">{{ date('Y/m/d', strtotime($value['created_at'])) }}</div>
                            </a></li>
                        </ul>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content2')

    <div class="section2">
        <div class="job_title" data-aos="fade-up"></div>
        <div class="job_mainbox  active" id="job_box0">
            <div class="job_box">
                <div class="job_left">
                    <div class="magic1 animate__animated animate__zoomIn animate__fast 800ms" data-aos="zoom-in-up">
                    </div>
                    <div class="character1 animate__animated animate__pulse" data-aos="zoom-in-right"></div>
                </div>
                <div class="job_right">
                    <div class="job_namebox animate__animated animate__fadeInDown">
                        <div class="job_icon1" data-aos="zoom-out"></div>
                        <div class="job_name1" data-aos="fade-up"></div>
                    </div>
                    <div class="job_text animate__animated animate__fadeInDown" data-aos="fade-up">
                        狂劍士先天就具備強壯的體格，崇尚強大的力量而不是技巧與速度，鍛鍊目標是為了徹底掌控身體，因此不需要培養魔力的理解能力，每次攻擊都帶來極強的破壞力，讓敵人不得不退避三舍。</div>
                    <div class="job_info animate__animated animate__fadeInDown">
                        <div class="job_star1" data-aos="fade-up"></div>
                        <div class="job_triangle1" data-aos="flip-left"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="job_mainbox" id="job_box1">
            <div class="job_box">
                <div class="job_left">
                    <div class="magic2 animate__animated animate__zoomIn animate__fast 800ms" data-aos="zoom-in-up">
                    </div>
                    <div class="character2 animate__animated animate__pulse" data-aos="zoom-in-right"></div>
                </div>
                <div class="job_right">
                    <div class="job_namebox animate__animated animate__fadeInDown">
                        <div class="job_icon2" data-aos="zoom-out"></div>
                        <div class="job_name2" data-aos="fade-up"></div>
                    </div>
                    <div class="job_text animate__animated animate__fadeInDown" data-aos="fade-up">
                        雙劍士追求精湛的技巧與敏捷的速度，有著超乎常人的反應能力，利用極高的敏捷特性在戰場上迅速穿梭，極快的速度讓他們能夠產生分身幻象擾亂敵人視線，讓敵人難以抓住他的身影，創造絕佳的攻擊機會。</div>
                    <div class="job_info animate__animated animate__fadeInDown">
                        <div class="job_star2" data-aos="fade-up"></div>
                        <div class="job_triangle2" data-aos="flip-left"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="job_mainbox" id="job_box2">
            <div class="job_box">
                <div class="job_left">
                    <div class="magic3 animate__animated animate__zoomIn animate__fast 800ms" data-aos="zoom-in-up">
                    </div>
                    <div class="character3 animate__animated animate__pulse" data-aos="zoom-in-right"></div>
                </div>
                <div class="job_right">
                    <div class="job_namebox animate__animated animate__fadeInDown">
                        <div class="job_icon3" data-aos="zoom-out"></div>
                        <div class="job_name3" data-aos="fade-up"></div>
                    </div>
                    <div class="job_text animate__animated animate__fadeInDown" data-aos="fade-up">
                        盾劍士渴望極強的防禦能力，不滿足於穿戴防禦力較高的重型盔甲，他們嘗試將魔力運用在防禦上，讓武器轉變為星之盾，開創出新的魔力運用方式。成為擁有絕對防禦能力的戰士。</div>
                    <div class="job_info animate__animated animate__fadeInDown">
                        <div class="job_star3" data-aos="fade-up"></div>
                        <div class="job_triangle3" data-aos="flip-left"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="job_mainbox" id="job_box3">
            <div class="job_box">
                <div class="job_left">
                    <div class="magic4 animate__animated animate__zoomIn animate__fast 800ms" data-aos="zoom-in-up">
                    </div>
                    <div class="character4 animate__animated animate__pulse" data-aos="zoom-in-right"></div>
                </div>
                <div class="job_right">
                    <div class="job_namebox animate__animated animate__fadeInDown">
                        <div class="job_icon4" data-aos="zoom-out"></div>
                        <div class="job_name4" data-aos="fade-up"></div>
                    </div>
                    <div class="job_text animate__animated animate__fadeInDown" data-aos="fade-up">
                        魔劍士在一次次研究中，成功將魔法與劍術結合，發展出高超的戰鬥方式，每次攻擊帶來強大的破壞力，但由於需要同時使用兩種戰鬥方式的力量，因此在培養訓練上需要花費較多心力。</div>
                    <div class="job_info animate__animated animate__fadeInDown">
                        <div class="job_star4" data-aos="fade-up"></div>
                        <div class="job_triangle4" data-aos="flip-left"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="job_mainbox" id="job_box4">
            <div class="job_box">
                <div class="job_left">
                    <div class="magic5 animate__animated animate__zoomIn animate__fast 800ms" data-aos="zoom-in-up">
                    </div>
                    <div class="character5 animate__animated animate__pulse" data-aos="zoom-in-right"></div>
                </div>
                <div class="job_right">
                    <div class="job_namebox animate__animated animate__fadeInDown">
                        <div class="job_icon5" data-aos="zoom-out"></div>
                        <div class="job_name5" data-aos="fade-up"></div>
                    </div>
                    <div class="job_text animate__animated animate__fadeInDown" data-aos="fade-up">
                        角鬥士有著與生俱來的戰鬥本能，透過控制對敵人產生的憤怒情緒，來激發自身的戰鬥能力。為了能夠最大程度的運用飛輪施展技能，同時負擔盔甲重量，他們需要不斷的磨練自身的力量和靈活性來達成目的。</div>
                    <div class="job_info animate__animated animate__fadeInDown">
                        <div class="job_star5" data-aos="fade-up"></div>
                        <div class="job_triangle5" data-aos="flip-left"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="job_mainbox" id="job_box5">
            <div class="job_box">
                <div class="job_left">
                    <div class="magic6 animate__animated animate__zoomIn animate__fast 800ms" data-aos="zoom-in-up">
                    </div>
                    <div class="character6 animate__animated animate__pulse" data-aos="zoom-in-right"></div>
                </div>
                <div class="job_right">
                    <div class="job_namebox animate__animated animate__fadeInDown">
                        <div class="job_icon6" data-aos="zoom-out"></div>
                        <div class="job_name6" data-aos="fade-up"></div>
                    </div>
                    <div class="job_text animate__animated animate__fadeInDown" data-aos="fade-up">
                        魔導師是掌握著魔法、爆發力和超級強大破壞力的絕對強者。他們可以隨心所欲地操控體內魔力與自然之力共鳴，甚至於同時施展多種魔法，將其化為毀滅性的魔法攻擊，破壞力足以令敵人望而生畏。</div>
                    <div class="job_info animate__animated animate__fadeInDown">
                        <div class="job_star6" data-aos="fade-up"></div>
                        <div class="job_triangle6" data-aos="flip-left"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="job_mainbox" id="job_box6">
            <div class="job_box">
                <div class="job_left">
                    <div class="magic7 animate__animated animate__zoomIn animate__fast 800ms" data-aos="zoom-in-up">
                    </div>
                    <div class="character7 animate__animated animate__pulse" data-aos="zoom-in-right"></div>
                </div>
                <div class="job_right">
                    <div class="job_namebox animate__animated animate__fadeInDown">
                        <div class="job_icon7" data-aos="zoom-out"></div>
                        <div class="job_name7" data-aos="fade-up"></div>
                    </div>
                    <div class="job_text animate__animated animate__fadeInDown" data-aos="fade-up">
                        弓箭手起源於魔導師，將魔力轉化為箭矢造成巨大的破壞力，而靈活性是他們最大的優勢之一，在戰場上輕鬆改變位置和躲避敵人的攻擊，憑藉著靈活的身手和卓越的射擊技巧，強大的遠程支援成為戰場上勝利的關鍵。
                    </div>
                    <div class="job_info animate__animated animate__fadeInDown">
                        <div class="job_star7" data-aos="fade-up"></div>
                        <div class="job_triangle7" data-aos="flip-left"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="job_mainbox" id="job_box7">
            <div class="job_box">
                <div class="job_left">
                    <div class="magic8 animate__animated animate__zoomIn animate__fast 800ms" data-aos="zoom-in-up">
                    </div>
                    <div class="character8 animate__animated animate__pulse" data-aos="zoom-in-right"></div>
                </div>
                <div class="job_right">
                    <div class="job_namebox animate__animated animate__fadeInDown">
                        <div class="job_icon8" data-aos="zoom-out"></div>
                        <div class="job_name8" data-aos="fade-up"></div>
                    </div>
                    <div class="job_text animate__animated animate__fadeInDown" data-aos="fade-up">
                        銃槍手繼承了賢者之塔秘密部隊的戰鬥模式，將武器轉變為槍械的多種型態，訓練著重於提高準確度和快速反應能力，使得他們能夠在高壓環境下保持冷靜，以精準的射擊給予敵人致命的打擊，成為了遠距離射擊專家。
                    </div>
                    <div class="job_info animate__animated animate__fadeInDown">
                        <div class="job_star8" data-aos="fade-up"></div>
                        <div class="job_triangle8" data-aos="flip-left"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="job_mainbox" id="job_box8">
            <div class="job_box">
                <div class="job_left">
                    <div class="magic9 animate__animated animate__zoomIn animate__fast 800ms" data-aos="zoom-in-up">
                    </div>
                    <div class="character9 animate__animated animate__pulse" data-aos="zoom-in-right"></div>
                </div>
                <div class="job_right">
                    <div class="job_namebox animate__animated animate__fadeInDown">
                        <div class="job_icon9" data-aos="zoom-out"></div>
                        <div class="job_name9" data-aos="fade-up"></div>
                    </div>
                    <div class="job_text animate__animated animate__fadeInDown" data-aos="fade-up">
                        咒術師行為舉止透露出神秘和邪惡的氛圍，他們通過將魔力與靈魂結合，形成強大的禁忌力量來提升自己的魔力，擅長施展恐怖且極具摧毀力的黑暗魔法，對敵人造成極大的破壞和混亂，成為戰場上讓敵人心生畏懼的存在。
                    </div>
                    <div class="job_info animate__animated animate__fadeInDown">
                        <div class="job_star9" data-aos="fade-up"></div>
                        <div class="job_triangle9" data-aos="flip-left"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="job_tab">
            <div class="btnL" onclick="nextClick(-1)"></div>
            <button class="active job_button0 job_button" data-target="#job_box0" onclick="textClick(0)">狂劍士</button>
            <button class="job_button job_button1" data-target="#job_box1" onclick="textClick(1)">雙劍士</button>
            <button class="job_button job_button2" data-target="#job_box2" onclick="textClick(2)">盾劍士</button>
            <button class="job_button job_button3" data-target="#job_box3" onclick="textClick(3)">魔劍士</button>
            <button class="job_button job_button4" data-target="#job_box4" onclick="textClick(4)">角鬥士</button>
            <button class="job_button job_button5" data-target="#job_box5" onclick="textClick(5)">魔導師</button>
            <button class="job_button job_button6" data-target="#job_box6" onclick="textClick(6)">弓箭手</button>
            <button class="job_button job_button7" data-target="#job_box7" onclick="textClick(7)">銃槍手</button>
            <button class="job_button job_button8" data-target="#job_box8" onclick="textClick(8)">咒術師</button>
            <div class="btnR" onclick="nextClick(1)"></div>
        </div>
    </div>
    <div class="section3">
        <div class="title"></div>
        <div class="swiper_fater">
            <!-- 幻燈片內容 -->
            <div class="swiper-container-game">
                <!-- 外層(必要) -->
                <div class="swiper-wrapper">
                    <!-- 幻燈片內容 -->
                    <div class="swiper-slide">
                        <div class="swiper-slide-box">
                            <img src="../../img/home_page/section3/feature01.png">
                            <div class="feature_text">
                                <img src="../../img/home_page/section3/featureTX01.png">
                                <div class="featureTX">磁心的力量孕育出人類文明的巔峰，卻也帶來足以毀滅一切的災難。​在末世後的荒土中駕駛星際飛車，揭開上世代文明的科技結晶。</div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="swiper-slide-box">
                            <img src="../../img/home_page/section3/feature02.png">
                            <div class="feature_text">
                                <img src="../../img/home_page/section3/featureTX02.png">
                                <div class="featureTX">爆發最強戰鬥模式，體驗街機般的特效與操作​。讓你輕鬆駕馭各種戰局，ABAB打出資深大佬才懂得秘密招式！</div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="swiper-slide-box">
                            <img src="../../img/home_page/section3/feature03.png">
                            <div class="feature_text">
                                <img src="../../img/home_page/section3/featureTX03.png">
                                <div class="featureTX">豐富的副本支線融合解謎挑戰，在打寶之餘一步步探究預言的真相。​在這裡，刷圖將不再是無腦向前，裝備也不再是唯一真理。</div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="swiper-slide-box">
                            <img src="../../img/home_page/section3/feature04.png">
                            <div class="feature_text">
                                <img src="../../img/home_page/section3/featureTX04.png">
                                <div class="featureTX">兩大賢者的分裂，為涅瓦雷斯大陸的未來投下更多變數。​選擇你的陣營，在名為榮耀的戰場上為信念而戰。</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-button-prev">
            </div>
            <div class="swiper-button-next">
            </div>
            <!--分頁器-->
            <div class="game-swiper-pagination game-swiper-pagination-custom"></div>
        </div>
    </div>
@endsection


@section('js')
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        AOS.init();
        //粒子特效
        particlesJS.load('particles-js', '/js/home_page/particlesjs-config.json', function() {
            console.log('callback - particles.js config loaded');
        });

        //公告切換
        $('.tab_button').click(function() {
            var target = $(this).data('target');
            $(target).show().siblings('.info_box').hide();
            $(this).addClass('active').siblings('.active').removeClass('active');
        });

        //公告輪播
        var mySwiper = new Swiper(".swiper-container", {
            direction: "horizontal", // 方向
            loop: true, // 循環
            autoplay: true, // 自動播放
            pagination: {
                el: ".swiper-pagination", // 分頁物件
                type: 'bullets',
                clickable: true,
            },
        });

        //特色輪播
        var mySwiper = new Swiper(".swiper-container-game", {
            direction: "horizontal", // 方向
            loop: true, // 循環
            autoplay: false, // 自動播放
            effect: 'creative',
            speed: 600,
            slidesPerView: 1,
            grabCursor: true,
            creativeEffect: {
                prev: {
                    shadow: false,
                    translate: ["100%", 0, -1],
                },
                next: {
                    translate: ["100%", 0, 0],
                    shadow: false,
                }
            },
            pagination: {
                el: ".game-swiper-pagination", // 分頁物件
                type: 'bullets',
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next", // 上一頁按鈕物件
                prevEl: ".swiper-button-prev", // 下一頁按鈕物件
            }
        });

        //職業切換
        $('.job_button').click(function() {
            var target = $(this).data('target');
            $('.job_mainbox').hide(); // 隱藏所有 .job_mainbox
            $(target).show(); // 顯示目標 .job_mainbox
            $(this).addClass('active').siblings('.active').removeClass('active');
            AOS.init();
        });

        var slideIndex = 0;

        function nextClick(i) {
            showSlides((slideIndex += i));
            textClick(slideIndex); //把值傳給textClick
        }

        function textClick(i) {
            showSlides(i);
            //選單
            var _btnA = ".job_button" + i;
            $(".job_button").removeClass("active");
            $(_btnA).addClass("active");
            //職業
            var _target = "#job_box" + i;
            $('.job_mainbox').hide();
            $(_target).show();
            $(_target).addClass('active').siblings('.active').removeClass('active');
            AOS.init();
        }


        function showSlides(i) {
            if (i > 8) {
                slideIndex = 0;
                //總共有9個TAB
            } else if (i < 0) {
                slideIndex = 8;
            } else {
                slideIndex = i;
            }
        }

        $('.download').on('click', function() {
            location.href = '/game'
        })
    </script>
@endsection
