<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2017/10/9
 * Time: 下午10:34
 */
namespace App\Api;

use App\Logic\AppLogic;
use App\Model\Collect;
use App\Model\Friend;
use App\Model\News;
use App\Model\Sms;
use App\Model\User;
use App\Service\QqService;
use App\Service\SmsService;
use Illuminate\Http\Request;

class UserController extends BaseController
{

    /**
     * 登陆
     */
    public function login(Request $request, AppLogic $appLogic)
    {
        $data = ['status'=>0, 'info'=>''];
        // 1、基本参数
        $openid = $request->get('openid');  // 开放平台id
        $cover = $request->get('cover') ?: '';  // 第三方头像
        $type = $request->get('type'); // 登陆方式，1-手机号，2-微信，3-qq，4-微博，5-淘宝
        $mobile_id = $request->get('mobile_id') ?: ''; // 设备号
        $tel = trim($request->get('tel')); // 手机号
        $pwd = $request->get('pwd'); // 密码


        // 2、账号验证
        if($tel){
            // 2-1、手机号登陆
            $user = User::where('tel',$tel)->first();
            if(!$user->id){
                $data['info'] = '账号不存在！';
                return response()->json($data);
            }
            if($user->pwd != User::md5Pwd($pwd)){
                $data['info'] = '密码错误！';
                return response()->json($data);
            }
            // 更新登陆时间
            User::where('id', $user->id)->update(['updated_at'=>date('Y-m-d H:i:s')]);

        }else{
            // 2-2、第三方登陆
            if (!$openid && !$type) {
                $data['info'] = '第三方登录参数异常！';
                return response()->json($data);
            }

            $user = User::where('openid', $openid)->first();
            if(!$user->id){
                // 注册为新用户
                $insertData['username'] = 'yq'.rand(100,999).rand(100,999).rand(1,9);
                $insertData['pwd'] = rand(100000, 999999);
                $insertData['tel'] = '';
                $insertData['cover'] = $cover;
                $insertData['user_role'] = 1; // 1、普通用户，2-代理
                $insertData['type']  = $type;
                $insertData['openid']  = $openid;
                $insertData['mobile_id']  = $mobile_id;
                $insertData['created_at']  = date('Y-m-d H:i:s');
                $insertId = User::insertGetId($insertData);
                if(!$insertId){
                    $data['info'] = '登陆失败，稍后再试！';
                    return response()->json($data);
                }
                // 用户信息
                $userInfo = ['username'=>$insertData['username'], 'id'=>$insertId, 'cover'=>$cover];
            }
            if (3 == $type) {
                $user_id = $user->id ?: $userInfo['id'];
                // QQ登陆查询是否通过邀请送话费过来
                $appLogic->activityFriend($openid, $user_id);
            }

        }

        // 3、用户基本信息
        if($user){
            $data['userInfo']['username'] = $user->username;
            $data['userInfo']['id'] = $user->id;
            $data['userInfo']['cover'] = $user->cover?:'';
        }else{
            $data['userInfo'] = $userInfo;
        }

        $data['status'] = 1;
        return response()->json($data);

    }

    /**
     * 注册
     */
    public function register(Request $request)
    {
        $data = ['status'=>0, 'info'=>''];
        // 1、基本参数
        $tel = $request->get('tel');
        $code = $request->get('code');
        $pwd = $request->get('pwd');

        // 2、基础验证
        if(!$tel || !preg_match('/^1[34578]{1}\d{9}$/', $tel)){
            $data['info'] = '手机号码错误！';
            return response()->json($data);
        }
        if(!$code || 5 != strlen($code)){
            $data['info'] = '验证码错误！';
            return response()->json($data);
        }
        $sms = Sms::where('tel', $tel)->where('type', 1)->orderBy('id', 'desc')->first();
        if(!$sms->id){
            $data['info'] = '手机号未发送验证码！';
            return response()->json($data);
        }
        if($code != $sms->code){
            $data['info'] = '验证码错误！';
            return response()->json($data);
        }
        if(!$pwd || strlen($pwd)<5){
            $data['info'] = '密码长度需要6位以上！';
            return response()->json($data);
        }
        $user = User::where('tel', $tel)->first();
        if($user->id){
            $data['info'] = '手机号已被注册！';
            return response()->json($data);
        }

        // 3、注册为新用户
        $insertId = User::addOneUser($tel, $pwd);
        if(!$insertId){
            $data['info'] = '注册失败，稍后再试！';
            return response()->json($data);
        }

        $data['status'] = 1;
        return response()->json($data);
    }

    /**
     * 验证码确认
     */
    public function checkCode(Request $request)
    {
        $tel = $request->get('tel');
        $code = $request->get('code');
        $type = $request->get('type', 1);

        if (!$tel || !$code) {
            return response()->json(['status' => 0, 'info' => '参数异常！']);
        }
        if (!preg_match('/^1[34578]{1}\d{9}$/', $tel)) {
            return response()->json(['status' => 0, 'info' => '手机号码格式错误！']);
        }
        $sms = Sms::where('tel', $tel)->where('type', $type)->orderBy('id', 'desc')->first();
        if (!$sms->id) {
            return response()->json(['status' => 0, 'info' => '手机号未发送验证码！']);
        }
        if ($code != $sms->code) {
            return response()->json(['status' => 0, 'info' => '验证码错误！']);
        }

        return response()->json(['status' => 1, 'info' => 'success！']);

    }
    /**
     * 获取用户信息
     * author chengcong
     */
    public function info(Request $request, AppLogic $appLogic)
    {
        $user_id = $request->get('user_id');
        $token = $request->get('token');

        if (!$user_id) {
            return response()->json(['status' => 0, 'info' => '参数异常！']);
        }
        if ($token != md5(md5('youquan' . $user_id))) {
            return response()->json(['status' => 0, 'info' => 'token错误！']);
        }

        $info = User::where('id', $user_id)->where('status', 1)->first();
        if (!$info->id) {
            return response()->json(['status' => 0, 'info' => '用户不存在或已删除！']);
        }
        // 获取连续签到天数
        $signInfo = $appLogic->getSignInfo($user_id);
        $data = [
            'username'=>$info->username,
            'score'=>$info->score,
            'cover'=>$info->cover ?: 'https://www.591.com.tw/images/index/userCenter/medium/no-head.png',
            'sign_day'=>intval($signInfo['continue_day']),
        ];

        return response()->json(['status' => 1, 'info' => '', 'data'=>$data]);
    }

    /**
     * 发送短信
     * @param Request $request
     */
    public function sendMsg(Request $request)
    {
        $data = ['status' => 0, 'info' => ''];
        $mobile = trim($request->get('tel'));
        $type = $request->get('type', 1);

        if (!preg_match('/^1[34578]{1}\d{9}$/', $mobile)) {
            $data['info'] = '手机号格式错误！';
        } else {
            // 验证码一天只能发送三次
            if($sms = Sms::where('tel', $mobile)->where('type', $type)->whereBetween('created_at', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])->count() > 3){
                $data['info'] = '短信发送失败，稍后再试！!';
                return response()->json($data);
            }

            $smsService = new SmsService();
            $code = rand(10000, 99999);
            if($smsService->send($mobile, $code, $type)){
                // 存储验证码
                Sms::insert([
                    'tel' => $mobile,
                    'code' => $code,
                    'type' => $type,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);

                $data['info'] = 'success!';
                $data['status'] = 1;
            }else{
                $data['info'] = '短信发送失败，稍后再试！!';
            }
        }

        return response()->json($data);
    }

    /**
     * 我的收藏
     */
    public function myCollect(Request $request)
    {
        $data = ['status'=>1, 'info'=>'', 'data'=>[]];
        $user_id = intval($request->get('user_id'));

        if($user_id <= 0){
            return ['status'=>0, 'info'=>'请登录！'];
        }

        $collect = Collect::where('user_id', $user_id)->where('status', 1)->paginate(10);
        if(count($collect)){
            foreach ($collect as $vo){
                $news = News::find($vo->news_id);
                if ($news->id){
                    $data['data'][] = $news->formatNewsList($news);
                }
            }

        }

        return response()->json($data);
    }

    /**
     * 绑定qq好友
     * @param Request $request
     */
    public function addFriend(Request $request)
    {
        // 1、参数
        $code = $request->get('code');
        $state = $request->get('state');
        $user_id = $request->get('user_id');

        // 2、参数校验
        if (!$code || 'status' != $state) {
            return response()->json(['status' => 0, 'info' => '非法请求！']);
        }

        $qqService = new QqService();
        // 3-1、获取access_token
        $access_token = $qqService->getAccessToken($code, 'test.juanzhuzhu.com');
        if(!$access_token){
            return response()->json(['status' => 0, 'info' => '授权失败，请重新登陆qq！']);
        }
        // 3-2、获取opendid
        $openid = $qqService->getOpenid($access_token);
        if(!$openid){
            return response()->json(['status' => 0, 'info' => '授权失败，请重新登陆qq！']);
        }
        // 3-3、qq是否已注册
        if(User::where('openid', $openid)->first()){
            return response()->json(['status' => 0, 'info' => 'qq号已被注册！']);
        }

        // 4、存储数据
        if(!Friend::where('user_id', $user_id)->where('openid',$openid)->first()){
            $status = Friend::insert([
                'user_id' => $user_id,
                'openid' => $openid,
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ]);
            if(false === $status){
                return response()->json(['status'=>0, 'info'=>'领取失败，稍后再试！']);
            }
        }

        return response()->json(['status'=>1, 'info'=>'success!', 'down_url'=>__ROOT__.'/down']);

    }

    /**
     * 重置密码
     */
    public function resetPwd(Request $request)
    {
        $tel = $request->get('tel');
        $code = $request->get('code');
        $pwd = $request->get('pwd');

        if (!$tel || !$code) {
            return response()->json(['status' => 0, 'info' => '参数异常！']);
        }
        if (!preg_match('/^1[34578]{1}\d{9}$/', $tel)) {
            return response()->json(['status' => 0, 'info' => '手机号格式错误！']);
        }
        if(!$pwd || strlen($pwd)<5){
            return response()->json(['status' => 0, 'info' => '密码长度需要6位以上！']);
        }
        $sms = Sms::where('tel', $tel)->where('type', 2)->orderBy('id', 'desc')->first();
        if(!$sms->id){
            return response()->json(['status' => 0, 'info' => '手机号未发送验证码！']);
        }
        if($code != $sms->code){
            return response()->json(['status' => 0, 'info' => '验证码错误！']);
        }
        $user = User::where('tel', $tel)->where('status', 1)->first();
        if(!$user->id){
            return response()->json(['status' => 0, 'info' => '该手机号未注册！']);
        }

        $user->pwd = User::md5Pwd($pwd);
        if(false === $user->save()){
            return response()->json(['status' => 0, 'info' => '网络异常，稍后再试！']);
        }

        return response()->json(['status' => 1, 'info' => '密码修改成功！']);
    }

    /**
     * 添加代理
     * @param Request $request
     */
    public function addAgent(Request $request){

    }

}