@extends('layouts.app2')
@section('title',"《黑色契約CABAL Online》停權名單")
@section('link')
<link rel="stylesheet" href="/css/home_page/suspension_list_style.css?v1.0">
@endsection
@section('main_title',"停權名單")
@section('content')
<div class="text_box">
<p>最後更新日期：</p>
</div>
<div class="content_box">
<table>
    <tr class="tab_head_s">
        <td>停權日期</td>
        <td>帳號/角色名稱</td>
        <td>說明</td>
        <td>懲處結果</td>
    </tr>
    @foreach($list as $value)
    <tr>
        <td>{{ date('Y/m/d', strtotime($value['lock_time'])) }}</td>
        <td class="name">{{$value['user_id']}}</td>
        <td>{{$value['description']}}</td>
        <td>{{$value['punish']}}</td>
    </tr>
    @endforeach
</table>
</div>
{{-- 頁碼 --}}
{!! $list->links() !!}
<!-- <nav>
        <ul class="pagination">
            <li class="page-item disabled" aria-disabled="true" aria-label="« Previous">
                 <a class="page-link" href="" rel="next" aria-label="Next »">上一頁</span>
            </li>
            <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
            <li class="page-item"><a class="page-link" href="">2</a></li>
            <li class="page-item">
                <a class="page-link" href="" rel="next" aria-label="Next »">下一頁</a>
            </li>
        </ul>
    </nav> -->
@endsection
