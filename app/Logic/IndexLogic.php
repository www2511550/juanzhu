<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2017/12/18
 * Time: 下午10:20
 */
namespace App\Logic;

use App\Model\Coupon;

class IndexLogic
{
    /**
     * 首页搜索
     * @param $params
     * @param int $limit
     * @return array
     */
    public function searchList($params, $limit = 24)
    {
        $data = ['ids'=>[]];
        // 基本参数
        $cid = $params['cid'] ?: 0;
        $mid = $params['mid'] ?: 0; // 菜单栏id
        $search = $params['kw'];
        $sort = $params['sort'];
        $price = $params['price']; // 券价格
        $p = $params['page'] ?: 1;
        $p_min = $params['p_min'];
        $p_max = $params['p_max'];

        try {
            if (DEV) {
                require_once(app_path('Util/sphinxapi.php'));
            }
            $sphinxSearch = new \SphinxClient();
            $sphinxSearch->SetServer('119.29.27.122', 9312);
            $sphinxSearch->SetArrayResult(true);
            $sphinxSearch->SetConnectTimeout(60);

            // 筛选条件
            $cid && $sphinxSearch->SetFilter("Cid", array($cid));
            // 价格
            if ($p_min || $p_max){
                $p_min = $p_min ?: 0;
                $p_max = $p_max ?: 999999;
                $sphinxSearch->SetFilterFloatRange('Price', (float)$p_min, (float)$p_max);
            }else{
                $arrPrice = ['9.9' => [0, 9.9], '20' => [10, 20]];
                $arrPrice[$mid] && $sphinxSearch->SetFilterFloatRange('Price', (float)$arrPrice[$mid][0], (float)$arrPrice[$mid][1]);
            }
            // 优惠券筛选
            $arrQuan = [10 => [0, 10], 20 => [10, 20], 50 => [20, 50], 100 => [50, 1000]];
            $arrQuan[$price] && $sphinxSearch->SetFilterFloatRange("Quan_price", (float)$arrQuan[$price][0], (float)$arrQuan[$price][1]);

            // 排序
            $arrSort = ['default' => 'ids', 'new' => 'Quan_time', 'volume' => 'Sales_num'
                , 'price' => 'Price', 'quan' => 'Quan_price', 'surplus' => 'Sales_num'];
            $strSort = $arrSort[$sort] ?: 'ids';
            $sphinxSearch->SetSortMode((in_array($sort, ['volume', 'quan']) ? SPH_SORT_ATTR_DESC : SPH_SORT_ATTR_ASC), $strSort);

            // 匹配模式，匹配所有查询词
            $sphinxSearch->SetMatchMode(SPH_MATCH_ALL);
            $sphinxSearch->SetLimits($limit * ($p - 1), $limit, 100);
            // 匹配模式，匹配所有查询词
            $result = $sphinxSearch->Query($search, 'mysql');
            if (isset($_GET['test'])){
                pre($sphinxSearch);
                pre($result);die;
            }

        } catch (\Exception $exception) {
            $result = array('matches'=>[], 'total_found' => 0);
        }

        if ($result['matches']) {
            foreach ($result['matches'] as $vo) {
                $data['ids'][] = $vo['id'];
            }
        }
        $data['total'] = $result['total_found'];

        return $data;
    }

    /**
     * 获取首页数据
     * @param $params
     * @return mixed
     */
    public function getIndexData($params)
    {
        // 基本参数
        $cid = $params['cid'] ?: 0;
        $mid = $params['mid'] ?: 0; // 菜单栏id
        $sort = $params['sort'];
        $price = $params['price']; // 券价格

        $objCoupon = Coupon::where('Quan_time', '>=', date('Y-m-d H:i:s'));
        $cid && $objCoupon->where('cid', $cid);
        $arrPrice = ['9.9' => [0, 9.9], '20' => [10, 20]];
        $arrPrice[$mid] && $objCoupon->whereBetween('Price', $arrPrice[$mid]);
        // 优惠券筛选
        $arrQuan = [10 => [0, 10], 20 => [10, 20], 50 => [20, 50], 100 => [50, 1000]];
        $arrQuan[$price] && $objCoupon->whereBetween('Quan_price', $arrQuan[$price]);

        $arrSort = ['default' => 'id desc', 'new' => 'Quan_time desc', 'volume' => 'Sales_num desc'
            , 'price' => 'Price desc', 'quan' => 'Quan_price desc', 'surplus' => 'Quan_receive desc'];
        $strSort = $arrSort[$sort] ?: 'id desc';

        return $objCoupon->orderByRaw($strSort)->paginate(24);
    }

}