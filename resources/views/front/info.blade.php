@extends('layouts.app2')
@section('title', '《黑色契約CABAL Online》遊戲公告')
@section('link')
    <link rel="stylesheet" href="/css/home_page/info_style.css">
@endsection
@section('main_title', )
@section('content')
    <div class="info">
        <div class="info_topbox">
            <div class="info_tab">
                <button class=" tab_button all" data-target="#info_all" onclick="newsClick('all')">
                    綜合
                </button>
                <button class="tab_button activity" data-target="#info_event" onclick="newsClick('activity')">活動</button>
                <button class="tab_button system" data-target="#info_system" onclick="newsClick('system')">系統</button>
            </div>
        </div>
        <div class="info_container">
            <div class="info_box active" id="info_all">
                @foreach ($list as $value)
                    @if ($value['top'] == 'y')
                        <ul class="textUITOP">
                        @elseif($value['new'] == 'y')
                            <ul class="textUINEW">
                            @else
                                <ul class="textUInormal">
                    @endif


                    <li><a class="textbox" href="{{route('info_content',$value['id'])}}">
                        @if($value['cate_id']==1)
                        <div class="info_title">【活動】{{ $value['title'] }}</div>
                        @else
                        <div class="info_title">【系統】{{ $value['title'] }}</div>
                        @endif
                            <div class="info_date">{{ date('Y/m/d', strtotime($value['created_at'])) }}</div>
                        </a></li>
                    </ul>
                @endforeach
            </div>
        </div>
    </div>
    {{-- 頁碼 --}}
    {!! $list->links() !!}
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script>
        _url = window.location.href
        addActive = _url.split('info/').pop()
        if (addActive != 'all' && addActive != 'activity' && addActive != 'system') {
            $('.all').addClass('active')
        } else {
            if (addActive == 'all') {
                $('.main_title').text('綜合公告')
            } else if (addActive == 'activity') {
                $('.main_title').text('活動公告')
            } else if (addActive == 'system') {
                $('.main_title').text('系統公告')
            }
            $('.' + addActive).addClass('active')
        }


        function newsClick(cate) {
            document.location.href = "/info/" + cate
        }
    </script>
@endsection
