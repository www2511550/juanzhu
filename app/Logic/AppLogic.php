<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2017/9/24
 * Time: 下午12:48
 */
namespace App\Logic;


use App\Model\Banner;
use App\Model\Config;
use App\Model\Friend;
use App\Model\News;
use App\Model\Sign;

class AppLogic
{

    /**
     * 获取首页banner
     */
    public function getIndexBanner()
    {
        $data = [];
        $arrBanner = Banner::where('status', 1)->orderBy('sort', 'desc')->take(5)->get();
        if(count($arrBanner) > 0){
            foreach ($arrBanner as $banner){
                $data[] = [
                    'title' => $banner->title,
                    'img_url' => __ROOT__.'/'.$banner->img_url,
                    'url' => $banner->to_url,
                ];
            }
        }

        return $data;
    }

    /**
     * 获取优券头条信息
     */
    public function getNewsData()
    {
        $data = [];
        $arrNews = News::where('status', 1)->take(5)->get();
        if (count($arrNews) > 0) {
            foreach ($arrNews as $news) {
                $data[] = [
                    'title'=>$news->title,
                    'url'=>$news->getNewsUrl($news->id),
                ];
            }
        }

        return $data;
    }


    /**
     * 获取签到基本信息
     * @param $user_id
     */
    public function getSignInfo($user_id)
    {
        $data = ['continue_day' => 0, 'day' => []];

        $signData = Sign::where('user_id', $user_id)->where('day', '>', date('Ymd', strtotime(' -1 month')))->orderBy('day', 'desc')->get()->toArray();
        if(count($signData) > 1){
            foreach ($signData as $key => $sign){
                if($key > 0){
                    $between_day = (strtotime($signData[$key-1]['day']) - strtotime($sign['day']))/(3600*24);
                    if($between_day >= 2 && 0 == $data['continue_day'] ){
                        $data['continue_day'] = $key;
                    }
                }
                $data['day'][] = (string)$sign['day'];
            }
            0 == $data['continue_day'] && $data['continue_day'] = count($signData);
        }else{
            $data['continue_day'] = count($signData);
        }

        return $data;
    }

    /**
     * qq邀请好友活动绑定
     * @param $openid
     * @param $user_id
     */
    public function activityFriend($openid, $user_id)
    {
        if ($openid && $user_id) {
            // 好友邀请记录插入数据
            $friend = Friend::where('openid', $openid)->where('status', 0)->first();
            if($friend->id){
                $friend->new_user_id = $user_id;
                $friend->status = 1;
                $friend->save();
            }
        }
    }


    /**
     * 获取详细页接口数据
     * @param $coupon
     */
    public function getDetailData($coupon, $taobaoLogic)
    {
        $data = [];
        if ($coupon->id) {
            $data['id'] = (string)$coupon->id;
            $data['goods_id'] = $coupon->GoodsID;
            $data['pid'] = Config::get('pid');
            $data['title'] = $coupon->Title;
            $data['intro'] = $coupon->Introduce;
            $data['price'] = $coupon->Price == intval($coupon->Price) ? intval($coupon->Price) : $coupon->Price;
            $data['img_url'] = $coupon->Pic . '_200x200.jpg';
            $data['is_tmall'] = (string)$coupon->IsTmall;
            $data['quan_price'] = $coupon->Quan_price;
            $data['is_new'] = '1';
            $data['sale_num'] = (string)$coupon->Sales_num;
            $data['coupon_url'] = $coupon->getQuanUrl($coupon);
            if (!$coupon->taokouling) {
                $data['taokouling'] = $taobaoLogic->taokouling($data['coupon_url'], $coupon->Title, $coupon->Pic . '_150x150.jpg', 1);
            } else {
                $data['taokouling'] = $coupon->taokouling;
            }
            $data['share_text'] = '【' . $coupon->Title . '】
【在售价' . $coupon->Price . '元，券后限时秒杀价' . ($coupon->Price - $coupon->Quan_price) . '元】
' . $coupon->Introduce . '【赠运费险】
复制这条信息，打开手机淘宝即可直接购买' . $data['taokouling'];

        }

        return $data;
    }



}