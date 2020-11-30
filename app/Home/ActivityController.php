<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2017/8/21
 * Time: 下午10:12
 * 活动类
 */
namespace App\Home;

use App\Model\Friend;
use App\Service\QqService;
use Illuminate\Http\Request;

class ActivityController extends BaseController
{
    /**
     * WAP - 下单送话费
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function order(Request $request)
    {
        $is_login_qq = intval($request->get('is_login_qq'));
        $user_id = intval($request->get('user_id'));

        // 是否已经qq授权
        $redirect_uri = __ROOT__.'/home/activity/order?is_login_qq=1&user_id='.$user_id;
        $qqService = new QqService();
        if(!$is_login_qq){
            header('location:'.$qqService->getQqLoginUrl(urlencode($redirect_uri)));die;
        }

        // 规则声名
        $data['rule'] = [
            '本活动仅通过此页面首次注册的新用户参与。',
            '本活动每人仅限参与一次。同一手机号／微信号／移动设备视为同一用户。严禁作弊，一经发现，扣除奖励和取消资格。',
            '本次活动有任何疑问可资讯优券客服，客服微信：CC379624432。',
            '以上活动卷猪科技拥有最终解释权。本活动与苹果公司无关。',
        ];

        $data['title'] = '下单送话费-卷猪';

        return view('home.activity.order', $data);
    }

    /**
     * 邀请好友赢话费
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function friend(Request $request)
    {
        $user_id = $request->get('user_id');
        $share = $request->get('share');
        if(1==$share){
            header('location:/home/activity/order?user_id='.$user_id);exit;
        }

        // 模版参数
        $data['reward'] = [10 => [0,2], 30 => [3,4], 50 => [5,6], 100 => [7,10]];
        $data['num'] = ['success' => 0, 'shengyu' => 0, 'money' => 10];
        if ($user_id) {
            $arrFriend = Friend::where('user_id', $user_id)->get();
            if (count($arrFriend) > 0) {
                foreach ($arrFriend as $friend) {
                    $data['friend'][] = $friend->formatQQList($friend);
                    1 == $friend->status && $data['num']['success']++;
                }
            }
        }
        // 查看奖励区间
        foreach ($data['reward'] as $m => $arrNum) {
            if($data['num']['success'] >= $arrNum[0] && $data['num']['success'] <= $arrNum[1]){
                $data['num']['money'] = $m;
                $data['num']['shengyu'] = $arrNum[1] - $data['num']['success'];
                break;
            }
        }
        $data['title'] = '邀请好友赢话费-卷猪';

        return view('home.activity.friend', $data);
    }

    /**
     * 数钱转发活动
     */
    public function money()
    {
        return view('home.activity.money');
    }

    /**
     * 邀请绑定展示页
     * author chengcong
     */
    public function binding()
    {
        $data['title'] = '领取大额优惠券-卷猪';
        $data['down_url'] = __ROOT__.'/down';

        return view('home.activity.binding', $data);
    }

    /**
     * 绑定手机-注册资格
     * author chengcong
     */
    public function bindTel(Request $request)
    {
        $tel = trim($request->get('tel'));
        $user_id = intval($request->get('user_id'));

        if (!$tel || !preg_match('/^1[34578]{1}\d{9}$/', $tel)) {
            return response()->json(['status' => 0, 'info' => '手机号格式错误！']);
        }
        $record = Friend::where('openid', $tel)->first();
        if(!$record->id){
            Friend::insert([
                'user_id' => $user_id,
                'openid' => $tel,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        return response()->json(['status' => 1, 'info' => 'success!']);
    }

}