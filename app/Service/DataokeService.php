<?php
/**
 * 大淘客开放平台
 * http://www.dataoke.com/pmc/apply-d.html?id=76
 * User: chengcong
 * Date: 2019/5/7
 * Time: 3:30 PM
 */

namespace App\Service;


class DataokeService
{

    public function __construct()
    {
        $this->app_secret = '2ae5316c4174c7e9422eb937c5f208f2';
        $this->app_key = '5cd12cdc68386';
        $this->base_url = 'https://openapi.dataoke.com';
    }


    /**
     * 参数加密
     * @param $data
     * @param $appSecret
     * @return string
     */
    public function makeSign($data, $appSecret)
    {
        ksort($data);
        $paramStr = http_build_query($data);
        $sign = strtoupper(md5($paramStr . '&key=' . $appSecret));
        return $sign;
    }

    /**
     * 商品列表
     */
    public function getGoodsList()
    {
        $host = $this->base_url.'/api/goods/get-goods-list';
        $data = [
            'appKey' => $this->app_key,
            'version' => 'v1.0.0',
            'pageId' => 1,
        ];
        // 加密参数
        $data['sign'] = $this->makeSign($data, $this->app_secret);
        //拼接请求地址
        $url = $host .'?'. http_build_query($data);
        $result = json_decode(file_get_contents($url), true);

        $data = [
            'status' => $result['code'] == 0 ? 1 : 0,
            'info' => $result['msg'] ?? '',
            'data' => $result['data']['list'] ?? [],
            'total' => $result['data']['totalNum'] ?? 0
        ];

        return $data;

    }

}