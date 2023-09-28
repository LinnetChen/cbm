@extends('layouts.app2')
@section('title', '《黑色契約CABAL Online》遊戲主程式')
@section('link')
    <link rel="stylesheet" href="/css/home_page/game_style.css?v1.0">
@endsection
@section('main_btn')
    <div class="main_btn">
        <a href="https://rco.digeam.com/">
            <div class="download"></div>
        </a>
        <a href="https://rco.digeam.com/">
            <div class="btn"><img src="img/home_page/icon_rgister.png">帳號註冊</div>
        </a>
        <a href="https://rco.digeam.com/">
            <div class="btn"><img src="img/home_page/icon_add.png">儲值中心</div>
        </a>
        <div class="btn_two">
            <a href="https://rco.digeam.com/">
                <div class="btn_small"><img src="img/home_page/icon_otp.png">OTP申請</div>
            </a>
            <a href="https://rco.digeam.com/">
                <div class="btn_small"><img src="img/home_page/icon_customer.png">聯繫客服</div>
            </a>
        </div>
    </div>
@endsection
@section('main_title', '遊戲主程式')
@section('content')
    <div class="content_box">
        <div class="btn_box">
            <a href="https://download.digeam.com/download/s1/cbo/CabalOnlineSetup.exe"><button
                    class="btn_download">下載器</button></a>
            <a href="https://download.digeam.com/download/s1/cbo/rar/CABALOnline.rar"><button
                    class="btn_download">免安裝檔</button></a>
        </div>
        <div class="title">推薦配置</div>
        <div class="title_line"></div>
        <div class="text_box">
            <p>1.點擊上方連結，選擇任何一個載點下載即可。</p>
            <p>2.安裝前，請確認硬碟內的空間有大於8GB。</p>
            <p>3.若下載或安裝有發生任何問題，請透過客服中心聯絡我們。</p>
            <p>4.文件大小：下載器(54.1MB) / 免安裝檔(3.37GB)</p>
            <p>5.版本發佈時間：2023/9/28</p>
            <p>6.為避免異常，請玩家安裝路徑優先採用英文數字組合</p>
        </div>
        <table>
            <tr class="tab_head">
                <td colspan="3">硬體需求</td>
            </tr>
            <tr class="tab_head_s">
                <td>項目</td>
                <td>最低配備</td>
                <td>推薦配備</td>
            </tr>
            <tr>
                <td>CPU</td>
                <td>Intel® Core™2 Duo E7000以上</td>
                <td>Intel® Core™ i3-2100以上</td>
            </tr>
            <tr>
                <td>記憶體</td>
                <td>2GB以上</td>
                <td>4GB以上</td>
            </tr>
            <tr>
                <td>顯示卡</td>
                <td>GeForce 8600 GT以上</td>
                <td>GeForce GTS 250以上</td>
            </tr>
            <tr>
                <td>硬碟空間</td>
                <td colspan="2">15GB以上</td>
            </tr>
            <tr>
                <td>音效卡</td>
                <td colspan="2">相容DirectX 9.0c</td>
            </tr>
        </table>
    </div>
@endsection
