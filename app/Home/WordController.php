<?php
/**
 * 文字文案相关类
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2017/10/30
 * Time: 下午8:42
 */
namespace App\Home;


class WordController extends BaseController
{

    /**
     * 代理介绍
     */
    public function agentIntro()
    {
        return view('home.word.agentIntro');
    }

    /**
     * 奖励规则
     */
    public function rewardRule()
    {
        return view('home.word.rewardRule');
    }

}