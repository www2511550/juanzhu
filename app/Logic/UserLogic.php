<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 17/5/31
 * Time: 下午9:29
 */
namespace App\Logic;

use App\Model\User;

class UserLogic{

    /**
     * 检测用户名或者密码
     */
    public function validateUser($params, $type = 1)
    {
        $data = ['status'=>0, 'msg'=>''];
        $username = trim($params['username']);
        $password = $params['password'];
        $pwd = $params['pwd'];
        if (strlen($username) < 5 || strlen($pwd) < 5){
            $data['msg'] = '用户名或密码长度不能小于五位数!';
            return $data;
        }
        if ($pwd != $password) {
            $data['msg'] = '两次密码不一致!';
            return $data;
        }
        $record = User::where('username', $username)->first();
        if ($record) {
            $data['msg'] = '用户名已存在,请登录!';
            return $data;
        }
        $status = User::addOneUser($username, $pwd);
        if (false === $status) {
            $data['msg'] = '注册失败,稍后再试!';
            return $data;
        }

        $data['msg'] = 'success';
        $data['status'] = 1;
        return $data;
    }
}