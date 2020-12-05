<?php
/**
 * Created by PhpStorm.
 * User: 10574
 * Date: 2018/5/16
 * Time: 18:27
 */

namespace App\Logic;

use App\Model\Url;
use App\Model\UrlDayCount;
use App\Service\HaodankuService;
use App\Service\ToolService;
use DB;

class UrlLogic
{
    /**
     * 获取该条记录的自增ID
     * 将自增转换为62进制，并拼接网址 如：http://qetee.com/w7e
     * 用户访问到 http://qetee.com/w7e 时，提取短网址后缀 w7e
     * 将短网址后缀转换为10进制，得到自增ID号 如：123456
     * 使用查询该记录，进行业务逻辑处理(比如跳转)
     *
     * 十进制数转换成62进制
     *
     * @param integer $num
     * @return string
     */
    function from10_to62($num) {
        $to = 62;
        $dict = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $ret = '';
        do {
            $ret = $dict[bcmod($num, $to)] . $ret;
            $num = bcdiv($num, $to);
        } while ($num > 0);
        return $ret;
    }

    /**
     * 62进制数转换成十进制数
     *
     * @param string $num
     * @return string
     */
    function from62_to10($num) {
        $from = 62;
        $num = strval($num);
        $dict = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $len = strlen($num);
        $dec = 0;
        for($i = 0; $i < $len; $i++) {
            $pos = strpos($dict, $num[$i]);
            $dec = bcadd(bcmul(bcpow($from, $len - $i - 1), $pos), $dec);
        }
        return $dec;
    }

    /**
     * 是否微博app内部打开
     * author chengcong
     */
    public function is_weibo_app()
    {
        if ($this->is_mobile()) {
            $useragent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
            return strpos($useragent, 'weibo') ? true : false;
        }
        return false;
    }

    /**
     * 手机端
     * @return bool
     * author chengcong
     */
    function is_mobile()
    {
        $useragent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        $useragent_commentsblock = preg_match('|\(.*?\)|', $useragent, $matches) > 0 ? $matches[0] : '';
        function CheckSubstrs($substrs, $text)
        {
            foreach ($substrs as $substr)
                if (false !== strpos($text, $substr)) {
                    return true;
                }
            return false;
        }

        $mobile_os_list = array('Google Wireless Transcoder', 'Windows CE', 'WindowsCE', 'Symbian', 'Android', 'armv6l', 'armv5', 'Mobile', 'CentOS', 'mowser', 'AvantGo', 'Opera Mobi', 'J2ME/MIDP', 'Smartphone', 'Go.Web', 'Palm', 'iPAQ');
        $mobile_token_list = array('Profile/MIDP', 'Configuration/CLDC-', '160×160', '176×220', '240×240', '240×320', '320×240', 'UP.Browser', 'UP.Link', 'SymbianOS', 'PalmOS', 'PocketPC', 'SonyEricsson', 'Nokia', 'BlackBerry', 'Vodafone', 'BenQ', 'Novarra-Vision', 'Iris', 'NetFront', 'HTC_', 'Xda_', 'SAMSUNG-SGH', 'Wapaka', 'DoCoMo', 'iPhone', 'iPod');

        $found_mobile = CheckSubstrs($mobile_os_list, $useragent_commentsblock) ||
            CheckSubstrs($mobile_token_list, $useragent);

        if ($found_mobile) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取短连接
     * @param $longUrl
     * @return array
     * author chengcong
     */
    public function getShortUrl($longUrl, $user_id)
    {
        // uland.taobao.com做二次转换
        if (strpos($longUrl, 'uland.taobao.com')>0 || strlen($longUrl) > 40){
            $arrShortUrl = (new ToolLogic())->getShortUrl($longUrl);
            $longUrl = isset($arrShortUrl['data']['url']) ? $arrShortUrl['data']['url'] : '';
        }

        $record = Url::where('long_md5', md5($longUrl))->first();
        $taobaoLogic = new TaobaoLogic();
        $base_short_url =  strpos(request()->getHost(), '51wz.com.cn') ? 'http://s.51wz.com.cn/' : 'http://s.juanzhuzhu.com/';//'http://t6b.top/';
        $coupon_img = 'http://juanzhuzhu.com/coupon.jpg';

        if ($record->id) {
            try{
                 // $strTkl = $taobaoLogic->taokouling($longUrl, '点我领购物券', $coupon_img, 1);
            }catch (\Exception $e){
                $strTkl = '';
            }
            return [
                'status' => 1,
                'data' => [
//                    'url' => route('url.go', ['url' => $record->key]),
                    'url' => $base_short_url . $record->key,
                    'tkl' => $strTkl,
                    'short_url' => $longUrl,
                ]
            ];
        } else {
            // 获取当前优惠券相关信息
            $money = 0;
            $selfUrl = '';
            try{
                // 计算当前链接的佣金
//                $toolService = new ToolService();
//                if ($goodsId = $toolService->sclicktoid($longUrl)){
//                    $haodankuService = new HaodankuService();
//                    $data = $haodankuService->search($goodsId);
//                    if (isset($data[0]) && isset($data[0]['itemendprice'])){
//                        $money = $data[0]['itemendprice'] * $data[0]['tkrates'] / 100;
//                    }
//                }

                // 转换为自己的高佣
                $arrSelfUrl = $this->getSelfUrl($longUrl);
                $selfUrl = isset($arrSelfUrl['coupon_short_url']) ? $arrSelfUrl['coupon_short_url'] : '';
            }catch (\Error $e){}

            $strKey = substr(md5($longUrl), -8);
            $insertId = Url::insertGetId([
                'key' => $strKey,
                'long_url' => $longUrl,
                'user_id' => $user_id,
                'long_md5' => md5($longUrl),
                'money' => $money,
                'self_url' => $selfUrl,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            if (false === $insertId) {
                return ['status' => 0, 'info' => '生成失败，稍后再试！'];
            }

            // 记录转换日志
            $this->addChangeRecord($insertId);

            try{
                // $strTkl = $taobaoLogic->taokouling($longUrl, '点我领购物券', $coupon_img, 1);
            }catch (\Exception $e){
                $strTkl = '';
            }
            return [
                'status' => 1,
                'data' => [
//                    'url' => route('url.go', ['url' => $strKey]),
                    'url' => $base_short_url . $strKey,
                    'tkl' => $strTkl,
                    'short_url' => $longUrl,
                ]
            ];
        }
    }

    /**
     * 记录转链接记录
     * @param $insertId
     */
    public function addChangeRecord($insertId)
    {
        $strIp = request()->getClientIp();
        $long_ip = ip2long($strIp);
        try{
            DB::table('url_log')->insert([
                'url_id' => $insertId,
                'ip' => $strIp,
                'long_ip' => $long_ip,
                'created_at' => time(),
            ]);
        }catch (\Exception $e){

        };

    }

    /**
     * url点阅统计
     * @param $urlInfo
     */
    public function urlDayCount($urlInfo)
    {
        if ($urlInfo->id) {
            $intDate = date('Ymd');
            $urlDayCount = UrlDayCount::where(['url_id' => $urlInfo->id, 'date' => $intDate])->first();
            if ($urlDayCount->id) {
                $urlDayCount->click_num += 1;
                $urlDayCount->save();
            } else {
                UrlDayCount::insert([
                    'url_id' => $urlInfo->id,
                    'click_num' => 1,
                    'date' => $intDate,
                ]);
            }
        }
    }

    /**
     * 高佣金转换
     * @param $strParam
     * @return array
     */
    public function getSelfUrl($strParam)
    {
//        $strCacheKey = 'highTransfer:' . $strParam;
//        if ($data = Cache::get($strCacheKey)) {
//            return $data;
//        }

        $url = 'http://api.vephp.com/hcapi?vekey=V00000836Y52123108&para=' . $strParam;
        $result = http($url, []);
        $result = json_decode($result, true);
        $data = isset($result['data']) ? $result['data'] : [];

//        Cache::put($strCacheKey, $data, 30 * 24 * 60);

        return $data;
    }

}