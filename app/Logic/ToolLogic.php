<?php
/**
 * Created by CC.
 * User: chengcong
 * Date: 2019/1/3
 * Time: 下午5:27
 */
namespace App\Logic;

use Illuminate\Support\Facades\Cache;

class ToolLogic
{

    /**
     * 高佣金转换
     * @param $itemId
     * @param $siteId
     * @param $adzoneId
     * @param $session
     */
    public function getHighRate($itemId, $siteId, $adzoneId, $session, $userId = 0)
    {
        $strCacheKey = 'tool1:highrate:' . $itemId . '-' . $siteId . '-' . $adzoneId . '-' . $session;
        $result = Cache::remember($strCacheKey, 24 * 60, function () use ($itemId, $siteId, $adzoneId, $session) {
            $url = 'http://gateway.kouss.com/tbpub/privilegeGet';
            $params = [
                "site_id" => $siteId,
                "adzone_id" => $adzoneId,
                "item_id" => $itemId,
                "session" => $session,
            ];
            return json_decode(http($url, $params, 'POST'), true);
        });;

        if (isset($result['result']['data']) && $data = $result['result']['data']) {
            $arrUrl = (new UrlLogic())->getShortUrl($data['coupon_click_url'], $userId);
            return ['status' => 1, 'info' => 'success', 'data' => [
                'coupon_url' => isset($arrUrl['data']['short_url']) ? $arrUrl['data']['short_url'] : $data['coupon_click_url'],
                'item_id' => $data['item_id'],
                'item_url' => $data['item_url'],
                'max_rate' => $data['max_commission_rate'].'%',
                'weibo_url' => isset($arrUrl['data']['url']) ? $arrUrl['data']['url'] : '',
            ]];
        }
        return ['status' => 0, 'info' => isset($result['sub_msg']) ? $result['sub_msg'] : '请求失败，稍后再试！'];
    }


    /**
     * 获取淘宝短链接
     * @param $url
     * @return array
     */
    public function getShortUrl($longUrl)
    {
        $strCacheKey = 'tool:shortUrl1:' . $longUrl;
        $result = Cache::remember($strCacheKey, 24 * 60, function () use ($longUrl) {
            $url = 'http://gateway.kouss.com/tbpub/spreadGet';
            $params = [
                'requests' => [
                    'url' => $longUrl
                ]
            ];
            return json_decode(http($url, $params, 'POST'), true);
        });
        if (isset($result['results']['tbk_spread']) && $data = $result['results']['tbk_spread']) {
            return ['status' => 1, 'info' => 'success', 'data' => [
                'url' => isset($data[0]['content']) ? $data[0]['content'] : ''
            ]];
        }else{ // 可能次数用完，使用另一个第三方
            $url = 'https://api.open.21ds.cn/apiv1/gettbshorturl';
            $params = [
                'apkey' => '5c42cb82-d83d-f473-1268-f65d14e8f62e',
                'url' => urlencode($longUrl),
            ];
            $result = json_decode(http($url, $params), true);
            if ($result['code'] == 200){
                return ['status' => 1, 'info' => 'success', 'data' => [
                    'url' => $result['data']
                ]];
            }
        }
        return ['status' => 0, 'info' => '请求失败，稍后再试！'];
    }

    /**
     * 创建淘口令
     * @return mixed
     */
    public function createTkl($text, $to_url, $logo)
    {
        $url = 'http://api.tkurl.top/Kl_Create';
        $params = [
            'appkey' => 'v2637EEi',
            'text' => $text,
            'url' => $to_url,
            'logo' => $logo,
        ];
        $result = json_decode(http($url, $params), true);
        if (isset($result['model'])){
            return ['status'=>1, 'tkl'=>$result['model']];
        }else{
            return ['status'=>0, 'info'=>isset($result['error_response']['sub_msg']) ? $result['error_response']['sub_msg'] : '淘口令生成失败！'];
        }
    }

    /**
     * 获取淘宝客订单
     * @param $start_time
     * @param $tbkSession
     */
    public function getTbOrder($start_time, $tbkSession)
    {
        $strKey = 'tborder:'.$start_time.':'.$tbkSession;
        return Cache::remember($strKey, 24*60, function () use($start_time, $tbkSession){
            $url = 'http://gateway.kouss.com/tbpub/orderGet';
            $params = [
                "fields" => "tb_trade_parent_id,tk_status,tb_trade_id,num_iid,item_title,item_num,price,pay_price,seller_nick,seller_shop_title,commission,commission_rate,unid,create_time,earning_time,tk3rd_pub_id,tk3rd_site_id,tk3rd_adzone_id,relation_id",
                "start_time" => date('Y-m-d H:i:s', strtotime($start_time)),
                "span" => 1200,
                "page_size" => 100,
                "tk_status" => 1,
                "order_query_type" => "create_time",
                "session" => $tbkSession
            ];
            $result = json_decode(http($url, $params, 'POST'), true);

            return isset($result['tbk_sc_order_get_response']['results']['n_tbk_order']) ? $result['tbk_sc_order_get_response']['results']['n_tbk_order'] : [];
        });
    }

    /**
     * 此API不需要授权，适用于在已知产品有优惠券情况下（比如产品列表页传参）可以直接调用。不适用于对无优惠券商品的转链
     * http://wsd.591hufu.com/doc
     * @param $url
     * @param $pid
     */
    public function getQuanUrlByPid($url, $pid, $isReturnInfo = 0)
    {
        $baseUrl = 'http://api.vephp.com/directhc';
        $params = [
            'vekey' => 'V00000836Y52123108',
            'para' => $url,
            'pid' => $pid,
            'detail' => 1,
        ];
        $result = json_decode(http($baseUrl, $params), true);
        if ($isReturnInfo){
            return isset($result['data']) ? $result['data'] : [];
        }
        return (isset($result['data']) && isset($result['data']['coupon_short_url'])) ? $result['data']['coupon_short_url'] : '';
    }

    /**
     * 【万能转链】高级高佣全转链接口（id,淘口令,链接转淘口令）： hcapi
     * 不能给其它人使用
     * @param $para
     */
    public function getGoodsInfo($para)
    {
        $baseUrl = 'http://api.vephp.com/hcapi';
        $params = [
            'vekey' => 'V00000836Y52123108',
            'para' => $para,
            'detail' => 1,
        ];
        $result = json_decode(http($baseUrl, $params), true);
        return isset($result['data']) ? $result['data'] : [];
    }

    /**
     * 获取单个商品信息
     * @param $goodsId
     */
    public function getOneGoods($goodsId)
    {
        $baseUrl = 'http://api.dataoke.com/index.php?r=port/index&appkey=268977f5ba&v=2&id='.intval($goodsId);
        $result = file_get_contents($baseUrl);
        $data = json_decode($result, true);
        return isset($data['result']) ? $data['result'] : [];
    }

}