<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2018/1/12
 * Time: 下午10:02
 */
namespace App\Service;

class WxReplyService
{

    public function __construct($fromUsername, $toUsername)
    {
        $this->openid = $fromUsername;
        $this->baseXml = '<xml>
                        <ToUserName><![CDATA[' . $fromUsername . ']]></ToUserName>
                        <FromUserName><![CDATA[' . $toUsername . ']]></FromUserName>
                        <CreateTime>' . time() . '</CreateTime>';
    }

    /**
     * 回复文本消息
     * @param $msg
     * @return string
     */
    public function text($msg = '')
    {
        return $this->baseXml . '<MsgType><![CDATA[text]]></MsgType><Content><![CDATA[' . $msg . ']]></Content></xml>';
    }

    /**
     * 回复图片
     * @param $mediaId
     * @return string
     * author chengcong
     */
    public function image($mediaId)
    {
        return $this->baseXml . '<MsgType><![CDATA[image]]></MsgType>
        <Image><MediaId><![CDATA[' . $mediaId . ']]></MediaId></Image></xml>';
    }

    /**
     * 回复图文消息
     */
    public function imgText($data, $keyword = '')
    {
        $msg = '暂无相关优惠券，自助查询地址：coupon.juanzhuzhu.com';
        if (!count($data)) {
            return $this->text($msg);
        }

        $imgTextTpl = $this->baseXml . '<MsgType><![CDATA[news]]></MsgType><ArticleCount>' . count($data) . '</ArticleCount><Articles>';
        foreach ($data as $val) {
            $strPrice = $val['price'] ? '[¥' . $val['price'] . ']' : '';
            $imgTextTpl .= '<item>
                        <Title><![CDATA[' . $strPrice . trim($val['title']) . ']]></Title>
                        <Description><![CDATA[' . trim($val['desc']) . ']]></Description>
                        <PicUrl><![CDATA[' . $val['pic'] . ']]></PicUrl>
                        <Url><![CDATA[' . $val['to_url'] . ']]></Url>
                    </item>';
        }
        // 结尾推荐
        if ($keyword) {
            $imgTextTpl .= '<item>
                        <Title><![CDATA[' . $keyword . '>>相关推荐]]></Title>
                        <Description><![CDATA[]></Description>
                        <PicUrl><![CDATA[]]></PicUrl>
                        <Url><![CDATA[' . 'http://juanzhuzhu.com' . ']]></Url>
                    </item>';
        }

        return $imgTextTpl . '</Articles></xml>';
    }

    /**
     * 模版消息推送
     * @param string $template_id
     * @param string $msg
     * @return mixed
     */
    public function templateNotice($template_id = '', $info = [], $to_url = 'http://juanzhuzhu.com')
    {
        if (!$info['money']) return false;
        $request_url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=' . ACCESSTOKEN;
        $data = [
            'result' => [
                'value' => '恭喜您获得随机红包！',
                'color' => '#173177'
            ],
            'withdrawMoney' => [
                'value' => $info['money'],
                'color' => '#173177'
            ],
            'withdrawTime' => [
                'value' => date('Y-m-d H:i:s'),
                'color' => '#173177'
            ],
            'cardInfo' => [
                'value' => '零钱入账',
                'color' => '#173177'
            ],
            'arrivedTime' => [
                'value' => date('Y-m-d H:i:s'),
                'color' => '#173177'
            ],
            'remark' => [
                'value' => '分享海报得红包!',
                'color' => '#173177',
            ]
        ];
        $postData = [
            'touser' => $this->openid,
            'template_id' => $template_id,
            'url' => $to_url,
            'topcolor' => '#173177',
            'data' => $data
        ];

        $result = httpCurl($request_url, json_encode($postData));
        return $result;
    }

    /**
     * 获取模版id
     */
    public function templateId()
    {
        $request_url = 'https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token=' . ACCESSTOKEN;
        $result = http($request_url, [], 'POST');
        pree(json_decode($result, true));
    }


    /**
     * 客服消息回复
     * author chengcong
     */
    public function customMsg($content, $type = 'text')
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=' . ACCESSTOKEN;
        $content = $content ?: '';
        if ('image' == $type) {
            // 图片消息
            $arrMsg = [
                "touser" => $this->openid,
                "msgtype" => $type,
                "image" => [
                    "media_id" => $content
                ],
            ];
        } elseif('wxapp' == $type){
            // 微信小程序
            $arrMsg = [
                "touser" => $this->openid,
                "msgtype" => "miniprogrampage",
                "miniprogrampage" => [
                    "title" => "title",
                    "appid" => WXAPPID,
                    "pagepath" => "pages/index/index",
                ],
            ];
        } else{
            // 文本消息
            $arrMsg = [
                "touser" => $this->openid,
                "msgtype" => $type,
                "text" => [
                    "content" => urlencode($content)
                ],
            ];
        }
        httpCurl($url, urldecode(json_encode($arrMsg)));
    }
}