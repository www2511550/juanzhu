<?php
/**
 * Created by Chengcong.
 * Date: 2017/5/23 11:08
 */
namespace App\Admin;

use App\Http\Controllers\Controller;
use App\Model\Config;

class AdminBaseController extends Controller{

    public function __construct()
    {
        view()->share('pid', Config::get('pid'));
    }

    /**
     * 检查是否登陆
     */
    public function checkAdminLogin()
    {
        if (!$_COOKIE['uid']) {
            header('location:/admin/login');
            exit;
        }
    }

    /**
     * 拋出異常並跳轉
     *
     * @param string $msg 提示信息
     * @param string $url 跳轉連結
     *
     * @return response
     */
    protected function error($msg, $url = '', $second = 3)
    {
        $data = [
            'msg' => $msg,
            'url' => $url,
            'second' => $second,
            'explain' => '<br/><a href="' . $url . '">如果您不想等待，请点击此处链接</a>'
        ];
        return view('error', $data);

    }

    /**
     * 成功跳转
     * @param string $msg  提示信息
     * @param string $url  跳轉連結
     */
    protected function success($msg, $url = '/', $second = 3)
    {
        $data = [
            'msg' => $msg,
            'url' => $url,
            'second' => $second,
            'explain' => '<br/><a href="' . $url . '">如果您不想等待，请点击此处链接</a>'
        ];
        return view('success', $data);

    }

    /**
     * 后台密码加密
     * @param $pwd
     */
    public function md5Admin($pwd)
    {
        return md5(md5('youquan_admin_' . $pwd));
    }

}