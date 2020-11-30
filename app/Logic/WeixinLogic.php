<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2017/9/16
 * Time: 下午1:07
 * 微信小程序专用逻辑
 */
namespace App\Logic;

use App\Model\Coupon;
use App\Model\User;
use App\Model\Wxinfo;
use App\Service\EventService;
use App\Service\WxReplyService;
use Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Cache;
use DB;

class WeixinLogic
{
    public function __construct()
    {
        include_once app_path('include/wx/WXBizMsgCrypt.php');
    }

    /**
     * 获取首页banner
     */
    function getIndexBanner()
    {
        return array(
            array('title' => '韩都衣舍旗舰店', 'img_url' => 'http://juanzhuzhu.com/wap/imgs/handu.jpeg', 'toUrl' => '../list/list?cid=2'),
            array('title' => '劲霸男装旗舰店', 'img_url' => 'http://juanzhuzhu.com/wap/imgs/jinba.jpeg', 'toUrl' => '../list/list?cid=3'),
            array('title' => '兰蔻官方旗舰店', 'img_url' => 'http://juanzhuzhu.com/wap/imgs/lankou.jpeg', 'toUrl' => '../list/list?cid=4'),
        );
    }

    /**
     * 获取首页分类
     */
    function getIndexChannel()
    {
        return [
            ['id' => 1, 'icon_url' => 'http://juanzhuzhu.com/wap/imgs/hot_80x80.png', 'name' => '今日热销', 'url' => '../list/list?type=hot'],
            ['id' => 2, 'icon_url' => 'http://juanzhuzhu.com/wap/imgs/jiu_80x80.png', 'name' => '九块九包邮', 'url' => '../list/list?type=9.9'],
            ['id' => 3, 'icon_url' => 'http://juanzhuzhu.com/wap/imgs/eat_80x80.png', 'name' => '吃货最爱', 'url' => '../list/list?cid=6'],
            ['id' => 4, 'icon_url' => 'http://juanzhuzhu.com/wap/imgs/good_80x80.png', 'name' => '小编推荐', 'url' => '../list/list?type=recom'],
        ];
    }

    /**
     * 绑定小程序用户openid
     * @param $code
     */
    public function bindOpenid($code, $wxInfo = [])
    {
        $user_id = 0;
        // 获取opneid
        $params = [
            'appid' => 'wx7f06440f8a0911be',
            'secret' => '215392efedfb7c4669debf6a0a7773e5',
            'js_code' => $code,
            'grant_type' => 'authorization_code',
        ];
        $wxData = http('https://api.weixin.qq.com/sns/jscode2session', $params);
        $wxData = json_decode($wxData, true);
        // 绑定用户id
        if ($wxData['openid']) {
            $user = User::where('type', 2)->where('openid', $wxData['openid'])->first();
            if ($user->id) {
                $user_id = $user->id;
            } else {
                $user_id = User::addOneUser('', '123456', 1, 2, $wxData['openid'], $wxInfo['nickName']);
            }
        }

        return $user_id;
    }

    /**
     * 微信公众号关键字搜索
     * @param $kw
     */
    public function wxSearch($kw, $limit = 5)
    {
        $data = [];
        $indexLogic = new IndexLogic();

        $result = $indexLogic->searchList(['kw' => $kw], $limit);
        if (count($result['ids']) > 0) {
            foreach ($result['ids'] as $couponId) {
                $coupon = Coupon::find($couponId);
                $data[] = $coupon->formatWxRepley($coupon);
            }
        }

        return $data;
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
     * 处理图片消息
     * @param $xml
     */
    public function dealImageMsg($xml)
    {
        $wxReplyService = new WxReplyService($xml['FromUserName'], $xml['ToUserName']);

        $xml['MediaId'] = 'ArxmUZMJrbBO2wfFp5FGPOCfwLm480iCpc8xIAEVSQXdjuLanX1gt5VUjJL1z3UW';
        $strResult =$wxReplyService->image($xml['MediaId']);
        Storage::disk('local')->put('reply.txt', $strResult);
        return $strResult;

//        $result = $wxReplyService->templateNotice($xml['FromUserName']);
//        Storage::disk('local')->put('reply.txt', json_encode($result));

    }

    /**
     * 处理事件消息，如菜单栏点击(CLICK)、二维码识别(SCAN)、菜单跳转事件(VIEW)
     * @param $xml
     */
    public function dealEventMsg($xml)
    {
        $eventService = new EventService($xml);
        if ('subscribe' == $xml['Event']) {

            // 关注，存储用户信息
            $this->userInfo($xml['FromUserName']);

            return $eventService->subscribe($xml);

        } elseif ('SCAN' == $xml['Event']) {
            // 二维码识别
            return $this->checkIsGetHongBao($xml);

        } elseif ('VIEW' == $xml['Event']) {

        } elseif ('CLICK' == $xml['Event']) {

            // 微信红包菜单
            if ('WX_HONGBAO' == $xml['EventKey'])
            {
                return $this->sendAdsMsg($xml);
            }
            // 签到红包
            elseif('sign' == $xml['EventKey'])
            {
                return $eventService->signHongBao($xml);
            }
            // 联系客服
            elseif('connact' == $xml['EventKey'])
            {
                return $eventService->connact();
            }


        }
        return '';
    }

    /**
     * 消息接收者，
     * @param $FromUserName
     * @return mixed
     */
    public function sendAdsMsg($xml)
    {
        $wxReplyService = new WxReplyService($xml['FromUserName'], $xml['ToUserName']);
        $strKey = $xml['FromUserName'] . $xml['Event'];

        // 微信5s内会连续请求三次，防止多次发送
        if (!Cache::add($strKey, 1, 0.1)) return '';
        // 有海报，直接发送
        $wxInfo = Wxinfo::where('openid', $xml['FromUserName'])->first();
        if ($wxInfo->ad_img) {
            // 海报
            $wxReplyService->customMsg('正在为您发送红包海报，请稍后...');
            $mediaId = $this->uploadToWx($wxInfo->ad_img);

            Storage::disk('local')->put('subscribe.txt', $wxInfo->ad_img . '---' . $mediaId);
            $wxReplyService->customMsg($mediaId, 'image');

        } else{

            // 发送红包金额消息
            $hbInfo = $this->getHongbaoImg($xml['FromUserName']);
            $strInfo = '您的' . $hbInfo['money'] . '元红包，已经随机裂变为' . $hbInfo['hongbao_num'] . '份，您获得了' . $hbInfo['current_money'] . '元红包，累计剩下的' . $hbInfo['hongbao_num'] . '个红包分享给您的朋友领取吧！';
            $wxReplyService->customMsg($strInfo);

            // 发送通知
            //$to_url = 'http://juanzhuzhu.com/wx/center/detail?mid='.$wxInfo->openid_md5;
            //$wxReplyService->templateNotice('IhJ9Jq0yWVNrr4PEG5UD707_LSnfnHTbQe8xqqmAod0', ['money' => $hbInfo['current_money']], $to_url);

            // 海报
            $wxReplyService->customMsg('正在为您发送红包海报（剩余的' . $hbInfo['hongbao_num'] . '个红包），请稍后...');
            $mediaId = $this->uploadToWx($hbInfo['hongbao_img']);

            Storage::disk('local')->put('subscribe.txt', $strInfo . '---' . $mediaId);
            $wxReplyService->customMsg($mediaId, 'image');

            // 存储海报
            $wxInfo->money = $hbInfo['current_money'];
            $wxInfo->ad_img = $hbInfo['hongbao_img'];
            $wxInfo->save();
        }

        return '';
        //return $wxReplyService->text('');  // 空 - 表示请求结束
    }

    /**
     * 处理文本消息
     * @param $xml
     */
    public function dealTextMsg($xml)
    {
        $text = '';
        $wxReplyService = new WxReplyService($xml['FromUserName'], $xml['ToUserName']);
        if(trim($xml['Content']) == '余额')
        {
            $wxinfo = Wxinfo::where('openid', $xml['FromUserName'])->first();
            $text = '亲爱的【'.$wxinfo->nickname.'】，余额为：¥'.$wxinfo->money."\n".'分享红包海报给好友，获取红包哦！';
        }
        elseif(trim($xml['Content']) == '提现')
        {
            $text = '亲，余额大于20元才能提现哦。'."\n".'分享红包海报给好友，赚取更多红包！';
        }
        // 免费vip视频
        elseif(false !== strpos($xml['Content'], 'http'))
        {
            $weiboLogic = new WeiboLogic();
            $baseUrl = 'http://jiexi365.cn/yyy/?url=';
            $str_short_url = $weiboLogic->shortUrl($baseUrl . $xml['Content']);
            $text = "一一一一播 放 地 址一一一一\n你好，为你找到影片:" . $str_short_url;
        }else{
            $text = '可加主人V:juanzhukeji'; // $xml['Content'];
        }


        return $wxReplyService->text($text);

        /*$strResult = '';
        $keyword = trim($xml['Content']);
        if (!empty($keyword)) {
            Storage::disk('local')->put('keywords.html', date('Y-m-d H:i:s') . '---openid--' . $xml['FromUserName'] . '---' . $keyword . '<br/>');

            // 获取搜索优惠券
            $data = $this->wxSearch($keyword);
            $strResult = $wxReplyService->imgText($data, $keyword);

            Storage::disk('local')->put('data.txt', json_encode($data));
        }
        Storage::disk('local')->put('reply.txt', $strResult);
        return $strResult;*/
    }

    /**
     * 创建二维码
     * @param int $expire_time  s
     */
    public function createQcode($strKey = 'default', $expire_time = 0)
    {
        $request_url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . ACCESSTOKEN;
        $Q_img = '';
        // 参数配置
        if ($expire_time > 0) {
            $postParams = [
                'expire_seconds' => $expire_time,
                'action_name' => 'QR_STR_SCENE',
                'action_info' => [
                    'scene' => [
                        'scene_str' => $strKey
                    ]
                ],
            ];
        } else {  // 永久二维码
            $postParams = [
                'action_name' => 'QR_LIMIT_STR_SCENE',
                'action_info' => [
                    'scene' => [
                        'scene_str' => $strKey
                    ]
                ],
            ];
        }

        $result = $result = httpCurl($request_url, json_encode($postParams));
        // pree($result);
        // 用ticket换取二维码图片
        if ($ticket_url = $result['ticket']) {
            $request_ticket_url = 'https://mp.weixin.qq.com/cgi-bin/showqrcode';
            $imgContent = http($request_ticket_url, ['ticket' => $ticket_url]);
            $Q_img = 'wx/qcode/'.$strKey.'.jpg';
            @file_put_contents($Q_img, $imgContent);
        }

        return $Q_img;
    }

    /**
     * 上传临时素材
     */
    public function uploadToWx($imgUrl, $type = 'image')
    {
        // type 媒体文件类型，分别有图片（image）、语音（voice）、视频（video）和缩略图（thumb）
        if (!in_array($type, ['image', 'voice', 'video', 'thumb', ''])) {
            echo 'type is not exist!';
            die;
        } else {
            $url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token=" . ACCESSTOKEN . "&type=image";
            if (class_exists('\CURLFile')) {
                $data = array('media' => new \CURLFile(realpath($imgUrl)));
            } else {
                $data = array('media' => '@' . realpath($imgUrl));
            }

            $result = httpCurl($url, $data);
            return $result['media_id'];
        }
    }

    /**
     * 生成红包图片
     */
    public function createHongBaoImg($Qcode_img, $wxInfo)
    {
        $font_path = 'wx/msyh.ttf';
        // 获取头像到本地
        $img = Image::make('wx/hongbao_bg.jpg');
        // 插入二维码, 水印位置在原图片的右下角, 距离下边距 10 像素, 距离右边距 15 像素
        $qCode = Image::make($Qcode_img)->resize(200, 200);
        $img->insert($qCode, 'bottom-left', 47, 80);

        // 插入微信头像
        // $img->insert($wxInfo['img'], 'top-left', 25, 35);

        // 微信昵称
        $img->text($wxInfo['nickname'], 280, 558, function ($font) use ($font_path) {
            $font->file($font_path);
            $font->size(30);
            $font->color('#FF0000');
        });
        // 红包个数
        $img->text(intval($wxInfo['hongbao_num']), 250, 618, function ($font) use ($font_path) {
            $font->file($font_path);
            $font->size(30);
            $font->color('#FF0000');
        });
        // 红包总价值
        $img->text($wxInfo['money'], 250, 678, function ($font) use ($font_path) {
            $font->file($font_path);
            $font->size(30);
            $font->color('#FF0000');
        });

        // 扫一扫提示语
        $img->text('温馨提示：可长按领取！', 268, 920, function ($font) use ($font_path) {
            $font->file($font_path);
            $font->size(16);
            $font->color('#FF0000');
        });
        // 将处理后的图片重新保存到其他路径
        $save_path = 'wx/user/' . $wxInfo['openid_md5'] . '_ads.jpg';
        $img->save($save_path);
        return $save_path;
    }

    /**
     * 获取用户信息
     * @param $openid
     */
    public function userInfo($openid)
    {
        $info = Wxinfo::where('openid', $openid)->first();
        if (!$info->id) {
            $url = 'https://api.weixin.qq.com/cgi-bin/user/info';
            $getData = [
                'access_token' => ACCESSTOKEN,
                'openid' => $openid,
                'lang' => 'zh_CN',
            ];
            $result = http($url, $getData);
            $info = json_decode($result, true);
            // 绑定，存储用户信息
            $this->blindUserInfo($info);
            $info = (object)$info;
        }

        return [
            'nickname' => $info->nickname,
            'openid' => $info->openid,
            'openid_md5' => $info->openid_md5 ?: md5(md5($info->openid)),
            'headimg_path' => $info->headimg_path,
            'local_path' => $info->local_path,
            'hongbao_num' => $info->hongbao_num,
        ];
    }


    /**
     * 绑定用户信息
     */
    public function blindUserInfo($userInfo)
    {
        if ($userInfo['openid']) {
            $insertData = [
                'subscribe' => $userInfo['subscribe'],
                'openid' => $userInfo['openid'],
                'openid_md5' => md5(md5($userInfo['openid'])),
                'nickname' => $userInfo['nickname'],
                'sex' => $userInfo['sex'],
                'city' => $userInfo['city'],
                'province' => $userInfo['province'],
                'country' => $userInfo['country'],
                'headimgurl' => $userInfo['headimgurl'],
                'subscribe_time' => $userInfo['subscribe_time'],
            ];
            $objWxInfo = Wxinfo::where('openid', $userInfo['openid'])->first();
            if ($objWxInfo->id) {
                Wxinfo::where('id', $objWxInfo->id)->update($insertData);
            } else {
                $insertData['created_at'] = $insertData['updated_at'] = date('Y-m-d H:i:s');
                Wxinfo::insert($insertData);
            }
        }
    }

    /**
     * 获取红包宣传海报
     */
    public function getHongbaoImg($openid)
    {
        $wxInfo = $this->userInfo($openid);
        // 1-1、当前用户获得红包
        $currentMoney = rand(300,500)/100;
        Wxinfo::where('openid', $wxInfo['openid'])->decrement('hongbao_num', $currentMoney);

        // 1-2、获取金额相关信息
        $moneyInfo = $this->getMoneyInfo($openid);

        // 1-3、唯一标示二维码
        Cache::forget('Qcode' . $wxInfo['openid_md5']);
        $Qcode_url = Cache::remember('Qcode' . $wxInfo['openid_md5'], 15 * 24 * 60, function () use ($wxInfo) {
            return $this->createQcode($wxInfo['openid_md5']);
        });
        // 1-4、生成海报，返回图片地址
        $intHongbaoNum = $moneyInfo['hongbao_num'] ?: 0;
        $intMoney = $moneyInfo['money'] ?: 0;
        $honbao_img = $this->createHongBaoImg($Qcode_url, [
            'img' => $wxInfo['local_path'],
            'nickname' => $wxInfo['nickname'],
            'openid_md5' => $wxInfo['openid_md5'] ?: time(),
            'hongbao_num' => $intHongbaoNum,
            'money' => $intMoney,
        ]);
        return [
            'hongbao_img' => $honbao_img,
            'hongbao_num' => $intHongbaoNum,
            'money' => $intMoney,
            'current_money' => $currentMoney
        ];
    }

    /**
     * 通过地址获取图片到本地
     */
    public function getUrlImgToLocal($url, $img_path = '')
    {
        $img_path = $img_path ?: (time() . '.jpg');
        $imgData = @file_get_contents($url);
        file_put_contents($img_path, $imgData);
        return $img_path;
    }

    /**
     * 获取用户money相关信息
     * @param $openid
     * @return array
     */
    public function getMoneyInfo($openid)
    {
        return [
            'hongbao_num' => rand(10,30),
            'money' => 99,
        ];
    }

    /**
     * 检测红包资格
     * @param $openid_md5
     */
    public function checkIsGetHongBao($xml)
    {
        $openid_md5 = $xml['EventKey'];
        // 海报发起者信息
        $user = Wxinfo::where('openid_md5', $openid_md5)->first();
        if ($user['openid'] == $xml['FromUserName']) {
            // 1、是否是自己扫描自己二维码
            $wxReplyService = new WxReplyService($xml['FromUserName'], $xml['ToUserName']);
            return $wxReplyService->text('亲爱的【'.$user['nickname'].'】，您已经领过该次活动的红包，无法再次领取，分享给好友，好友领取后，你也可获取随机红包哦！');

        } else {
            // 2、其他人扫码
            $scanUser = DB::table('wx_scan')->where('user_id', $user['user_id'])->where('openid', $xml['FromUserName'])->first();
            if ($scanUser) {
                // 提示分享后可以继续领取红包
                $wxReplyService = new WxReplyService($xml['FromUserName'], $xml['ToUserName']);
                return $wxReplyService->text('你已领取过红包，分享专属还海报，好友领取后，你也可以获取随机红包哦！');
            } else {
                // 分别给推广者和

                // 生成海报，并给他红包
                // return $this->sendAdsMsg($xml);
            }
        }
    }

}