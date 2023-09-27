<html lang="zh-TW">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>黑色契約 CABAL online</title>
    <link rel="stylesheet" href="/css/launcher/style.css?v1.0" />
</head>

<body onLoad="show()">
    <div class="cabal"></div>
    <div class="digeam"></div>
    <div class="est"></div>

    <div class="launch">
        <ul class="links">
            <li><a href="https://cbo.digeam.com" target="_blank">官方網站</a></li>
            <li>
                <a href="https://www.facebook.com/DiGeamCabal" target="_blank">粉絲專頁</a>
            </li>
            <li>
                <a href="https://digeam.com/register" target="_blank">加入會員</a>
            </li>
            <li>
                <a href="https://www.digeam.com/cs" target="_blank">客服中心</a>
            </li>
        </ul>
        <div class="notice-container">
            <div class="container"id="DPic"style="overflow: hidden; position: relative">
                <ul class="slider slider2" id="UPic" data-val="3"
                    style="position: absolute; left: 0px; top: 0px">
                    @foreach ($img as $value)
                        <li>
                            <a href={{ $value['url'] }} target="_blank">
                                <img src="{{ $value['file_name'] }}" />
                            </a>
                        </li>
                    @endforeach
                </ul>
                <ul class="num" id="UNum">
                    @for ($i = 1; $i <= count($img); $i++)
                        <li class="">
                            <a>{{ $i }}</a>
                        </li>
                    @endfor
                </ul>
            </div>


            <ul class="notice">
                <li>
                    <div id="tabs">
                        <div class="menubox">
                            <ul class="codeDemoUL" id="ulMenu_indexnew">
                                <li class="codeDemomouseOutMenu"
                                    onmouseover="showDiv('indexnew',1,3);this.className='codeDemomouseOnMenu'">
                                    綜合
                                </li>
                                <li class="codeDemomouseOnMenu"
                                    onmouseover="showDiv('indexnew',2,3);this.className='codeDemomouseOnMenu'">
                                    活動
                                </li>
                                <li class="codeDemomouseOutMenu"
                                    onmouseover="showDiv('indexnew',3,3);this.className='codeDemomouseOnMenu'">
                                    系統
                                </li>
                            </ul>
                            <div id="newlist">
                                <div class="codeDemoDiv" id="divCodeindexnew_1" style="display: none;">
                                    <div class="newslist2">
                                        <ul>
                                            @foreach ($na as $value)
                                                @if ($value['cate_id'] == 1)
                                                    <li><a target="_blank"
                                                            href="{{ route('info_content', $value['id']) }}">
                                                            <label>[活動]</label>{{ $value['title'] }}</a><span>{{ date('Y/m/d', strtotime($value['created_at'])) }}</span>
                                                    </li>
                                                @else
                                                    <li><a target="_blank"
                                                            href="{{ route('info_content', $value['id']) }}">
                                                            <label>[系統]</label>{{ $value['title'] }}</a><span>{{ date('Y/m/d', strtotime($value['created_at'])) }}</span>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="codeDemoDiv" id="divCodeindexnew_2" style="display: block;">
                                    <div class="newslist2">
                                        <ul>
                                            @foreach ($nb as $value)
                                                <li><a target="_blank" href="{{ route('info_content', $value['id']) }}">
                                                        <label>[活動]</label>{{ $value['title'] }}</a><span>{{ date('Y/m/d', strtotime($value['created_at'])) }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="codeDemoDiv" id="divCodeindexnew_3" style="display: none;">
                                    <div class="newslist2">
                                        <ul>
                                            @foreach ($nc as $value)
                                                <li><a target="_blank"
                                                        href="{{ route('info_content', $value['id']) }}">
                                                        <label>[系統]</label>{{ $value['title'] }}</a><span>{{ date('Y/m/d', strtotime($value['created_at'])) }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <!-- <script src="js/carousel.js"></script> -->
    <script src="js/launcher/launcher.js"></script>
    <script src="js/launcher/YLMarquee-1.1.js"></script>
    <script src="js/launcher/jquery-1.7.2.js"></script>
    <script src="js/launcher/js.js"></script>
    <script>
        countIMG = $("#UPic").data("val");

        function showDiv(C, B, D) {
            for (var A = 1; A <= D; A++) {
                document.getElementById(
                    "divCode" + C + "_" + String(A)
                ).style.display = "none";
            }
            document.getElementById("divCode" + C + "_" + B).style.display =
                "block";
            for (var A in document
                    .getElementById("ulMenu_" + C)
                    .getElementsByTagName("LI")) {
                document.getElementById("ulMenu_" + C).getElementsByTagName("LI")[
                    A
                ].className = "codeDemomouseOutMenu";
            }
        }
        $(document).ready(function() {
            LoadPicRun("DPic", "UPic", "UNum", 265, countIMG);
            $("#img-list4").YlMarquee({
                step: 39,
                visible: 1,
                vertical: 7,
                NextControlID: "imgNext4",
                PreControlID: "imgPre4",
            });
        });
    </script>
</body>

</html>
