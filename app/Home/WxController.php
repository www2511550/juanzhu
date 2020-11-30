<?php
/**
 * 微信公众号相关页面
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2018/1/21
 * Time: 下午10:14
 */
namespace App\Home;

use Cache;

class WxController extends BaseController
{

    /**
     * 生成海报
     */
    public function poster()
    {
//        Cache::put('over_time', 1, 1/6);
//        if ()
//        $is_over_time =
//        $is_send = Cache::get('a');
//        pree($is_send);
        return view('home.wx.poster');
    }


}