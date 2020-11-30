<?php
/**
 * Created by PhpStorm.
 * User: 10574
 * Date: 2018/1/12
 * Time: 11:23
 */

namespace App\Weixin;


use App\Logic\WeixinLogic;
use App\Service\WxReplyService;
use Illuminate\Http\Request;
use Cache;
use Storage;
use Route;

class WechatController
{
    public function __construct()
    {
        $action = Route::getCurrentRoute()->uri();
        if (strpos($action, '/test')){
            $this->corpId = "wx4dd5c330ee28cbde";
            $this->Secret = "51ca976b59464d81ab6f4865a9019a82";
        }else{
            // 智炫科技-微赚小能手
            $this->corpId = "wxa7648876a95e7209";
            $this->Secret = "c772a4adcf721d1d0375a59ecfa291cc";
        }

         $this->token = "omJNpZEhZeHj1ZxFECKkP48B5VFbk1HP";
         $this->encodingAesKey = "S4R2yZuneVO6yeiEuuQdsO2Snh9EAHSWdDU6XwlV5d7";

        // 有效期2小时
//         Cache::forget('acessToken');
        $this->access_token = Cache::remember('acessToken', 60, function(){
          return $this->getAccessToken();
        });

        define('APPID', $this->corpId);
        define('SECRET', $this->Secret);
        define('TOKEN', $this->token);
        define('AESKEY', $this->encodingAesKey);
        define('ACCESSTOKEN', $this->access_token);
        // 小程序APPID
        define('WXAPPID', 'wx7f06440f8a0911be');
    }

    /**
     * 入口
     * @param Request $request
     */
    public function valid(Request $request)
    {
        $weixinLogic = new WeixinLogic();

        if ($_GET['test']){
            // 点击
            $xml = [
                'ToUserName' => 'gh_586dab226154',
                'FromUserName' => 'oj7xI0mFt5yR6gcpQYDAEA7hNRUE', // o4MWFw10nOwiPL7OwO3bTLojE3H8
                'CreateTime' => '1541921519',
                'MsgType' => 'event',
                'Event' => 'CLICK',
                'EventKey' => 'WX_HONGBAO',
            ];


        }else{
            $xml = $weixinLogic->getXmlData(); // 消息信息
        }

        Storage::disk('local')->put('xmlData.txt', json_encode($xml));

        // 识别消息类型
        if ('createMenu' == $request->get('type')) {
            // 用于手动地址创建菜单
            $this->createMenu();
            die;
        } else {
            // 消息和事件
            switch ($xml['MsgType']) {
                case 'image': // 图片消息
                    echo $weixinLogic->dealImageMsg($xml);
                    die;
                case 'event':  // 事件，菜单点击、二维码扫描
                    echo $weixinLogic->dealEventMsg($xml);
                    die;
                case 'text': // 文本消息
                    echo $weixinLogic->dealTextMsg($xml);
                    die;
            }
        }

        // 签名认证 valid signature , option
        if ($this->checkSignature()) {
            echo $_GET["echostr"];
            exit;
        }
    }

    /**
     * 获取access_tokenss
     */
    public function getAccessToken()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/token';
        $getParams = [
            'grant_type' => 'client_credential',
            'appid' => $this->corpId,
            'secret' => $this->Secret,
        ];
        $result = http($url, $getParams);
        $data = json_decode($result,true);
        return $data['access_token'];
    }

    /**
     * 签名校验
     * @return bool
     */
    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = $this->token;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        return $tmpStr == $signature ? true : false;
    }

    /**
     * 创建菜单
     *
     */
    public function createMenu()
    {
//        {
//            "type":"click",
//                                "name":"☞专属海报红包",
//                                "key":"WX_HONGBAO"
//                            },
//        {
//            "type":"click",
//                                "name":"☞签到红包",
//                                "key":"sign"
//                            },
        $request_url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=" . $this->access_token;
        $strMenu = '{
                "button": [
                    {    
                        "name": "免费电影",
                        "sub_button": [
                            {
                                "name": "VIP免费教程",
                                "type": "view",
                                "key": "vip",
                                "url": "https://mp.weixin.qq.com/s/8B9aDsJiyOiRTWqQy1TZYQ"
                            },
                            {
                                "name": "最新电影",
                                "type": "view",
                                "key": "hot",
                                "url": "http://ydyyuan.top"
                            },  
                            {
                                "type":"click",
                                "name":"☞专属海报红包",
                                "key":"WX_HONGBAO"
                            }
                        ]
                    },
                    {
                        "name": "粉丝福利",
                        "sub_button": [
                            {
                                "name": "天猫优惠券",
                                "type": "view",
                                "key": "tb_quan",
                                "url": "http://coupon.juanzhuzhu.com"
                            },
                            {
                                "name": "京东优惠券",
                                "type": "view",
                                "key": "tb_time",
                                "url": "http://jd.juanzhuzhu.com"
                            },
                            {
                                "name": "我是颜值控",
                                "type": "view",
                                "key": "hb_meimei",
                                "url": "http://coupon.juanzhuzhu.com/index.php?r=index/cat&px=t&cid=3&u=537958"
                            },
                            {
                                "name": "☞ofo周卡",
                                "type": "view",
                                "key": "ofo",
                                "url": "https://active.clewm.net/BK8dl0?qrurl=http://qr27.cn/BK8dl0&gtype=1&key=a581b15e8e89fe38b40475ff697c05c0ca074c7752"
                            },
                            {
                                "name": "☞支付宝红包",
                                "type": "view",
                                "key": "ZHB_HONGBAO",
                                "url": "http://juanzhuzhu.com/home/wap/zhifubao"
                            }
                        ]
                        
                    },
                    {
                        "name": "网上赚钱",
                        "sub_button": [
                            {
                                "name": "网赚项目",
                                "type": "view",
                                "key": "xiangmu",
                                "url": "http://51wz.com.cn/xiangmu"
                            },
                            {
                                "name": "现金活动",
                                "type": "view",
                                "key": "yangmao",
                                "url": "http://51wz.com.cn/yangmao"
                            }
                        ]
                    }
                ]
            }';
        $result = httpCurl($request_url, $strMenu);
        pree($result);
    }

}

?>