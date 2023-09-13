@extends('layouts.app2')
@section('title',"《黑色契約CABAL Online》停權名單")
@section('link')
<link rel="stylesheet" href="/css/home_page/suspension_list_style.css">
@endsection
@section('main_title',"停權名單")
@section('content')
<div class="text_box">
<p>最後更新日期：</p>
</div>
<table>
    <tr class="tab_head_s">
        <td>停權日期</td>
        <td>帳號/角色名稱</td>
        <td>說明</td>
        <td>懲處結果</td>
    </tr>
    <tr>
        <td>2023/07/21</td>
        <td class="name">姓名</td>
        <td>XXXXXXXXXXXXXXXXXXXXX</td>
        <td>停權三日</td>
    </tr>
</table>
@endsection