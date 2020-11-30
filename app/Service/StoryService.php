<?php
/**
 * 品质小说服务层
 * Created by PhpStorm.
 * User: 10574
 * Date: 2018/3/25
 * Time: 13:18
 */

namespace App\Service;

use App\Logic\StoryLogic;
use App\Model\Wxsign;
use App\Model\WxStoryInfo;
use Cache, DB;

class StoryService
{
    /**
     * 消息回复类
     * @var WxReplyService
     */
    public $wxReplyService;

    /**
     * 消息数据
     * @var
     */
    public $xml;

    public function __construct($xml)
    {
        $this->xml = $xml;
        $this->wxReplyService = new WxReplyService($xml['FromUserName'], $xml['ToUserName']);
    }

    /**
     * 关注消息回复
     * author chengcong
     */
    public function subscribe()
    {
        $msg = "<a href='https://163.lu/v3erc3'>点我继续阅读</a>\n\n ☞<a href='https://163.lu/JxRxF1'>美女村长的'凶器'</a>\n\n ☞<a href='https://163.lu/6s9th4'>闪婚试爱，家有天价影后</a>\n\n右下角【帮你】-【红包海报】领取99元红包！";
        return $this->wxReplyService->text($msg);
    }

    /**
     * 回复图片
     * @return string
     * author chengcong
     */
    public function imageMsg()
    {
        return $this->wxReplyService->image($this->xml['MediaId']);
    }

    /**
     * 签到红包
     * @param $xml
     */
    public function signHongBao()
    {
        // 签到记录
        $sign = Wxsign::where('openid', $this->xml['FromUserName'])->where('date', date('Ymd'))->first();
        if ($sign->id) {
            $text = "今天已经签到，回复'余额'查询账户信息！";
        } else {
            $rand = rand(10, 80) / 100;
            $text = '签到成功，获得' . $rand . '元红包！';
            if (WxStoryInfo::where('openid', $this->xml['FromUserName'])->increment('money', $rand)) {
                Wxsign::insert([
                    'openid' => $this->xml['FromUserName'],
                    'money' => $rand,
                    'date' => date('Ymd'),
                ]);
            }
        }
        return $this->wxReplyService->text($text);
    }

    /**
     * 联系我们
     */
    public function connact()
    {
        $weixinService = new WeixinService();
        $imgUrl = 'wx/story/se.jpg';
        return $this->wxReplyService->customMsg($weixinService->uploadToWx($imgUrl), 'image');
    }

    /**
     * 文本消息处理
     * author chengcong
     */
    public function text()
    {
        if (trim($this->xml['Content']) == '余额') {
            $wxinfo = WxStoryInfo::where('openid', $this->xml['FromUserName'])->first();
            $text = '亲爱的【' . $wxinfo->nickname . '】，余额为：¥' . $wxinfo->money . "\n" . '分享红包海报给好友，获取红包哦！';

        } elseif (trim($this->xml['Content']) == '提现') {
            $text = '亲，余额大于20元才能提现哦。' . "\n" . '分享红包海报给好友，赚取更多红包！';

        } else {
            $text = "很抱歉，找不到相关小说，试试。\n\n ☞ <a href='https://163.lu/v3erc3'>继续阅读</a>\n\n☞ <a href='https://163.lu/E8GzV3'>点我搜索</a>";

        }

        return $this->wxReplyService->text($text);
    }

    /**
     * 红包海报
     * author chengcong
     */
    public function sendHongbao()
    {
        $strKey = $this->xml['FromUserName'] . $this->xml['Event'];

        // 微信5s内会连续请求三次，防止多次发送
        if (!Cache::add($strKey, 1, 0.1)) return '';

        $weixinService = new WeixinService();
        // 有海报，直接发送
        $wxInfo = WxStoryInfo::where('openid', $this->xml['FromUserName'])->first();
        if ($wxInfo->ad_img) {
            // 海报
            $this->wxReplyService->customMsg('正在为您发送红包海报，请稍后...');
            $mediaId = $weixinService->uploadToWx($wxInfo->ad_img);
            $this->wxReplyService->customMsg($mediaId, 'image');

        } else {
            $storyLogic = new StoryLogic($this->xml);
            // 发送红包金额消息
            $hbInfo = $storyLogic->getHongbaoImg($this->xml['FromUserName']);
            $strInfo = '您的' . $hbInfo['money'] . '元红包，已经随机裂变为' . $hbInfo['hongbao_num'] . '份，您获得了' . $hbInfo['current_money'] . '元红包，累计剩下的' . $hbInfo['hongbao_num'] . '个红包分享给您的朋友领取吧！';
            $this->wxReplyService->customMsg($strInfo);

            // 发送通知
            // $to_url = 'http://juanzhuzhu.com/wx/center/detail?mid=' . $wxInfo->openid_md5;
            // $this->wxReplyService->templateNotice('IhJ9Jq0yWVNrr4PEG5UD707_LSnfnHTbQe8xqqmAod0', ['money' => $hbInfo['current_money']], $to_url);

            // 海报
            $this->wxReplyService->customMsg('正在为您发送红包海报（剩余的' . $hbInfo['hongbao_num'] . '个红包），请稍后...');
            $mediaId = $weixinService->uploadToWx($hbInfo['hongbao_img']);
            $this->wxReplyService->customMsg($mediaId, 'image');

            // 存储海报
            $wxInfo->money = $hbInfo['current_money'] + $wxInfo->money;
            $wxInfo->ad_img = $hbInfo['hongbao_img'];
            $wxInfo->save();
        }

        return '';
    }

    /**
     * 二维码识别
     * author chengcong
     */
    public function scanImg()
    {
        $openid_md5 = $this->xml['EventKey'];
        // 海报发起者信息
        $user = WxStoryInfo::where('openid_md5', $openid_md5)->first();
        if ($user['openid'] == $this->xml['FromUserName']) {
            // 1、是否是自己扫描自己二维码
            $text = '亲爱的【' . $user['nickname'] . '】，您已经领过该次活动的红包，无法再次领取，分享给好友，好友领取后，你也可获取随机红包哦！';
            return $this->wxReplyService->text($text);

        } else {
            // 2、其他人扫码
            $scanUser = DB::table('wx_scan')->where('user_id', $user['user_id'])->where('openid', $this->xml['FromUserName'])->first();
            if ($scanUser) {
                // 提示分享后可以继续领取红包
                return $this->wxReplyService->text('你已领取过红包，分享专属还海报，好友领取后，你也可以获取随机红包哦！');
            } else {
                // 分别给推广者和

                // 生成海报，并给他红包
                // return $this->sendAdsMsg($xml);
            }
        }
    }

}