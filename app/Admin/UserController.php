<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2017/9/21
 * Time: 下午9:23
 */
namespace App\Admin;

use App\Model\Friend;
use App\Model\User;
use Illuminate\Http\Request;
use DB;

class UserController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();

        $this->checkAdminLogin();
    }

    /**
     * add user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addUser(Request $request)
    {
        if (!$_POST) {
            return view('admin.index.addUser');
        } else {
            $username = $request->get('username');
            $pwd = $request->get('pwd');
            $password = $request->get('password');
            if($pwd !=$password){
                return $this->error('两次密码不一致！');
            }
            if(DB::table('admin')->where('username', $username)->first()){
                return $this->error('用户名已存在！');
            }

            $status = DB::table('admin')->insert([
                'username' => $username,
                'pwd' => User::md5Pwd($pwd, 2),
                'addtime' => date('Y-m-d H:i:s'),
                'ip' => '',
            ]);
            if( false === $status ) return $this->error('网络异常，稍后再试！');

            return $this->success('添加成功！');
        }
    }

    /**
     * user list
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function userList()
    {
        $data['data'] = DB::table('admin')->where('status', '>', 0)->paginate(10);
        $data['page'] = $data['data']->render();
        $data['role'] = [1 => '管理员', 2 => '普通用户'];
        $data['status'] = [1 => '正常', 2 => '删除', 3 => '过期', 4 => '账号异常'];

        return view('admin.index.userList', $data);
    }

    /**
     * 修改密码
     * @param Request $request
     */
    public function editPass(Request $request)
    {
        $id = $request->get('id');
        if($id !=$_COOKIE['uid']){
            return $this->error('非法请求！', '/admin/login');
        }
        if ('GET' == $request->method()){
            return view('admin.user.editPass');
        }else{
            $newpass = $request->get('newpass');
            $renewpass = $request->get('renewpass');

            if(!$newpass || !$renewpass){
                return $this->error('新密码或确认密码不能为空！');
            }
            if($newpass !=$renewpass){
                return $this->error('两次密码不一致！');
            }

            $objAdmin = DB::table('admin')->where('status', 1)->where('id', $id);
            if(!$objAdmin->first()){
                return $this->error('用户不存在或已被删除！');
            }
            if(false ===$objAdmin->update(['pwd'=>User::md5Pwd($newpass, 2)])){
                return $this->error('网络异常，稍后再试！');
            }

            return $this->success('修改成功！');
        }
    }

    /**
     * 用户管理列表
     */
    public function lists()
    {
        $data = [];
        $arrUser = User::orderBy('id', 'desc')->paginate(10);
        if (count($arrUser) > 0) {
            foreach ($arrUser as $user) {
                $data['data'][] = $user->formatUserList($user);
            }
        }
        $data['page'] = $arrUser->render();

        // 模版参数
        $data['type'] = User::arrRegisterType();
        $data['arrStatus'] = [1=>'正常', 2=>'已删除',3=>'已过期', 4=>'账号异常'];

        return view('admin.user.lists', $data);
    }

    /**
     * 删除用户
     */
    public function delUser(Request $request)
    {
        $id = $request->get('id');
        $status = $request->get('status');
        $user = User::find($id);
        if ($user->id) {
            $user->status = $status;
            if (false === $user->save()) {
                return response()->json(['status' => 0, 'info' => '网络异常，稍后再试！']);
            }
        }

        return response()->json(['status' => 1, 'info' => 'success']);
    }

    /**
     * 邀请列表
     */
    public function friendList()
    {
        $arrFriend = Friend::selectRaw('count(new_user_id) as total,user_id')->where('user_id', '>', 0)->groupBy('user_id')->orderBy('total', 'desc')->paginate(6);
        if (count($arrFriend) > 0) {
            foreach ($arrFriend as $friend) {
                $data['data'][] = $friend->formatAdminUser($friend);
            }
        }

        $data['page'] = $arrFriend->render();

        return view('admin.user.friendList', $data);
    }

    /**
     * 邀请明细
     */
    public function friendDetail(Request $request)
    {
        $user_id = $request->get('user_id');
        $arrFriend = Friend::where('user_id', $user_id)->orderBy('id', 'desc')->get();
        if (count($arrFriend) > 0) {
            foreach ($arrFriend as $friend) {
                $data['data'][] = $friend->formatAdminFriendDetail($friend, 2);
            }
        }

        return view('admin.user.friendDetail', $data);
    }

    /**
     * 添加话费奖励
     */
    public function addReward(Request $request)
    {
        $user = User::find(intval($request->get('user_id')));
        if (!$user->id) {
            return response()->json(['status' => 0, 'info' => '用户不存在或被删除！']);
        }
        $user->reward = 1;
        if (false === $user->save()) {
            return response()->json(['status' => 0, 'info' => '网络异常，稍后再试！']);
        }
        return response()->json(['status' => 1, 'info' => '操作成功！']);
    }

    /**
     * 签到列表
     */
    public function signList()
    {
        $arrUser = User::where('is_sign_7', 1)->paginate(10);
        if (count($arrUser) > 0) {
            $regiserType = User::arrRegisterType();
            foreach ($arrUser as $user) {
                $data['data'][] = [
                    'username' => $user->username,
                    'register_type' => $regiserType[$user->type] ?: '',
                    'reward' => $user->is_sign_7,
                    'time' => date('Y-m-d H:i', strtotime($user->created_at)),
                    'id' => $user->id,
                ];
            }
        }

        $data['page'] = $arrUser->render();

        return view('admin.user.signList', $data);
    }

    /**
     * 修改签到奖励状态
     * @param Request $request
     */
    public function editSignReward(Request $request)
    {
        $user = User::find(intval($request->get('user_id')));
        if (!$user->id) {
            return response()->json(['status' => 0, 'info' => '用户不存在或被删除！']);
        }
        $user->is_sign_7 = 1;
        if (false === $user->save()) {
            return response()->json(['status' => 0, 'info' => '网络异常，稍后再试！']);
        }
        return response()->json(['status' => 1, 'info' => '操作成功！']);
    }

}