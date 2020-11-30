<?php
/**
 * 外接api，用于其他项目调用
 * User: chengcong
 * Date: 2018/7/29
 * Time: 上午11:23
 */
namespace App\Api;


use App\Logic\TaobaoLogic;
use Illuminate\Http\Request;
use Cache;

class ExtController extends BaseController
{
    /**
     * 查询优惠券信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function coupon(Request $request)
    {
        $goods_id = $request->get('goods_id', ''); // 商品id
        $quan_id = $request->get('quan_id', '');   // 券id
        $me = $request->get('me', '');       // 商品id+券id加密后字符串

        if (!($goods_id && $quan_id || $me)) {
            return response()->json(['info' => '参数缺失！', 'status' => 0]);
        }
        $taobaoLogic = new TaobaoLogic();
        $strKey = md5($goods_id.$quan_id.$me);
        $info = Cache::remember($strKey, 5, function () use($taobaoLogic,$goods_id,$quan_id,$me){
            return $taobaoLogic->couponInfo($goods_id, $quan_id, $me);
        });
        if (isset($info['code'])){
            if ($info['code'] == 15){
                $data = ['status'=>1, 'info'=>'优惠券已过期！'];
            }else{
                $data = ['status'=>0, 'info'=>'优惠券已删除！'];
            }
        }else{
            $data = ['status'=>2,'info'=>'ok!','data'=>[
                'amount' => $info['coupon_amount'],
                'start_fee' => $info['coupon_start_fee'],
                'remain' => $info['coupon_remain_count'],
                'total' => $info['coupon_total_count'],
                'start_time' => $info['coupon_start_time'],
                'end_time' => $info['coupon_end_time'],
                'src' => $info['coupon_src_scene'], // 券类型，1 表示全网公开券，4 表示妈妈渠道券
                'type' => $info['coupon_type'], // 券属性，0表示店铺券，1表示单品券
            ]];
        }


        return response()->json($data);
    }
}