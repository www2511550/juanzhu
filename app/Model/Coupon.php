<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 17/4/28
 * Time: 下午11:09
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    /**
     * 与模型关联的数据表。
     * @var string
     */
    protected $table = 'coupon';

    /**
     * 指定是否模型应该被戳记时间。
     *
     * @var bool
     */
    public $timestamps = true;

    public static function getImgUrl($pic_url, $from = '')
    {
        if('wx' == $from){
            if((strpos($pic_url, 'img.alicdn.com') || strpos($pic_url, 'gd1.alicdn.com'))&& substr($pic_url, -1) == 'g'){
                $pic_url .= '_250x250.jpg';
            }
        }else{
            if(0 === strpos($pic_url, '//')){
                $pic_url = 'https:' . $pic_url;
            }
            if(!strpos($pic_url, 'huim.com')){
                if($num = strpos($pic_url, '.jpg_')){
                    $pic_url = substr($pic_url,0,$num).'.jpg';
                }
            }
        }


        return  $pic_url;
    }

    /**
     * 格式化列表页数据
     * @param $coupon
     */
    public function formatApiData($coupon)
    {
        $data = [];

        $data['id'] = (string)$coupon->id;
        $data['goods_id'] = $coupon->GoodsID;
        $data['pid'] = Config::get('pid');
        $data['title'] = $coupon->Title;
        $data['intro'] = $coupon->Introduce;
        $data['price'] = $coupon->Price == intval($coupon->Price) ? intval($coupon->Price) : $coupon->Price;
        $data['img_url'] = self::getImgUrl($coupon->Pic). '_200x200.jpg';
        $data['is_tmall'] = (string)$coupon->IsTmall;
        $data['quan_price'] = $coupon->Quan_price;
        $data['is_new'] = '1';
        $data['sale_num'] = (string)$coupon->Sales_num;
        $data['coupon_url'] = $coupon->getQuanUrl($coupon);

        return $data;
    }

    /**
     * 格式化列表页接口
     * @param $val
     */
    public function formatApilistData($val, $type = 'detail')
    {
        $data = [];
        if ($val) {
            $data['id'] = $val->id;
            $data['title'] = $val->Title;
            $data['price'] = $val->Price;
            $data['img_url'] = $val->Pic;
            $data['is_tmall'] = $val->IsTmall;
            $data['quan_price'] = $val->Quan_price;
            $data['is_new'] = 1;
            $data['coupon_url'] = $data['detail_url'] = $val->getQuanUrl($val, $type);
        }
        return $data;
    }

    /**
     * 拼接优惠卷链接
     * @param $data
     */
    public function getQuanUrl($val, $type = '', $user_id = 0)
    {
        if ('detail' == $type) {
            $quanUrl = 'http://juanzhuzhu.com/home/wap/detail?id=' . $val['id'];
        }elseif('pc_detail' == $type){
            $quanUrl = route('index.detail', ['id'=>$val['id']]);
        } else {
            if ($val['Quan_id'] && $val['GoodsID']) {
                if($user_id && $agent_pid = User::where('id', $user_id)->where('status', 1)->where('user_role', 2)->value('pid')){
                    $pid = $agent_pid;
                }else{
                    $pid = Config::get('pid');
                }
                $quanUrl = 'https://uland.taobao.com/coupon/edetail?activityId=' . $val['Quan_id'] . '&itemId=' . $val['GoodsID'] . '&pid=' . $pid;
            }else{
                $quanUrl = $val['Quan_link'];
            }
        }
        return $quanUrl;
    }

    /**
     * 设置并获取浏览历史
     * @param $coupon
     */
    public function getHistory($coupon)
    {
        $history = [];
        if ($curData[] = $coupon->toArray()) {
            $strCookie = 'history';
            $history = json_decode(cookie($strCookie), true);
            $history && $history = array_merge($history, $curData);
            cookie($strCookie, json_encode($history), 7 * 24 * 60);
        }
        return $history;
    }

    /**
     * 格式化微信小程序商品列表数据
     */
    public function formatWxapp($vo, $type = 'wx')
    {
        $data = [];

        $data['id'] = $vo->id;
        $pic = self::getImgUrl($vo->Pic, $type);
        $data['pic_url'] = str_replace("g_400x400", "g_200x200", $pic);
        $data['title'] = $vo->Title;
        $data['price_info'] = $vo->Price;
        $data['subtitle'] = $vo->Introduce;
        $data['sale_num'] = $vo->Sales_num;
        $data['quan_price'] = $vo->Quan_price;
        return $data;
    }

    /**
     * 格式化微信公众号图文回复
     * @param $coupon
     */
    public function formatWxRepley($coupon)
    {
        return [
            'price' => $coupon->Price == intval($coupon->Price) ? intval($coupon->Price) : $coupon->Price,
            'title' => $coupon->Title ?: '',
            'desc' => $coupon->Introduce ?: ($coupon->Title ?: ''),
            'pic' => $coupon->Pic,
            'to_url' => $this->getQuanUrl($coupon, 'detail'),
        ];
    }

}