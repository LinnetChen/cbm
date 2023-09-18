@extends('layouts.app2')
@section('title',"《黑色契約CABAL Online》精選桌布")
@section('link')
<link rel="stylesheet" href="/css/home_page/wallpaper_download_style.css?v1.0">
@endsection
@section('main_title',"精選桌布")
@section('content')
<div class="content_box">
    <div class="box">
        <a href="img/home_page/wallpaper/wallpaper1.jpg" download="cabal_wallpaper1">
            <div class="download_icon"></div>
        </a>
        <img src="../../img/home_page/wallpaper/wallpaper1_s.jpg" class="img">
    </div>
    <div class="box">
        <a href="img/home_page/wallpaper/wallpaper2.png" download="cabal_wallpaper2">
            <div class="download_icon"></div>
        </a>
        <img src="../../img/home_page/wallpaper/wallpaper2_s.png" class="img">
    </div>
    <div class="box">
        <a href="img/home_page/wallpaper/wallpaper3.jpg" download="cabal_wallpaper3">
            <div class="download_icon"></div>
        </a>
        <img src="../../img/home_page/wallpaper/wallpaper3_s.jpg" class="img">
    </div>
    <div class="box">
        <a href="img/home_page/wallpaper/wallpaper4.jpg" download="cabal_wallpaper4">
            <div class="download_icon"></div>
        </a>
        <img src="../../img/home_page/wallpaper/wallpaper4_s.jpg" class="img">
    </div>
    <div class="box">
        <a href="img/home_page/wallpaper/wallpaper5.jpg" download="cabal_wallpaper5">
            <div class="download_icon"></div>
        </a>
        <img src="../../img/home_page/wallpaper/wallpaper5_s.jpg" class="img">
    </div>
    <div class="box">
        <a href="img/home_page/wallpaper/wallpaper6.jpg" download="cabal_wallpaper6">
            <div class="download_icon"></div>
        </a>
        <img src="../../img/home_page/wallpaper/wallpaper6_s.jpg" class="img">
    </div>
    <div class="box">
        <a href="img/home_page/wallpaper/wallpaper7.jpg" download="cabal_wallpaper7">
            <div class="download_icon"></div>
        </a>
        <img src="../../img/home_page/wallpaper/wallpaper7_s.jpg" class="img">
    </div>
    <div class="box">
        <a href="img/home_page/wallpaper/wallpaper8.jpg" download="cabal_wallpaper8">
            <div class="download_icon"></div>
        </a>
        <img src="../../img/home_page/wallpaper/wallpaper8_s.jpg" class="img">
    </div>
    <div class="box">
        <a href="img/home_page/wallpaper/wallpaper9.jpg" download="cabal_wallpaper9">
            <div class="download_icon"></div>
        </a>
        <img src="../../img/home_page/wallpaper/wallpaper9_s.jpg" class="img">
    </div>
</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    $('.box').hover(function() {
        $(this).find('.download_icon').css('display', "block");
        $(this).find('.img').css('opacity', "0.7");
    }, function() {
        $('.download_icon').css('display', "none");
        $('.box').find('.img').css('opacity', "1");
    });
</script>
@endsection
