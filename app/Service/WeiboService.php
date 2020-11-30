<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2019/5/8
 * Time: 10:22 AM
 */
namespace App\Service;


use Illuminate\Support\Facades\Cache;

class WeiboService
{

    /**
     * 微博发布（模拟pc端提交）
     */
    public function publish($text, $cookie, $arrPicId, $comment = '')
    {
        header("Content-type: text/html; charset=utf-8");

        $pic_id = implode('|', $arrPicId);
        $post = [
            'title' => '今日要说什么？',
            'location' => 'v6_content_home',
            'text' => $text,//需要发送微博的内容
            'pic_id' => $pic_id,//微博图片id，需事先上传好
            'isReEdit' => false,
            'pub_source' => 'page_2',
            'topic_id' => '1022%3A',
            'pub_type' => 'dialog',
            '_t' => 0,
            'style_type' => 1,
        ];
        $url = 'https://weibo.com/aj/mblog/add?ajwvr=6&__rnd=2918942797035';//不需要改变
        $referer = 'https://weibo.com/u/5458778095/home?topnav=1&wvr=6';//可改可不改
        $result = $this->curl($url, $post, '', $cookie, $referer);
        
        $data = json_decode($result, true);

        if (isset($data['code']) && $data['code'] == 100000) {
            // 是否追加评论
            if ($comment){
                $wbInfo = $this->getWeiboInfoByStr($data['data']['html']);
                if ($wbInfo['mid'] && $wbInfo['uid']){
                    $this->comment($cookie, $wbInfo['uid'], $wbInfo['mid'], $comment);
                }
            }
            return ['status' => 1, 'info' => '发布成功'];
        } else {
            return ['status' => 0, 'info' => '发布失败，稍后再试'];
        }
    }

    /**
     * 获取微博信息【mid，uid】
     * @param $html
     */
    public function getWeiboInfoByStr($html)
    {
        $pos_num = strpos($html, '&url=https://weibo.com/');
        $arr = array_filter(explode('&', substr($html, $pos_num, 230)));
        $data = ['mid' => 0, 'uid' => 0];
        if ($arr) {
            foreach ($arr as $val) {
                if (strpos($val, 'mid=') !== false) {
                    $data['mid'] = substr($val, 4);
                }
                if (strpos($val, 'uid=') !== false) {
                    $data['uid'] = substr($val, 4);
                }
            }
        }
        return $data;
    }
    /**
     *实现功能支持发送微博，发送微博带图。
     *不念制作，各位网友可随意分发，修改，重置。
     *http://www.bunian.cn/
     *
     */
    function curl($url, $post = 0, $header = 0, $cookie = 0, $referer = 0, $ua = 0, $nobaody = 0)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $httpheader[] = "Accept:*/*";
        $httpheader[] = "Accept-Encoding:gzip,deflate,sdch";
        $httpheader[] = "Accept-Language:zh-CN,zh;q=0.8";
        $httpheader[] = "Connection:close";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
        if ($post) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        if ($header) {
            curl_setopt($ch, CURLOPT_HEADER, TRUE);
        }
        if ($cookie) {
            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        }
        if ($referer) {
            curl_setopt($ch, CURLOPT_REFERER, $referer);
        }
        if ($ua) {
            curl_setopt($ch, CURLOPT_USERAGENT, $ua);
        } else {
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.167 Safari/537.36');
        }
        if ($nobaody) {
            curl_setopt($ch, CURLOPT_NOBODY, 1);
        }
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $ret = curl_exec($ch);
        curl_close($ch);
        return $ret;
    }

    /**
     * 新浪微博图床上传
     * [查看原图：http://ww2.sinaimg.cn/large/ + 获取到的pid 就能组合成图片的外链。]
     * @param $picurl
     * @param $cookie
     * @return string
     */
    function uploadpic($picurl, $cookie)
    {
        $res = Cache::remember($picurl, 30, function () use ($cookie, $picurl) {
            $ch = curl_init('http://picupload.service.weibo.com/interface/pic_upload.php?mime=image%2Fjpeg&data=base64&url=0&markpos=1&logo=&nick=0&marks=1&app=miniblog');
            curl_setopt_array($ch, [
                CURLOPT_POST => true,
                CURLOPT_VERBOSE => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => ["Cookie: $cookie"],
                CURLOPT_POSTFIELDS => ['b64_data' => base64_encode(file_get_contents($picurl))],
            ]);

            $res = curl_exec($ch);
            curl_close($ch);
            return $res;
        });
//        $ch = curl_init('http://picupload.service.weibo.com/interface/pic_upload.php?mime=image%2Fjpeg&data=base64&url=0&markpos=1&logo=&nick=0&marks=1&app=miniblog');
//        curl_setopt_array($ch, [
//            CURLOPT_POST => true,
//            CURLOPT_VERBOSE => true,
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_HTTPHEADER => ["Cookie: $cookie"],
//            CURLOPT_POSTFIELDS => ['b64_data' => base64_encode(file_get_contents($picurl))],
//        ]);
//
//        $res = curl_exec($ch);
//        curl_close($ch);

        $pos_num = strpos($res, '{');
        $result = json_decode(substr($res, $pos_num), true);

        return $result['data']['pics']['pic_1']['pid'] ?? '';
    }

    /**
     * 追加评论
     * @param $uid
     * @param $mid
     */
    public function comment($cookie, $uid, $mid, $content)
    {
        $url = 'https://weibo.com/aj/v6/comment/add?ajwvr=6&__rnd=1557314106423';
        $referer = 'https://weibo.com/baguawu/profile?rightmod=1&wvr=6&mod=personnumber&is_all=1';
        $post = [
            'act' => 'post',
            'mid' => $mid,
            'uid' => $uid,
            'content' => $content,
            'forward' => 0,
            'isroot' => 0,
            'location' => 'page_100505_home',
            'module' => 'scommlist',
            'group_source' => '',
            'pdetail' => '1005052429300863',
            '_t' => 0,
        ];

        $result = $this->curl($url, $post, '', $cookie, $referer);
        $data = json_decode($result, true);
        return (isset($data['code']) && $data['code']) == 100000;
    }


}