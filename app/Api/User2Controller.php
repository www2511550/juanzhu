<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 17/5/31
 * Time: 下午9:59
 */
namespace App\Api;

use App\Logic\UserLogic;
use DB;
use App\Model\User;
use Illuminate\Http\Request;

class UserController extends BaseController
{

    /**
     * 登陆
     */
    public function login(Request $request)
    {
        $data = ['status' => 0, 'msg' => ''];
        $username = $request->get('username');
        $pwd = $request->get('pwd');
        $token = $request->get('token');

        $record = User::where('username', $username)->first();
        if (!$record) {
            $data['msg'] = '用户名不存在!';
            return $data;
        }
        if (User::md5Pwd($pwd, $record->token) != $record->pwd) {
            $data['msg'] = '密码错误!';
            return $data;
        }
        if(User::md5Pwd($pwd.$username, 'juanzhuzhu') != $token) {
            $data['msg'] = 'token error!';
            return $data;
        }
        $data['status'] = 1;
        $data['msg'] = 'success';
        $data['user'] = ['uid' => $record->id, 'username' => $record->username];
        return response()->json($data);
    }

    /**
     * 注册
     */
    public function register(Request $request, UserLogic $userLogic)
    {
        $token = $request->get('token');
        $data = $userLogic->validateUser($request->all());
        if(User::md5Pwd($request->get('pwd').$request->get('username'), 'juanzhuzhu') != $token) {
            $data['msg'] = 'token error!';
            return $data;
        }
        return response()->json($data);
    }

    /**
     * 添加淘宝登陆的用户
     */
    public function addTbUser(Request $request)
    {
        $data = ['msg' => '', 'status' => 0];
        $openId = $request->get('openid');
        $username = $request->get('username');
        if (!$openId || !trim($username)) {
            $data['msg'] = '用户名或opneid不能为空!';
            return response()->json($data);
        }

        $record = User::where('openid', $openId)->first();
        if ($record) {
            User::where('id', $record->id)->update(['lastLoginTime' => date('Y-m-d H:i:s')]);
            $user_id = $record->id;
        } else {
            $user_id = User::addOneUser($username, '123456', 2, $openId);
        }
        $data['msg'] = 'success!';
        $data['status'] = 1;
        $data['uid'] = $user_id;
        return response()->json($data);
    }

    /**
     * 获取用户信息
     */
    public function getUserInfo(Request $request)
    {
        $data = ['msg' => '', 'status' => 0];
        $user_id = intval($request->get('uid'));
        $token = $request->get('token');

        if (!$user_id) {
            $data['msg'] = 'params error!';
            return response()->json($data);
        }

        if ($token != md5(md5($user_id . 'juanzhuzhu'))) {
            $data['msg'] = 'token error!';
            return response()->json($data);
        }

        $userInfo = User::find($user_id);
        if (!$userInfo->id) {
            $data['msg'] = 'user not exsist!';
            return response()->json($data);
        }

        unset($userInfo->pwd);
        unset($userInfo->user_role);
        $data['data'] = $userInfo;
        $data['status'] = 1;
        return response()->json($data);
    }

    /**
     * 获取我的积分
     */
    public function getMyScore(Request $request){
        $data = ['msg' => '', 'status' => 0, 'data'=>[]];
        $user_id = intval($request->get('uid'));
        $token = $request->get('token');

        if (!$user_id) {
            $data['msg'] = 'params error!';
            return response()->json($data);
        }

        if ($token != md5(md5($user_id . 'juanzhuzhu'))) {
            $data['msg'] = 'token error!';
            return response()->json($data);
        }

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
        $data['status'] = 1;
        return response()->json($data);
    }
}