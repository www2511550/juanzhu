<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2017/10/15
 * Time: 下午10:04
 */
namespace App\Api;

use App\Logic\AppLogic;
use App\Model\Config;
use App\Model\Sign;
use Illuminate\Http\Request;

class SignController extends BaseController
{

    /**
     * 签到首页
     * @param Request $request
     */
    public function index(Request $request, AppLogic $appLogic)
    {
        $data = ['status' => 0, 'info' => ''];
        $user_id = $request->get('user_id');

        if (!$user_id) {
            $data['info'] = '参数异常！';
            return response()->json($data);
        }

        $data['data']['wx'] = Config::get('activity_wx') ?: 'wxgaogao';
        if(Sign::where('user_id', $user_id)->where('day', date('Ymd'))->first()){
            $data['data']['title'] = '今日已签到！';
        }else{
            Sign::insert([
                'user_id' => $user_id,
                'day' => date('Ymd'),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            $data['data']['title'] = '签到成功！';
        }


        // 获取连续签到天数
        $signInfo = $appLogic->getSignInfo($user_id);
        $data['data']['day'] = $signInfo['day'];
        $continue_day = intval($signInfo['continue_day']);
        $shengyu_day = 7 - $continue_day;
        $data['data']['min_title'] = '已连签' . $continue_day . '天' . ($shengyu_day > 0 ? ' 再签' . $shengyu_day . '天可领现金红包' : '');
        $data['data']['gift_day'] = date('Ymd', strtotime($shengyu_day.' day'));
        // 签到规则说明
        $data['data']['rule'] = [
            ['title1' => '即日起至12月30日签到满七天', 'title2' => '可获得现金红包3.88元'],
            ['title1' => '签到满七天后，请添加微信' . $data['data']['wx'], 'title2' => '提交注册优券的手机号领红包'],
        ];
        $data['data']['continue_day'] = $continue_day;
        // 注
        $data['data']['note'] = '每台设备只有一次机会，作弊违规不奖励哦';

        $data['status'] = 1;

        return response()->json($data);
    }

    /**
     * 签到
     * @param Request $request
     */
    public function doSign(Request $request)
    {
        $user_id = $request->get('user_id');
        $day = $request->get('day');
        $token = $request->get('token');

        // 参数校验
        if (!$user_id || !$day || !$token) {
            return response()->json(['status' => 0, 'info' => '参数异常！']);
        }
        if ($token != md5(md5('youquan' . $user_id . date('Ymd', strtotime($day))))) {
            return response()->json(['status' => 0, 'info' => 'token错误！']);
        }
        if (strtotime($day) != strtotime(date('Y-m-d'))) {
            return response()->json(['status' => 0, 'info' => '非法操作！']);
        }

        // 签到存储
        $intDay = date('Ymd');
        if (!Sign::where('user_id', $user_id)->where('day', $intDay)->first()) {
            $status = Sign::insert([
                'user_id' => $user_id,
                'day' => $intDay,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            if (false === $status) {
                return response()->json(['status' => 0, 'info' => '网络异常，稍后再试！']);
            }

            return response()->json(['status' => 1, 'info' => '签到成功！']);
        } else {

            return response()->json(['status' => 1, 'info' => '']);

        }


    }


}