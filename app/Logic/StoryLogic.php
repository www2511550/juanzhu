<?php
/**
 * 品质小说逻辑层
 * Created by PhpStorm.
 * User: 10574
 * Date: 2018/3/25
 * Time: 13:20
 */

namespace App\Logic;

use App\Model\WxStoryInfo;
use App\Service\StoryService;
use App\Service\WxReplyService;
use Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Cache;
use DB;

class StoryLogic
{
    public function __construct($xml)
    {
        include_once app_path('include/wx/WXBizMsgCrypt.php');

        $this->xml = $xml;
        $this->storyService = new StoryService($xml);
    }


    /**
     * 处理图片消息
     * @param $xml
     */
    public function dealImageMsg()
    {
        return $this->storyService->imageMsg();
    }

    /**
     * 处理事件消息，如菜单栏点击(CLICK)、二维码识别(SCAN)、菜单跳转事件(VIEW)
     * @param $xml
     */
    public function dealEventMsg()
    {
        // 关注
        if ('subscribe' == $this->xml['Event'])
        {
            // 存储用户信息
            $this->userInfo($this->xml['FromUserName']);
            return $this->storyService->subscribe();
        }
        // 二维码识别
        elseif ('SCAN' == $this->xml['Event'])
        {
            return $this->storyService->scanImg();
        }
        elseif ('VIEW' == $this->xml['Event'])
        {
        }
        elseif ('CLICK' == $this->xml['Event'])
        {
            // 微信红包菜单
            if ('hongbao' == $this->xml['EventKey'])
            {
                return $this->storyService->sendHongbao();
            }
            // 签到红包
            elseif ('sign' == $this->xml['EventKey'])
            {
                return $this->storyService->signHongBao();
            }
            // 联系客服
            elseif('connact' == $this->xml['EventKey'])
            {
                return $this->storyService->connact();
            }
        }
        return '';
    }

    /**
     * 处理文本消息
     * @param $xml
     */
    public function dealTextMsg()
    {
        return $this->storyService->text();
    }

    /**
     * 创建二维码
     * @param int $expire_time s
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
            $Q_img = 'wx/qcode/' . $strKey . '.jpg';
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
        $info = WxStoryInfo::where('openid', $openid)->first();
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
                'openid_md5' => WxStoryInfo::md5openid(($userInfo['openid'])),
                'nickname' => $userInfo['nickname'],
                'sex' => $userInfo['sex'],
                'city' => $userInfo['city'],
                'province' => $userInfo['province'],
                'country' => $userInfo['country'],
                'headimgurl' => $userInfo['headimgurl'],
                'subscribe_time' => $userInfo['subscribe_time'],
            ];
            $objWxInfo = WxStoryInfo::where('openid', $userInfo['openid'])->first();
            if ($objWxInfo->id) {
                WxStoryInfo::where('id', $objWxInfo->id)->update($insertData);
            } else {
                $insertData['created_at'] = $insertData['updated_at'] = date('Y-m-d H:i:s');
                WxStoryInfo::insert($insertData);
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
        $currentMoney = rand(300, 500) / 100;
        WxStoryInfo::where('openid', $wxInfo['openid'])->decrement('hongbao_num', $currentMoney);

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
            'hongbao_num' => rand(15, 30),
            'money' => 99,
        ];
    }

}