<html lang="zh-TW">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>黑色契約 CABAL online</title>
    <link rel="stylesheet" href="/css/launcher/style.css">
</head>

<body onLoad="show()">
    <div class="cabal"></div>
    <div class="digeam"></div>
    <div class="est"></div>

    <div class="launch">
        <ul class="links">
            <li><a href="https://cbo.digeam.com" target="_blank">官方網站</a></li>
            <li><a href="https://www.facebook.com/DiGeamCabal" target="_blank">粉絲專頁</a></li>
            <li><a href="https://digeam.com/register" target="_blank">加入會員</a></li>
            <li><a href="https://www.digeam.com/cs" target="_blank">客服中心</a></li>
        </ul>
        <ul class="notice">
            <li>
                <div id="changeimg">
                    <img id="myImg" onclick="openNewWindow(i)">
                    <a href="#changeimg" class="c1" onclick="showImg(0)"></a>
                    <a href="#changeimg" class="c2" onclick="showImg(1)"></a>
                    <a href="#changeimg" class="c3" onclick="showImg(2)"></a>
                </div>
            </li>
            <li>
                <div id="tabs">
                    <div class="menubox">
                        <ul class="codeDemoUL" id="ulMenu_indexnew">
                            <li class="codeDemomouseOutMenu"
                                onmouseover="showDiv('indexnew',1,3);this.className='codeDemomouseOnMenu'">綜合</li>
                            <li class="codeDemomouseOnMenu"
                                onmouseover="showDiv('indexnew',2,3);this.className='codeDemomouseOnMenu'">活動</li>
                            <li class="codeDemomouseOutMenu"
                                onmouseover="showDiv('indexnew',3,3);this.className='codeDemomouseOnMenu'">系統</li>
                        </ul>
                        <div id="newlist">
                            <div class="codeDemoDiv" id="divCodeindexnew_1" style="display: none;">
                                <div class="newslist2">
                                    <ul>
                                        @foreach ($na as $value)
                                            @if ($value['cate_id'] == 1)
                                                <li><a target="_blank" href="{{ route('info_content', $value['id']) }}">
                                                        <label>[活動]</label>{{ $value['title'] }}</a><span>{{ date('Y/m/d', strtotime($value['created_at'])) }}</span>
                                                </li>
                                            @else
                                                <li><a target="_blank" href="{{ route('info_content', $value['id']) }}">
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
                                            <li><a target="_blank" href="{{ route('info_content', $value['id']) }}">
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
    <script src="/js/launcher/carousel.js"></script>
    <script src="/js/launcher/launcher.js"></script>
</body>

</html>
