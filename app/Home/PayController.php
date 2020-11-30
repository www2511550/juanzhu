<?php
/**
 * 支付控制器
 * User: chengcong
 * Date: 2018/6/4
 * Time: 下午9:19
 */
namespace App\Home;

class PayController extends BaseController
{

    public function qCode()
    {

        return view('wxpay.qcode');
    }


}


