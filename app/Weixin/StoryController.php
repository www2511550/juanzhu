<?php
/**
 * 品质小说网公众号接口
 * Created by CC.
 * User: 10574
 * Date: 2018/3/23
 * Time: 16:17
 */
namespace App\Weixin;

use App\Logic\StoryLogic;
use Illuminate\Http\Request;
use Cache;
use Storage;

class StoryController
{
    public function __construct()
    {
        // 品质小说网配置项
        define('APPID', 'wx3d8adff0e899a180');
        define('SECRET', 'f9e7e7609ffb7165a44d76cdb982397c');
        define('TOKEN', 'omJNpZEhZeHj1ZxFECKkP48B5VFbk1HP');
        define('AESKEY', 'tFMbnUBxusjtO4sIkUP5VHly9ZbLOQaDAkHQAoliDOd');
        // access_token 有效期2小时
//         Cache::forget('acessToken');
        define('ACCESSTOKEN', Cache::remember('acessToken', 1.5 * 60, function () {
            return $this->getAccessToken();
        }));

        // 小程序APPID
        define('WXAPPID', 'wx7f06440f8a0911be');
    }

    /**
     * 入口
     * @param Request $request
     */
    public function valid(Request $request)
    {
        if ($_GET['test']){
            // 点击
            $xml = [
                'ToUserName' => 'gh_da1bb1ccc94a',
                'FromUserName' => 'oOv2v0ip14oq6JKPIjHVNF83jyYk', // o4MWFw10nOwiPL7OwO3bTLojE3H8
                'CreateTime' => '1520759785',
                'MsgType' => 'event',
                'Event' => 'SCAN',
//                'Event' => 'CLICK',
                'EventKey' => '1174e1ac1642986f642d807769b453e7',
            ];


        }else{
            $xml = $this->getXmlData(); // 消息信息
        }

        Storage::disk('local')->put('xmlData.txt', json_encode($xml));

        $storyLogic = new StoryLogic($xml);
        // 识别消息类型
        if ('createMenu' == $request->get('type')) {
            // 用于手动地址创建菜单
            $this->createMenu();
            die;
        }
        // 消息和事件
        else {
            switch ($xml['MsgType']) {
                case 'image': // 图片消息
                    echo $storyLogic->dealImageMsg();
                    die;
                case 'event':  // 事件，菜单点击、二维码扫描
                    echo $storyLogic->dealEventMsg();
                    die;
                case 'text': // 文本消息
                    echo $storyLogic->dealTextMsg();
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
            'appid' => APPID,
            'secret' => SECRET,
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

        $tmpArr = array(TOKEN, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        return $tmpStr == $signature ? true : false;
    }


    /**
     * 获取xmlData
     * @param $xmlData
     * @return array
     */
    public function getXmlData()
    {
        $data = [];
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        if (!empty($postStr)) {

            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $data = (array) $postObj;
            Storage::disk('local')->put('post.txt', json_encode($data));
        }

        return $data;
    }

    /**
     * 创建菜单
     */
    public function createMenu()
    {
        $request_url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=" . ACCESSTOKEN;
        $strMenu = '{
                "button": [
                    {
                        "name": "精品推荐",
                        "sub_button": [
                            {
                                "name": "☞  搜小说",
                                "type": "view",
                                "key": "search",
                                "url": "https://163.lu/E8GzV3"
                            },
                            {
                                "name": "☞ 男频专区",
                                "type": "view",
                                "key": "boy",
                                "url": "https://163.lu/brgNa4"
                            },
                            {
                                "name": "☞ 女频专区",
                                "type": "view",
                                "key": "girl",
                                "url": "https://163.lu/CjvMq2"
                            },
                            {
                                "name": "☞ 书城首页",
                                "type": "view",
                                "key": "index",
                                "url": "https://163.lu/xjnwS0"
                            }
                        ]
                        
                    },
                    {    
                        "name": "阅读历史",
                        "type": "view",
                        "key": "history",
                        "url": "https://163.lu/v3erc3"
                    },   
                    {
                        "name": "帮你",
                        "sub_button": [
                            {
                                "name": "我要充值",
                                "type": "view",
                                "key": "money",
                                "url": "https://163.lu/JHIek1"
                            },
                            {
                                "name": "个人中心",
                                "type": "view",
                                "key": "account",
                                "url": "https://163.lu/wZd8n4"
                            },
                            {
                                "name": "联系客服",
                                "type": "click",
                                "key": "connact"
                            },
                            {
                                "name": "红包海报",
                                "type": "click",
                                "key": "hongbao"   
                            },
                            {
                                "type":"click",
                                "name":"签到红包",
                                "key":"sign"
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