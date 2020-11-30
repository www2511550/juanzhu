<?php
/**
 * 好单裤api
 * User: chengcong
 * Date: 2018/11/18
 * Time: 上午11:19
 */
namespace App\Service;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Cache;

class HaodankuService
{
    use DispatchesJobs;

    public function __construct()
    {
        $this->appid = 'jam8jjjlp1nga8sswb';
        $this->secret = 'zuw8t4kejleeupygfe4qqnecltinkab3';
        $this->access_token = Cache::remember('accessToken1', 100, function () {
            return $this->getAccessToken();
        });
        $this->baseUrl = 'http://v2.api.haodanku.com';
        $this->appKey = 'juanzhuzhu';
        $this->pid = 'mm_47800736_21362628_72092261';
    }

    /**
     * accesstoken
     */
    public function getAccessToken()
    {
        $result = http(
            'http://wx330ab01f7ec591c2.97866.com/api/mag.token.json',
            ['appid' => $this->appid, 'secret' => $this->secret]
        );
        $arr = json_decode($result, true);
        return $arr['access_token'] ?: '';

    }

    /**
     * 搜索
     * @param $keyword
     */
    public function search($keyword)
    {
        $url = $this->baseUrl . '/supersearch/apikey/' . $this->appKey . '/keyword/' . urlencode(urlencode($keyword));
        $result = json_decode(http($url, []), true);
        return $result['data'] ?: [];
    }


    /**
     * 高佣金
     * https://www.haodanku.com/api/detail/show/15.html
     */
    public function highRate($itemid, $pid, $activityid = '')
    {
        $strCacheKey = 'rate:' . $itemid . ':' . $activityid;
        return Cache::remember($strCacheKey, 15 * 24 * 60, function () use ($itemid, $activityid, $pid) {
            $request_url = $this->baseUrl . '/ratesurl';
            $request_data['apikey'] = $this->appKey;
            $request_data['itemid'] = $itemid;
            $request_data['pid'] = $pid ?: $this->pid;
            $request_data['activityid'] = $activityid;
            $request_data['tb_name'] = 'chengcong0520';

            $res = http($request_url, $request_data, 'POST');
            $result = json_decode($res, true);
            return $result['data'] ?: [];
        });
    }


}