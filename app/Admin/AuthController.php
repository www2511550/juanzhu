<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2017/9/21
 * Time: 下午9:07
 */
namespace App\Admin;

use App\Model\User;
use Illuminate\Http\Request;
use DB;

class AuthController extends AdminBaseController
{
    /**
     * 用户登陆
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login(Request $request)
    {
        if ('POST' == $request->method()) {  // 登陆提交
            $username = $request->username;
            $pwd = $request->password;
            $code = $request->code;

            $user = DB::table('admin')->where('status',1)->where('username', $username)->first();
            if(!$user) return $this->error('用户不存在！');
            if($user->pwd != User::md5Pwd($pwd, 2)) return $this->error('密码错误！');

            setcookie('uid', $user->id, time()+7200);
            setcookie('username', $user->username, time()+7200);

            // 更新登陆时间
            DB::table('admin')->where('id', $user->id)->update(['lastLoginTime'=>date('Y-m-d H:i:s')]);

            return redirect('/admin');

        } else {
            return view('admin.index.login', ['webTitle' => '登陆']);
        }
    }

    /**
     * 退出登陆
     */
    public function out()
    {
        setcookie('uid', '', time()-1);
        setcookie('username', '', time()-1);
        return redirect('/admin/login');
    }



}