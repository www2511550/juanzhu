<?php
/**
 * 微信服务层
 * Created by PhpStorm.
 * User: 10574
 * Date: 2018/3/25
 * Time: 13:47
 */

namespace App\Service;

use Cache;

class WeixinService
{

    /**
     * 微信-上传临时素材
     * @param $imgUrl 【图片地址-相对路径】
     * @param string $type 【类型】
     * @return mixed
     * author chengcong
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
     * 获取ticket，用于生产带参数二维码
     * @return string
     * author chengcong
     */
    public function getTicket()
    {
        // 每次创建二维码ticket需要提供一个开发者自行设定的参数（scene_id）
        $create_url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$this->getAccessToken();
        $jsonData = '{"expire_seconds": '.(24*60*60).', "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": '.time().'}}}';
        $result = httpCurl($create_url, $jsonData);

        return $result['ticket'] ?: '';
    }


    public function getAccessToken()
    {
        return Cache::remember('acessToken', 60, function () {
            $url = 'https://api.weixin.qq.com/cgi-bin/token';
            $getParams = [
                'grant_type' => 'client_credential',
                'appid' => 'wxa7648876a95e7209',
                'secret' => 'f161030773c4508999379b6a6070db1c',
            ];
            $result = http($url, $getParams);
            $data = json_decode($result, true);

            return $data['access_token'];
        });
    }


}