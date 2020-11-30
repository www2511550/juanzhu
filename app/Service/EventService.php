<?php
/**
 * 处理微信公众号event事件对应的回复
 * Created by PhpStorm.
 * User: 10574
 * Date: 2018/3/11
 * Time: 16:22
 */
namespace App\Service;

use App\Logic\WeixinLogic;
use App\Model\Wxinfo;
use App\Model\Wxsign;
use Cache;
use Intervention\Image\ImageManagerStatic as Image;

class EventService
{
    public $wxReplyService;
    public $xml;

    public function __construct($xml)
    {
        $this->xml = $xml;
        $this->wxReplyService = new WxReplyService($xml['FromUserName'], $xml['ToUserName']);
    }

    /**
     * 关注事件处理
     * author chengcong
     */
    public function subscribe()
    {
        // 关注消息回复
        $msg = '你终于来了，我们专注于互联网省钱/:,@f/:,@，VIP电影免费看，优惠券免费领哦/:rose/:rose';
        return $this->wxReplyService->text($msg);
    }


    /**
     * 专属海报
     * author chengcong
     */
    public function selfPoster()
    {
        $weixinLogic = new WeixinLogic();
        $wxInfo = Wxinfo::where('openid', $this->xml['FromUserName'])->first();

        // 1、获取海报
        if ($wxInfo->ad_img) {
            $honbao_img = $wxInfo->ad_img;
        } else {
            // 唯一标示二维码(未认证，无法获取)
            /*Cache::forget('Qcode' . $wxInfo['openid_md5']);
            $Qcode_img = Cache::remember('Qcode' . $wxInfo['openid_md5'], 15 * 24 * 60, function () use ($weixinLogic, $wxInfo) {
                return $weixinLogic->createQcode($wxInfo['openid_md5']);
            });*/
            $Qcode_img = 'wx/qrcode.jpg';

            // 生成海报
            if ((int)$wxInfo->money < 1) {
                $wxInfo->money = 100;//rand(5000, 10000) / 100;
                $wxInfo->save();
            }
            $honbao_img = $this->createHaiBao($Qcode_img, $wxInfo);
            if ($honbao_img) {
                $wxInfo->ad_img = $honbao_img;
                $wxInfo->save();
            }
        }

        // 3、上传到公众号素材管理
        $mediaId = $weixinLogic->uploadToWx($honbao_img);

        return $this->wxReplyService->image($mediaId);
    }

    /**
     * 创建海报
     * @param $Qcode_img
     * @param $wxInfo
     * @return string
     * author chengcong
     */
    public function createHaiBao($Qcode_img, $wxInfo)
    {
        $font_path = 'wx/msyh.ttf';
        // 1、获取头像到本地
        $img = Image::make('wx/hongbao_bg.jpg');

        // 2、插入二维码, 水印位置在原图片的右下角, 距离下边距 10 像素, 距离右边距 15 像素
        $qCode = Image::make($Qcode_img)->resize(200, 200);
        $img->insert($qCode, 'bottom-left', 47, 80);

        // 3、微信昵称
        $img->text($wxInfo['nickname'], 280, 558, function ($font) use ($font_path) {
            $font->file($font_path);
            $font->size(30);
            $font->color('#FF0000');
        });

        // 4、红包总价值
        $img->text($wxInfo['money'], 250, 678, function ($font) use ($font_path) {
            $font->file($font_path);
            $font->size(30);
            $font->color('#FF0000');
        });

        // 5、将处理后的图片重新保存到其他路径
        $save_path = 'wx/user/' . $wxInfo['openid_md5'] . '_ads.jpg';
        $img->save($save_path);

        return $save_path;
    }

    /**
     * 识别二维码
     * author chengcong
     */
    public function scanQrcode()
    {
        return $this->wxReplyService->text('tests');
    }

    /**
     * 签到红包
     * @param $xml
     */
    public function signHongBao($xml)
    {
        // 签到记录
        $sign = Wxsign::where('openid', $xml['FromUserName'])->where('date', date('Ymd'))->first();
        if($sign->id){
            $text = "今天已经签到，回复'余额'查询账户信息！";
        }else{
            $rand = rand(10, 80)/100;
            $text = '签到成功，获得'.$rand.'元红包！';
            if(Wxinfo::where('openid', $xml['FromUserName'])->increment('money',$rand)){
                Wxsign::insert([
                    'openid' => $xml['FromUserName'],
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
        $weixinLogic = new WeixinLogic();
        $mediaId = $weixinLogic->uploadToWx('wx/story/se.jpg');
        return $this->wxReplyService->customMsg($mediaId, 'image');
    }


}