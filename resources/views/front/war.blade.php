@extends('layouts.app2')
@section('title',"《黑色契約CABAL Online》國家戰爭")
@section('link')
<link rel="stylesheet" href="/css/home_page/war_style.css">
<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
@endsection
@section('main_title',"國家戰爭")
@section('content2')
<div class="title_box">
    <div class="war_main_title">國家戰爭</div>
    <select class="section" name="server">
        <option>伺服器</option>
    </select>
</div>
<div class="war_bg">
    <div class="content_box">
        <div class="result_title" data-aos="fade-up"></div>
        <div class="camp_box" data-aos="fade-up">
            <div class="bluecamp">
                <div class="bluecamp_icon"></div>
                <div class="bluecamp_title"></div>
            </div>
            <div class="score_box" data-aos="fade-up">
                <div class="score_box_s">
                    <div class="score_text">
                        <span>01</span>
                        <span>01</span>
                    </div>
                    <div class="dot"></div>
                    <div class="score_text">
                        <span>22</span>
                        <span>22</span>
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
            <tr data-aos="fade-up">
                <td>
                    <div class="leader_jobIcon_01"></div>
                </td>
                <td class="under_line">名稱最多有八個字</td>
                <td class="under_line">1009900</td>
                <td class="under_line">99990</td>
                <td class="under_line"><img src="/img/home_page/war/52.png"></td>
                <td class="under_line">ABCDEFGHIJKLMNOP</td>
                <td class="under_line">1000000</td>
                <td class="under_line">99990</td>
                <td>
                    <div class="leader_jobIcon_02"></div>
                </td>
            </tr>
            <tr data-aos="fade-up">
                <td>
                    <div class="leader_jobIcon_01"></div>
                </td>
                <td class="under_line">玩家1</td>
                <td class="under_line">1009900</td>
                <td class="under_line">99990</td>
                <td class="under_line"><img src="/img/home_page/war/80.png"></td>
                <td class="under_line">玩家2</td>
                <td class="under_line">1000000</td>
                <td class="under_line">99990</td>
                <td>
                    <div class="leader_jobIcon_02"></div>
                </td>
            </tr>
            <tr data-aos="fade-up">
                <td>
                    <div class="leader_jobIcon_01"></div>
                </td>
                <td class="under_line">玩家1</td>
                <td class="under_line">1009000</td>
                <td class="under_line">99990</td>
                <td class="under_line"><img src="/img/home_page/war/110.png"></td>
                <td class="under_line">玩家2</td>
                <td class="under_line">1000000</td>
                <td class="under_line">99990</td>
                <td>
                    <div class="leader_jobIcon_02"></div>
                </td>
            </tr>
            <tr data-aos="fade-up">
                <td>
                    <div class="leader_jobIcon_01"></div>
                </td>
                <td class="under_line">玩家1</td>
                <td class="under_line">1009000</td>
                <td class="under_line">99990</td>
                <td class="under_line"><img src="/img/home_page/war/140.png"></td>
                <td class="under_line">玩家2</td>
                <td class="under_line">1000000</td>
                <td class="under_line">99990</td>
                <td>
                    <div class="leader_jobIcon_02"></div>
                </td>
            </tr>
            <tr data-aos="fade-up">
                <td>
                    <div class="leader_jobIcon_01"></div>
                </td>
                <td class="under_line">玩家1</td>
                <td class="under_line">1009000</td>
                <td class="under_line">99990</td>
                <td class="under_line"><img src="/img/home_page/war/170.png"></td>
                <td class="under_line">玩家2</td>
                <td class="under_line">1000000</td>
                <td class="under_line">99990</td>
                <td>
                    <div class="leader_jobIcon_02"></div>
                </td>
            </tr>
            <tr data-aos="fade-up">
                <td>
                    <div class="leader_jobIcon_01"></div>
                </td>
                <td class="under_line">玩家1</td>
                <td class="under_line">1009000</td>
                <td class="under_line">99990</td>
                <td class="under_line"><img src="/img/home_page/war/200.png"></td>
                <td class="under_line">玩家2</td>
                <td class="under_line">1000000</td>
                <td class="under_line">99990</td>
                <td>
                    <div class="leader_jobIcon_02"></div>
                </td>
            </tr>
            
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
            <tr data-aos="fade-up">
                <td class="under_line">名稱最多有八個字</td>
                <td class="under_line">100</td>
                <td class="under_line">名稱最多有八個字</td>
                <td>
                    <div class="leader_jobIcon_01"></div>
                </td>
                <td class="under_line">ABCDEFGHIJKLMNOP</td>
                <td class="under_line">100</td>
                <td class="under_line">ABCDEFGHIJKLMNOP</td>
            </tr>
            <tr data-aos="fade-up">
                <td class="under_line">玩家1</td>
                <td class="under_line">100</td>
                <td class="under_line">xxxxxxxxxxxxx</td>
                <td>
                    <div class="leader_jobIcon_02"></div>
                </td>
                <td class="under_line">玩家2</td>
                <td class="under_line">100</td>
                <td class="under_line">xxxxxxxxxxxxxx</td>
            </tr>
            <tr data-aos="fade-up">
                <td class="under_line">玩家1</td>
                <td class="under_line">100</td>
                <td class="under_line">xxxxxxxxxxxxx</td>
                <td>
                    <div class="leader_jobIcon_03"></div>
                </td>
                <td class="under_line">玩家2</td>
                <td class="under_line">100</td>
                <td class="under_line">xxxxxxxxxxxxxx</td>
            </tr>
            <tr data-aos="fade-up">
                <td class="under_line">玩家1</td>
                <td class="under_line">100</td>
                <td class="under_line">xxxxxxxxxxxxx</td>
                <td>
                    <div class="leader_jobIcon_04"></div>
                </td>
                <td class="under_line">玩家2</td>
                <td class="under_line">100</td>
                <td class="under_line">xxxxxxxxxxxxxx</td>
            </tr>
            <tr data-aos="fade-up">
                <td class="under_line">玩家1</td>
                <td class="under_line">100</td>
                <td class="under_line">xxxxxxxxxxxxx</td>
                <td>
                    <div class="leader_jobIcon_05"></div>
                </td>
                <td class="under_line">玩家2</td>
                <td class="under_line">100</td>
                <td class="under_line">xxxxxxxxxxxxxx</td>
            </tr>
            <tr data-aos="fade-up">
                <td class="under_line">玩家1</td>
                <td class="under_line">100</td>
                <td class="under_line">xxxxxxxxxxxxx</td>
                <td>
                    <div class="leader_jobIcon_06"></div>
                </td>
                <td class="under_line">玩家2</td>
                <td class="under_line">100</td>
                <td class="under_line">xxxxxxxxxxxxxx</td>
            </tr>
            <tr data-aos="fade-up">
                <td class="under_line">玩家1</td>
                <td class="under_line">100</td>
                <td class="under_line">xxxxxxxxxxxxx</td>
                <td>
                    <div class="leader_jobIcon_07"></div>
                </td>
                <td class="under_line">玩家2</td>
                <td class="under_line">100</td>
                <td class="under_line">xxxxxxxxxxxxxx</td>
            </tr>
            <tr data-aos="fade-up">
                <td class="under_line">玩家1</td>
                <td class="under_line">100</td>
                <td class="under_line">xxxxxxxxxxxxx</td>
                <td>
                    <div class="leader_jobIcon_08"></div>
                </td>
                <td class="under_line">玩家2</td>
                <td class="under_line">100</td>
                <td class="under_line">xxxxxxxxxxxxxx</td>
            </tr>
            <tr data-aos="fade-up">
                <td class="under_line">玩家1</td>
                <td class="under_line">100</td>
                <td class="under_line">xxxxxxxxxxxxx</td>
                <td>
                    <div class="leader_jobIcon_09"></div>
                </td>
                <td class="under_line">玩家2</td>
                <td class="under_line">100</td>
                <td class="under_line">xxxxxxxxxxxxxx</td>
            </tr>
        </table>
    </div>
</div>


@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();
</script>
@endsection