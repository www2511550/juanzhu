<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 17/5/26
 * Time: 下午9:26
 */

namespace App\Home;

use DB;

class CenterController extends BaseController
{

    public function __construct()
    {
        if( !$_COOKIE['uid'] ) {
            header("location:/home/login");die;
        }
    }

    /**
     * 会员中心首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data['action'] = 'center';
        return view('home.center.member', $data);
    }

    /**
     * 个人信息
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function info()
    {
        return view('home.center.info');
    }

    /**
     * 积分中心
     */
    public function score()
    {
        $user_id = getUserId();
        $data['total_score'] = 0;
        $scoreDetail = DB::table('score_detail')->where('user_id', $user_id)->orderBy('created_at', 'desc')->get();
        if ($scoreDetail->toArray()) {
            foreach ($scoreDetail as $key => $vo) {
                $tmpData['title'] = $vo->note;
                $tmpData['score'] = $vo->score;
                $tmpData['time'] = $vo->created_at;
                $data['data'][] = $tmpData;
                $data['total_score'] += intval($vo->score);
            }
        }
        return view('home.center.score', $data);
    }

    /**
     * 我的订单
     */
    public function order()
    {
        return view('home.center.order');
    }
}