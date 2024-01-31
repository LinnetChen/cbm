@extends('layouts.app2')
@section('title', '《黑色契約CABAL Online》國家戰爭')
@section('link')
    <link rel="stylesheet" href="/css/home_page/war_style.css?v1.1">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <style>
        .section option{
            color:black;
        }
    </style>
@endsection
@section('main_title', '國家戰爭')
@section('content2')
    <div class="title_box">
        <div class="war_main_title">國家戰爭</div>
        <select class="section" name="server">
            <option calss = server_1 value =1>冰珀星</option>
            <option calss = server_2 value =2>黑恆星</option>
        </select>
    </div>
    <div class="war_bg">
        <div class="content_box">
            <div class="result_title" data-aos="fade-up"a></div>
            <div class="camp_box" data-aos="fade-up">
                <div class="bluecamp">
                    <div class="bluecamp_icon"></div>
                    <div class="bluecamp_title"></div>
                </div>
                <div class="score_box" data-aos="fade-up">
                    <div class="score_box_s">
                        <div class="score_text">
                            @if ($result->data->warResult->capella < 10)
                                <span>0{{ $result->data->warResult->capella }}</span>
                                <span>0{{ $result->data->warResult->capella }}</span>
                            @else
                                <span>{{ $result->data->warResult->capella }}</span>
                                <span>{{ $result->data->warResult->capella }}</span>
                            @endif
                        </div>
                        <div class="dot"></div>
                        <div class="score_text">
                            @if ($result->data->warResult->procyon < 10)
                                <span>0{{ $result->data->warResult->procyon }}</span>
                                <span>0{{ $result->data->warResult->procyon }}</span>
                            @else
                                <span>{{ $result->data->warResult->procyon }}</span>
                                <span>{{ $result->data->warResult->procyon }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="score_line"></div>
                    <p>（僅統計最近三個月）</p>
                </div>
                <div class="redcamp" data-aos="fade-up">
                    <div class="redcamp_icon"></div>
                    <div class="redcamp_title"></div>
                </div>
            </div>
            <div class="leader_title" data-aos="fade-up"></div>
            <table class="leader_table">
                <tr data-aos="fade-up">
                    <th width="15%"></th>
                    <th width="22%" class="blue_th">玩家ID</th>
                    <th width="12%" class="blue_th">得分</th>
                    <th width="12%" class="blue_th">擊殺數</th>
                    <th width="30%">等級區間</th>
                    <th width="22%" class="red_th">玩家ID</th>
                    <th width="12%" class="red_th">得分</th>
                    <th width="12%" class="red_th">擊殺數</th>
                    <th width="15%"></th>
                </tr>
                <tr data-aos="fade-up">
                    <td colspan="9">
                        <div class="leader_table_line"></div>
                    </td>
                </tr>
                @foreach ($result->data->bringersWithLevelType as $key => $value)
                    <tr data-aos="fade-up">
                        @if ($value->cepella == null)
                            <td>
                                <div class="leader_jobIcon_00"></div>
                            </td>
                            <td class="under_line">-</td>
                            <td class="under_line">-</td>
                            <td class="under_line">-</td>
                        @else
                            <td>
                                <div class="leader_jobIcon_0{{ $value->cepella->battleStyle }}"></div>
                            </td>
                            <td class="under_line">{{ $value->cepella->characterName }}</td>
                            <td class="under_line">{{ $value->cepella->score }}</td>
                            <td class="under_line">{{ $value->cepella->killcount }}</td>
                        @endif

                        <td class="under_line"><img src="/img/war/{{ $key }}.png"></td>


                        @if ($value->procyon ==null)
                            <td class="under_line">-</td>
                            <td class="under_line">-</td>
                            <td class="under_line">-</td>
                            <td>
                                <div class="leader_jobIcon_00"></div>
                            </td>
                        @else
                            <td class="under_line">{{ $value->procyon->characterName }}</td>
                            <td class="under_line">{{ $value->procyon->score }}</td>
                            <td class="under_line">{{ $value->procyon->killcount }}</td>
                            <td>
                                <div class="leader_jobIcon_0{{ $value->procyon->battleStyle }}"></div>
                            </td>
                        @endif

                    </tr>
                @endforeach
            </table>
            <div class="protector_title" data-aos="fade-up"></div>
            <table class="protector_table">
                <tr data-aos="fade-up">
                    <th class="blue_th" width="20%">玩家ID</th>
                    <th class="blue_th" width="10%">等級</th>
                    <th class="blue_th" width="20%">所屬公會</th>
                    <th width="15%"></th>
                    <th class="red_th" width="20%">玩家ID</th>
                    <th class="red_th" width="10%">等級</th>
                    <th class="red_th" width="20%">所屬公會</th>
                </tr>
                <tr data-aos="fade-up">
                    <td colspan="7">
                        <div class="protector_table_line"></div>
                    </td>
                </tr>
                @foreach ($result->data->guardianWithClass as $key => $value)
                    <tr data-aos="fade-up">
                        @if($value->cepella != null )
                        <td class="under_line">{{ $value->cepella->characterName }}</td>
                        <td class="under_line">{{ $value->cepella->level }}</td>
                        <td class="under_line">{{ $value->cepella->guildName }}</td>
                        @else
                        <td class="under_line">-</td>
                        <td class="under_line">-</td>
                        <td class="under_line">-</td>
                        @endif
                        <td>
                            @switch ($value->type)
                                @case(1)
                                    <div class="leader_jobIcon_01"></div>
                                @break;
                                @case(2)
                                    <div class="leader_jobIcon_02"></div>
                                @break;
                                @case(3)
                                    <div class="leader_jobIcon_06"></div>
                                @break;
                                @case(4)
                                    <div class="leader_jobIcon_07"></div>
                                @break;
                                @case(5)
                                    <div class="leader_jobIcon_03"></div>
                                @break;
                                @case(6)
                                    <div class="leader_jobIcon_04"></div>
                                @break;
                                @case(7)
                                    <div class="leader_jobIcon_05"></div>
                                @break;
                                @case(8)
                                    <div class="leader_jobIcon_08"></div>
                                @break;
                                @case(9)
                                    <div class="leader_jobIcon_09"></div>
                                @break;
                            @endswitch
                        </td>
                        @if ($value->procyon != null)
                        <td class="under_line">{{ $value->procyon->characterName }}</td>
                        <td class="under_line">{{ $value->procyon->level }}</td>
                        <td class="under_line">{{ $value->procyon->guildName }}</td>
                        @else
                        <td class="under_line">-</td>
                        <td class="under_line">-</td>
                        <td class="under_line">-</td>
                        @endif
                    </tr>
                @endforeach
            </table>
        </div>
    </div>


@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
        var getServer = window.location.href.split('/').pop()
        if(getServer == 2){
            $('.section option[value=2]').attr('selected', 'selected');
        }

        $('.section').on('change',function(){
            window.location.href = "https://cbo.digeam.com/war/"+$(this).val()
        })
    </script>
@endsection
