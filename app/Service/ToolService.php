<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2018/12/12
 * Time: 下午10:20
 */
namespace App\Service;


use Illuminate\Support\Facades\Cache;

class ToolService
{

    public $tkurl_appkey, $tkurl_baseUrl;

    public function __construct()
    {
        $this->tkurl_appkey = 'v2637EEi';   // 第三方appkey，http://api.tkurl.top
        $this->tkurl_baseUrl = 'http://api.tkurl.top';
    }

    /**
     * 生成短链接
     * @param $longUrl
     * @param string $user_id
     * @return array
     */
    public function getShortUrl($longUrl)
    {
        $cacheKey = 'spread:' . substr(md5($longUrl), -8);
        return Cache::remember($cacheKey, 3 * 24 * 60, function () use ($longUrl) {
            $url = $this->tkurl_baseUrl . '/spread?appkey=' . $this->tkurl_appkey . '&url=' . urlencode($longUrl);
            $result = http($url, []);
            $data = json_decode($result, true);
            return isset($data['content']) ? $data['content'] : '';
        });
    }


    /**
     * sclick解析
     * @param $sclickUrl
     */
    public function sclicktoid($sclickUrl)
    {
        $url = 'https://api.open.21ds.cn/apiv1/sclicktoid';
        $params = [
            'apkey' => '5c42cb82-d83d-f473-1268-f65d14e8f62e',
            'sclickurl' => $sclickUrl,
        ];
        $result = http($url, $params);
        $data = json_decode($result, true);
        return isset($data['data']) ? $data['data'] : '';
    }

}