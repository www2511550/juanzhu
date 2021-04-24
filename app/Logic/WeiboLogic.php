<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2017/9/12
 * Time: 下午9:53
 */
namespace App\Logic;
require app_path('../vendor/weibo-sdk/config.php');
require app_path('../vendor/weibo-sdk/saetv2.ex.class.php');

use DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class WeiboLogic{

    public function __construct()
    {
        // 白菜菜褥羊毛
        $this->appkey = '1187204498';
        $this->secret = '68ae3a57fcadfa840a53643d96c37a39';
        $this->appleid = '1238112219';
        $this->accessToken = '2.00TZqY1GeH52SB966d8781bbwOtjqC';
        $this->api = 'https://api.weibo.com/2/';
    }

    /**
     * 获取token
     */
//    public function getAccessToken(){
//        $s = new \SaeTOAuthV2($this->appkey, $this->secret);
//        $token = $s->getAccessToken('password', ['username'=>'chengcong0520@sina.cn', 'password'=>'a2511550']);
//        pre($token);die;
//    }
    /**
     * 发送微博
     * @return mixed
     */
    public function send($content, $img, $quanUrl)
    {
        $c = new \SaeTClientV2($this->appkey, $this->secret, $this->accessToken);
        // 待发送的文字内容
        $status = $content;
        // 本地一张图片，也可以不带图片
        $file_local = $img;
        // 拼接'http://weibosdk.sinaapp.com/'是因为这个share接口至少要带上一个【安全域名】下的链接。
        return $c->share($status . $quanUrl, $file_local);
    }

    /**
     * 生成微博短链接
     * @param $long_url
     */
    public function shortUrl($long_url, $type = '')
    {
        // 防微博屏蔽淘宝跳转
        // https://m.weibo.cn/feature/applink?scheme=sinaweibo://browser/close?scheme=sinaweibo://openadapp?scheme=tbopen://m.taobao.com/tbopen/index.html?h5Url=https://s.click.taobao.com/C9hKsqu&allowRedirect=1
        if ($type == 'toTb'){
//            $long_url = 'https://m.weibo.cn/feature/applink?scheme=sinaweibo%3A%2F%2Fbrowser%2Fclose%3Fscheme%3Dsinaweibo%253A%252F%252Fbrowser%253Furl%253Dhttp%25253A%25252F%25252F'.$long_url.'?%25252FPKUna0VG%2526allowRedirect%253D1%2526disable_sinaurl%253D1';
            $long_url = 'https://m.weibo.cn/feature/applink?scheme='.urlencode('sinaweibo://browser/close?scheme='.urlencode('sinaweibo://openadapp?scheme='.urlencode('tbopen://m.taobao.com/tbopen/index.html?h5Url='.urlencode($long_url)))).'&allowRedirect=1';
        }else{
            $long_url = urlencode($long_url);
        }

        return $this->tcn($long_url);
    }

    /**
     * 微博跳转淘宝，京东，拼多多等app
     * @param $url
     * @param $type
     */
    public function wbToApp($url, $type)
    {
        if ($type == 'jd') {
//            $long_url = 'https://m.weibo.cn/feature/applink?scheme=' . urlencode('sinaweibo://browser/close?scheme=' . urlencode('sinaweibo://openadapp?scheme=' . urlencode('openapp.jdmobile://virtual?params={"category":"jump","des":"m","url":"' . $url . '"}'))) . '&allowRedirect=1';
            $long_url = 'https://m.weibo.cn/feature/applink?scheme=' . urlencode('sinaweibo://browser/close?scheme=' . urlencode('sinaweibo://openadapp?scheme=' . urlencode('openapp.jdmobile://virtual?params='.urlencode('{"category":"jump","des":"m","url":"' . $url . '"}')))) . '&allowRedirect=1';
//            $long_url = 'https://h5.m.jd.com/dev/RLVegkgjdNJoM4Y1WsvAnKLD7Qw/index.html?appurl='.urlencode($url);
        } elseif ($type == 'pdd') {
//            $long_url = 'https://m.weibo.cn/feature/applink?scheme=' . urlencode('sinaweibo://browser/close?scheme=' . urlencode('sinaweibo://openadapp?scheme=' . urlencode('pinduoduo://com.xunmeng.pinduoduo/app.html?url=' . urlencode($url)))) . '&allowRedirect=1';
            // 拼多多跳转改版 2021-4-19
            $headers = get_headers($url, true);
            $location = $headers['Location'];
            $arrLocaiton = explode('?', $location);
            parse_str($arrLocaiton[1], $urlParams);
            $mainStr = 'goods_id='.$urlParams['goods_id'].'&pid='.$urlParams['pid'].'&goods_sign='.$urlParams['goods_sign'];
            $long_url = 'https://m.weibo.cn/feature/applink?scheme=sinaweibo://browser/close?scheme=sinaweibo://openadapp?scheme=pinduoduo://com.xunmeng.pinduoduo/duo_coupon_landing.html?'. $mainStr .'&duoduo_type=2&refer_page_name=duo_coupon_landing&allowRedirect=1';
        } else {
            $long_url = 'https://m.weibo.cn/feature/applink?scheme=' . urlencode('sinaweibo://browser/close?scheme=' . urlencode('sinaweibo://openadapp?scheme=' . urlencode('tbopen://m.taobao.com/tbopen/index.html?h5Url=' . urlencode($url)))) . '&allowRedirect=1';
//            $long_url = 'https://m.weibo.cn/feature/applink?scheme=' . urlencode('sinaweibo://browser/close?scheme=' . urlencode('sinaweibo://openadapp?scheme=' . urlencode('tbopen://m.taobao.com/tbopen/index.html?h5Url=' . urlencode($url).'&url=sinaweibo://browser?sinainternalbrowser=&url='.urlencode($url)))) . '&allowRedirect=1&disable_interception=1&disable_sinaurl=1&allowRedirect=1&show_type=2&allowRedirect=1';
        }


        $tcn = $this->tcn($long_url);
        if (!$tcn) {
            // 官方文档 https://home.suowo.cn/ucenter/api.htm
            $url = 'http://api.suowo.cn/api.htm';
            $params = [
                'url' => $long_url,
                'key' => '6010ce2f2782f5059f075384@bd3082395d9bc6c552bf1c3e7bf27170',
                'format' => 'json',
                'domain' => '4',
                'expireDate' => date('Y-m-d',strtotime('+1 year')), // 永久
            ];
            $ft12 = json_decode(http($url, $params), true);
            return $ft12['url'] ?: '';
        }

        return $tcn;
    }

    /**
     * 微博短链接
     */
    public function tcn($long_url)
    {
        $wb_short = '';

        // sinaurl接口
        $url = 'http://vip.kakuapi.com/sinaurl-1.php';
        $params = [
            'domain' => $long_url,
        ];
        $arrHeader = [
            'Host' => 'vip.kakuapi.com',
            'Referer' => 'http://vip.kakuapi.com/sinaurl.php',
            'User-Agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 11_0 like Mac OS X) AppleWebKit/604.1.38 (KHTML, like Gecko) Version/11.0 Mobile/15A372 Safari/604.1',
            '' => '',
        ];
        try {
            $result = json_decode(http($url, $params, 'POST', $arrHeader), true);
            if (isset($result['key']) && $result['key']) {
                $wb_short = $result['key'];
            }
        } catch (\Exception $e) {

        }
        if ($wb_short) return $wb_short;


        try{
            // 新浪微博短链接
            $url = 'http://www.f4cklangzi.cn/api/create.html';
            $params = [
                'original_url' => $long_url,
                'api_key' => '72188a037fddc44b59af79e360dfdc6d',
                'mode' => 3,
            ];
            $result = http($url, $params);
            $data = json_decode($result, true);
            $wb_short = isset($data['data']['short_url']) && $data['data']['short_url'] ? $data['data']['short_url'] : '';

            // 微博不能用，切换更换为百度短链接（欠费暂停使用）
//        if (!$wb_short){
//            $result =  $this->baiduShortUrl($long_url);
//            if ($result['Code'] === 0){
//                $wb_short = $result['ShortUrl'];
//            }
//        }
        }catch (\Exception $e){

        }

        return $wb_short;
    }

    /**
     * 百度短网址
     */
    public function baiduShortUrl($long_url)
    {
        $host = 'https://dwz.cn';
        $path = '/admin/v2/create';
        $url = $host . $path;
        $method = 'POST';
        $content_type = 'application/json';

        // TODO: 设置Token
        $token = '78e820ba3298cac7f2f9dee1678aa18e';

        // TODO：设置待注册长网址
        $bodys = array('Url' => urldecode($long_url), 'TermOfValidity' => '1-year');

        // 配置headers
        $headers = array('Content-Type:' . $content_type, 'Token:' . $token);

        // 创建连接
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($bodys));

        // 发送请求
        $response = curl_exec($curl);
        curl_close($curl);

        // 读取响应
        return json_decode($response, true);
    }
    /**
     * 微博评论
     * @param string $id
     * @param string $content
     * @return string
     */
    public function send_comment($id = '4236289291245004', $content = 'test')
    {
        $c = new \SaeTClientV2(WB_AKEY, WB_SKEY, WB_ACCESSTOKEN);
        return $c->send_comment($id, $content);
    }


    public function userWeibo(){
        $c = new \SaeTClientV2(WB_AKEY, WB_SKEY, WB_ACCESSTOKEN);

        return $c->home_timeline();
    }

    /**
     * 获取穿衣搭配微博内容->小号，只关注穿衣搭配
     */
    public function getFashionList()
    {
        $c = new \SaeTClientV2('3992193503', '8d5b67680fd30648b7ca6396816fe8cc', '2.00HDZIJHntpK3Ed9ebaa3dc7x2uX7E');
        return $c->repost_weekly();
        return $c->friends_timeline();
    }


    /**
     * 褥羊毛
     * @author cc 2018/9/24 16:24
     */
    public function sendYangMao(){
        $curTime  = date('H:i');
        $is_send = ($curTime >= '07:30' && $curTime <= '08:30') || ($curTime >= '12:00' && $curTime <= '13:00')
            || ($curTime >= '20:00' && $curTime <= '23:59') || ($curTime >= '00:01' && $curTime <= '01:30');
        if ($is_send || $_GET['send']){
            $record = DB::table('yangmao')->where('is_send_wb', 0)->orderBy('pulish_time', 'asc')->orderBy('id', 'desc')->first();
            if ($record){
                $content = $record->title;
                $quanUrl = 'http://juanzhuzhu.com/ym/'.$record->id.'.html';
                if (!trim($record->img)){
                    // 抓取内容最后一张图片
                    preg_match_all('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i',$record->content,$match);
                    $img_src = $match[2] ? array_pop($match[2]) : '';
                }else{
                    $img_src = $record->img;
                }
                // 抓取图片存到本地
                $imgPath = '';
                if ($img_src){
                    $imgPath = '1.jpg';
                    $imgContent = @file_get_contents($img_src);
                    file_put_contents($imgPath, $imgContent);
                }
                $result = $this->send($content, $imgPath, $quanUrl);
                if ($wbId = $result['id']){
                    DB::table('yangmao')->where('id', $record->id)->update(['is_send_wb'=>1]);
                    // 发表评论
                    $strComment = '亲测可薅，快速通道：'.$quanUrl;
                    $this->send_comment($result['id'], $strComment);
                }
            }
        }
        return $result['id'] ? 1 : 0;
    }

    /**
     * 微博发送
     */
    public function sendWeibo()
    {
        $curTime  = date('H:i');
        $is_send = ($curTime >= '07:30' && $curTime <= '09:00') || ($curTime >= '12:00' && $curTime <= '13:30') || ($curTime >= '17:50' && $curTime <= '19:30')
                || ($curTime >= '22:30' && $curTime <= '23:59') || ($curTime >= '00:01' && $curTime <= '02:00');
        if ($is_send) {
            // 抓取好券清单到redis
            //$coupon = DB::table('coupon')->where('Quan_time', '>=', date('Y-m-d H:i:s'))->whereIn('Cid', [1, 3, 6])->where('Jihua_shenhe', 0)->where('Price', '<=', 99)->orderByRaw('rand()')->first();
            $coupon = DB::table('coupon')->where('Quan_time', '>=', date('Y-m-d H:i:s'))->where('Cid', 3)
                ->where('Jihua_shenhe', 0)->where('Price', '<=', 399)->orderByRaw('rand()')->first();
            if (!$coupon->id){
                $coupon = DB::table('coupon')->where('Quan_time', '>=', date('Y-m-d H:i:s'))->whereIn('Cid', [1,8,10,11])
                    ->where('Jihua_shenhe', 0)->where('Price', '<=', 199)->orderByRaw('rand()')->first();
            }

            $coupon = DB::table('coupon')->orderByRaw('rand()')->first();

            if ($coupon) {
                // 抓取图片存到本地
                $imgPath = '1.jpg';
                $imgContent = @file_get_contents($coupon->Pic);
                file_put_contents($imgPath, $imgContent);

                // 优惠券地址
//                if ($coupon->Quan_id && $coupon->GoodsID) {
//                    $pid = 'mm_47800736_21362628_72092261';
//                    $quanUrl = 'https://uland.taobao.com/coupon/edetail?activityId=' . $coupon->Quan_id . '&itemId=' . $coupon->GoodsID . '&pid=' . $pid;
//                } else {
//                    $quanUrl = $coupon->Quan_link;
//                }
                $quanUrl = 'http://juanzhuzhu.com/home/wap/juanUrl?gid='.$coupon->id;

                // 文本内容
                // $taobaoLogic = new TaobaoLogic();
                // $taokouling = $coupon->taokouling ?: $taobaoLogic->taokouling($quanUrl, $coupon->Title, $coupon->Pic . '_150x150.jpg');
                $content = $coupon->Introduce.'[耶]!';

                $result = $this->send($content, $imgPath, $quanUrl);

                if ($wbId = $result['id']) {
                    DB::table('coupon')->where('id', $coupon->id)->update(['Jihua_shenhe' => 1]);
                    // 发表评论

                    $strComment = '速领'.$coupon->Quan_price.'元券：' . $quanUrl . PHP_EOL . ' 找券网：http://coupon.juanzhuzhu.com';
                    $this->send_comment($result['id'], $strComment);
                }
            }
        }
        return isset($result['id']) ? 1 : 0;
    }

    /**
     * @param $titl
     * 微博文章
     * @param $cover
     * @param $content
     * @param $intro
     * @param $text
     */
    public function sendAritcle($title, $cover, $content, $intro,$text)
    {
        $params = array(
            'title' => $title,
            'content' => rawurlencode($content),
            'cover' => $cover,
            'summary' => $intro, // 导语
            'text' => $text, // 与其绑定短微博内容，限制1900个中英文字符内
            'access_token' => WB_ACCESSTOKEN,
        );

        $ch = curl_init();
        $url = "https://api.weibo.com/proxy/article/publish.json";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        $ret = curl_exec($ch);
        curl_close($ch);
        pre(json_decode($ret, true));
    }

    /**
     * 名人娱乐新闻微博
     * @return int
     */
    public function sendWeiboNews($content, $imgPath, $to_url, $news_id = 0)
    {
        $curTime = date('H:i');
        $is_send = ($curTime >= '08:30' && $curTime <= '10:00') || ($curTime >= '12:00' && $curTime <= '13:30')
            || ($curTime >= '20:00' && $curTime <= '23:59') || ($curTime >= '00:01' && $curTime <= '02:00');
        if ($is_send) {
            // 切换默认账号
            $this->appkey = '2689312362';
            $this->secret = 'd6cd7be53231308204df644aa52220e2';
            $this->accessToken = '2.00zHG6eCqzEAwC7e26fde08emO1rLD';

            $result = $this->send($content, $imgPath, $to_url);
            if ($wbId = $result['id']) {
                // 发表评论
                $strComment = '详情地址：' . $to_url;
                // $this->send_comment($result['id'], $strComment);
            }
            DB::table('wb_news')->where('id', $news_id)->update(['is_send'=>1]);
        }
        return isset($result['id']) ? 1 : 0;
    }
}