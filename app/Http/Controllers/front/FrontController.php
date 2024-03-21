<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\giftContent;
use App\Models\giftCreate;
use App\Models\giftGetLog;
use App\Models\giftGroup;
use App\Models\Image;
use App\Models\page;
use App\Models\suspension;
use GuzzleHttp\Client;

class FrontController extends Controller
{
    public function index()
    {
        $img = Image::where('status', 'Y')->where('type', 'index')->orderBy('sort', 'desc')->get();
        $na = page::where('type', 'announcement')->where('open', 'Y')->where('created_at', '<=', date('Y-m-d H:i:s'))->orderBy('top', 'desc')->orderBy('new', 'desc')->orderBy('created_at', 'desc')->orderBy('sort', 'desc')->limit(6)->get();
        $nb = page::where('type', 'announcement')->where('cate_id', 1)->where('open', 'Y')->where('created_at', '<=', date('Y-m-d H:i:s'))->orderBy('top', 'desc')->orderBy('new', 'desc')->orderBy('created_at', 'desc')->orderBy('sort', 'desc')->limit(6)->get();
        $nc = page::where('type', 'announcement')->where('cate_id', 2)->where('open', 'Y')->where('created_at', '<=', date('Y-m-d H:i:s'))->orderBy('top', 'desc')->orderBy('new', 'desc')->orderBy('created_at', 'desc')->orderBy('sort', 'desc')->limit(6)->get();
        return view('front.home_page', [
            'img' => $img,
            'na' => $na,
            'nb' => $nb,
            'nc' => $nc,
        ]);
    }
    public function wiki($id = 0)
    {
        if ($id == 0) {
            $first = page::where('open', 'Y')->where('type', 'wiki')->orderby('sort', 'desc')->first();
            $id = $first['id'];
        }
        // 撈出分類和頁面的正確排序
        $side = page::where('open', 'Y')->where('type', 'wiki')->orderby('overall_sort', 'desc')->orderby('sort', 'desc')->get();
        // 用cate_id區分項目
        $groupItem = $side->groupBy(['cate_id']);
        $sideSort = [];
        $cate_inArray = [];
        // 整理分類與該分類項目,區分單一page
        foreach ($side as $key => $value) {
            if ($value['cate_id'] != null) {
                if (!in_array($value['cate_id'], $cate_inArray)) {
                    $findCate = Category::find($value['cate_id']);
                    $sideSort[$value['cate_id']]['cate_title'] = $findCate['cate_title'];
                    $sideSort[$value['cate_id']]['id'] = $findCate['id'];
                    $sideSort[$value['cate_id']]['have_cate'] = true;
                    array_push($cate_inArray, $value['cate_id']);
                }
            } else {
                $sideSort[$key]['cate_title'] = $value['title'];
                $sideSort[$key]['id'] = $value['id'];
                $sideSort[$key]['have_cate'] = false;
            }
        }
        // 撈出畫面
        if ($_SERVER['HTTP_CF_CONNECTING_IP'] == '211.23.144.219') {
            $page = page::where('id', $id)->where('type', 'wiki')->first();
        } else {
            $page = page::where('id', $id)->where('type', 'wiki')->where('open', 'y')->first();
        }
        if (!$page) {
            return redirect('https://cbo.digeam.com/');
        }
        return view('home_wiki', [
            'side' => $sideSort, //側邊攔
            'page' => $page, //內容
            'sideContent' => $groupItem, //側邊攔分類子項
        ]);
    }
    public function wiki_search($keywords)
    {
        // 撈出分類和頁面的正確排序
        $side = page::where('open', 'Y')->where('type', 'wiki')->orderby('overall_sort', 'desc')->orderby('sort', 'desc')->get();
        // 用cate_id區分項目
        $groupItem = $side->groupBy(['cate_id']);
        $sideSort = [];
        $cate_inArray = [];
        // 整理分類與該分類項目,區分單一page
        foreach ($side as $key => $value) {
            if ($value['cate_id'] != null) {
                if (!in_array($value['cate_id'], $cate_inArray)) {
                    $findCate = Category::find($value['cate_id']);
                    $sideSort[$value['cate_id']]['cate_title'] = $findCate['cate_title'];
                    $sideSort[$value['cate_id']]['id'] = $findCate['id'];
                    $sideSort[$value['cate_id']]['have_cate'] = true;
                    array_push($cate_inArray, $value['cate_id']);
                }
            } else {
                $sideSort[$key]['cate_title'] = $value['title'];
                $sideSort[$key]['id'] = $value['id'];
                $sideSort[$key]['have_cate'] = false;
            }
        }
        // 撈出畫面
        // 避免%跟_這樣的特殊字引響搜尋
        $fix_keywords = FrontController::escape_like_str($keywords);
        $page = page::where('type', 'wiki')->where('open', 'Y')->where(function ($query) use ($keywords, $fix_keywords) {
            $query->where('title', 'like', $keywords)->orWhere('content', 'like', "%" . $fix_keywords . "%");
        })->get();
        return view('home_wiki_search', [
            'side' => $sideSort, //側邊攔
            'page' => $page, //內容
            'sideContent' => $groupItem, //側邊攔分類子項
        ]);
    }
    // 特殊字元處理
    public function escape_like_str($str)
    {
        $like_escape_char = '';

        return str_replace([$like_escape_char, '%', '_'], [
            $like_escape_char . $like_escape_char,
            $like_escape_char . '%',
            $like_escape_char . '_',
        ], $str);

    }
    public function info($cate = 'all')
    {
        if ($cate == 'all') {
            $list = page::where('type', 'announcement')->where('open', 'Y')->where('created_at', '<=', date('Y-m-d H:i:s'))->orderBy('top', 'desc')->orderBy('new', 'desc')->orderBy('created_at', 'desc')->orderBy('sort', 'desc')->paginate(10);
        } else if ($cate == 'activity') {
            $list = page::where('type', 'announcement')->where('cate_id', 1)->where('open', 'Y')->where('created_at', '<=', date('Y-m-d H:i:s'))->orderBy('top', 'desc')->orderBy('new', 'desc')->orderBy('created_at', 'desc')->orderBy('sort', 'desc')->paginate(10);
        } else if ($cate == 'system') {
            $list = page::where('type', 'announcement')->where('cate_id', 2)->where('open', 'Y')->where('created_at', '<=', date('Y-m-d H:i:s'))->orderBy('top', 'desc')->orderBy('new', 'desc')->orderBy('created_at', 'desc')->orderBy('sort', 'desc')->paginate(10);
        } else {
            $list = page::where('type', 'announcement')->where('open', 'Y')->where('created_at', '<=', date('Y-m-d H:i:s'))->orderBy('top', 'desc')->orderBy('new', 'desc')->orderBy('created_at', 'desc')->orderBy('sort', 'desc')->paginate(10);
        }
        return view('front.info', [
            'list' => $list,
        ]);
    }
    public function info_content($id = 0)
    {
        if ($id == 0) {
            return redirect('https://cbo.digeam.com/');
        } else {
            if ($_SERVER['HTTP_CF_CONNECTING_IP'] == '211.23.144.219') {
                $page = page::where('id', $id)->where('type', 'announcement')->first();
            } else {
                $page = page::where('id', $id)->where('type', 'announcement')->where('open', 'y')->first();
            }
            if (!$page) {
                return redirect('https://cbo.digeam.com/');
            }
        };
        return view('front/info_content', [
            'page' => $page,
        ]);
    }
    public function suspension_list()
    {
        $list = suspension::orderBy('created_at', 'desc')->paginate(50);
        return view('front.suspension_list', [
            'list' => $list,
        ]);
    }
    public function gift()
    {
        $list = giftCreate::orderBy('created_at', 'desc')->paginate(6);

        // 撈出畫面
        if ($_SERVER['HTTP_CF_CONNECTING_IP'] == '211.23.144.219') {
            $list = giftCreate::orderBy('created_at', 'desc')->paginate(6);
        } else {
            $list = giftCreate::where('status', 'y')->orderBy('created_at', 'desc')->paginate(6);
        }

        return view('front/gift', [
            'list' => $list,
        ]);
    }
    public function giftContent($id = 0)
    {
        if ($id == 0) {
            return redirect('/gift');
        } else {
            $list = giftCreate::where('status', 'y')->orderBy('created_at', 'desc')->paginate(6);
            $giftCreate = giftCreate::where('id', $id)->where('status', 'y')->first();
            if (!$giftCreate) {
                return redirect('https://cbo.digeam.com/');
            }
            // 撈出畫面
            if ($_SERVER['HTTP_CF_CONNECTING_IP'] == '211.23.144.219') {
                $list = giftCreate::orderBy('created_at', 'desc')->paginate(6);
                $giftCreate = giftCreate::where('id', $id)->first();
                if (!$giftCreate) {
                    return redirect('https://cbo.digeam.com/');
                }
            } else {
                $list = giftCreate::where('status', 'y')->orderBy('created_at', 'desc')->paginate(6);
                $giftCreate = giftCreate::where('id', $id)->where('status', 'y')->first();
                if (!$giftCreate) {
                    return redirect('https://cbo.digeam.com/');
                }
            }
            $giftGroup = giftGroup::where('gift_id', $id)->get();
            $repeat = [16, 17, 18, 19, 28, 30, 31, 36, 37, 38, 39, 40, 67, 65];
            if (isset($_COOKIE['StrID']) && isset($_COOKIE['StrID']) != null) {
                foreach ($giftGroup as $key => $value) {
                    if (!in_array($value['id'], $repeat)) {
                        $check = giftGetLog::where('gift', $value['id'])->where('user', $_COOKIE['StrID'])->first();
                        if ($check) {
                            $giftGroup[$key]['already_get'] = 'y';
                        } else {
                            $giftGroup[$key]['already_get'] = 'n';
                        }
                    } else {
                        $giftGroup[$key]['already_get'] = 'n';
                    }
                }
            }
            return view('front/gift_content', [
                'list' => $list,
                'giftGroup' => $giftGroup,
                'giftCreate' => $giftCreate,
            ]);
        }
    }
    public function newGiftContent($id = 0)
    {
        $_COOKIE['StrID'] = 'jacky0996';
        $hasChar_01 = true;
        $hasChar_02 = true;
        // 確認1.2服是否有角色
        $client = new Client(['verify' => false]);
        $res = $client->request('GET', 'http://c1twapi.global.estgames.com/game/character/searchByCharacterId?userId=jacky0996&serverCode=server01');
        $check_01 = $res->getBody();
        $check_01 = json_decode($check_01);

        $client = new Client(['verify' => false]);
        $res = $client->request('GET', 'http://c1twapi.global.estgames.com/game/character/searchByCharacterId?userId=jacky0996&serverCode=server02');
        $check_02 = $res->getBody();
        $check_02 = json_decode($check_02);

        if (count($check_01->data) > 0) {
            $hasChar_01 = true;
        } else {
            $hasChar_01 = false;
        };

        if (count($check_02->data) > 0) {
            $hasChar_02 = true;
        } else {
            $hasChar_02 = false;
        };
        if ($id == 0) {
            return redirect('/gift');
        } else {
            $list = giftCreate::where('status', 'y')->orderBy('created_at', 'desc')->paginate(6);
            $giftCreate = giftCreate::where('id', $id)->where('status', 'y')->first();
            if (!$giftCreate) {
                return redirect('https://cbo.digeam.com/');
            }
            // 撈出畫面
            if ($_SERVER['HTTP_CF_CONNECTING_IP'] == '211.23.144.219') {
                $list = giftCreate::orderBy('created_at', 'desc')->paginate(6);
                $giftCreate = giftCreate::where('id', $id)->first();
                if (!$giftCreate) {
                    return redirect('https://cbo.digeam.com/');
                }
            } else {
                $list = giftCreate::where('status', 'y')->orderBy('created_at', 'desc')->paginate(6);
                $giftCreate = giftCreate::where('id', $id)->where('status', 'y')->first();
                if (!$giftCreate) {
                    return redirect('https://cbo.digeam.com/');
                }
            }
            $giftGroup = giftGroup::where('gift_id', $id)->get();
            $repeat = [16, 17, 18, 19, 28, 30, 31, 36, 37, 38, 39, 40, 67, 65];
            if (isset($_COOKIE['StrID']) && isset($_COOKIE['StrID']) != null) {
                foreach ($giftGroup as $key => $value) {
                    if (!in_array($value['id'], $repeat)) {
                        $check = giftGetLog::where('gift', $value['id'])->where('user', $_COOKIE['StrID'])->first();
                        if ($check) {
                            $giftGroup[$key]['already_get'] = 'y';
                        } else {
                            $giftGroup[$key]['already_get'] = 'n';
                        }
                    } else {
                        $giftGroup[$key]['already_get'] = 'n';
                    }
                }
            }
            return view('front/new_gift_content', [
                'list' => $list,
                'giftGroup' => $giftGroup,
                'giftCreate' => $giftCreate,
                'hasChar_01' => $hasChar_01,
                'hasChar_02' => $hasChar_02,
            ]);
        }
    }
    public function giftSearch($year, $month, $keywords = null)
    {
        if ($year == 0) {
            $year = date('Y');
        }
        if ($month == 0) {
            $month = date('m');
        }
        $limit = $year . '-' . $month . '-31';
        if ($keywords == null) {
            $list = giftCreate::where('status', 'y')->where('created_at', '<', $limit)->orderby('created_at', 'desc')->paginate(6);
        } else {
            $fix_keywords = FrontController::escape_like_str($keywords);
            $list = giftCreate::where('status', 'y')->where('created_at', '<', $limit)->where('title', 'like', "%" . $fix_keywords . "%")->orderby('created_at', 'desc')->paginate(6);
        }
        return view('front/gift_search', [
            'list' => $list,
        ]);
    }
    public function launcher()
    {
        $img = Image::where('status', 'Y')->where('type', 'index')->orderBy('sort', 'desc')->get();
        $na = page::where('type', 'announcement')->where('open', 'Y')->where('created_at', '<=', date('Y-m-d H:i:s'))->orderBy('top', 'desc')->orderBy('new', 'desc')->orderBy('created_at', 'desc')->orderBy('sort', 'desc')->limit(6)->get();
        $nb = page::where('type', 'announcement')->where('cate_id', 1)->where('open', 'Y')->where('created_at', '<=', date('Y-m-d H:i:s'))->orderBy('top', 'desc')->orderBy('new', 'desc')->orderBy('created_at', 'desc')->orderBy('sort', 'desc')->limit(6)->get();
        $nc = page::where('type', 'announcement')->where('cate_id', 2)->where('open', 'Y')->where('created_at', '<=', date('Y-m-d H:i:s'))->orderBy('top', 'desc')->orderBy('new', 'desc')->orderBy('created_at', 'desc')->orderBy('sort', 'desc')->limit(6)->get();
        return view('launcher', [
            'img' => $img,
            'na' => $na,
            'nb' => $nb,
            'nc' => $nc,
        ]);
    }
    public function war($serverIdx = 1)
    {
        $client = new Client();
        $data = [
            "serverIdx" => intval($serverIdx),
            "logIdx" => 0,
        ];

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        $res = $client->request('POST', 'http://c1twapi.global.estgames.com/event/weekly/getData', [
            'headers' => $headers,
            'json' => $data,
        ]);
        $result = $res->getBody();
        $result = json_decode($result);
        if (intval($serverIdx) == 1) {
            $servername = '冰迫星';
        } else {
            $servername = '黑恆星';
        }
        return view('front/war', [
            'result' => $result,
            'servername' => $servername,
        ]);
    }

}
