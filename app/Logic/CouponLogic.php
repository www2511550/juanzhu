<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 17/4/28
 * Time: 下午11:05
 */
namespace App\Logic;

use App\Model\Config;
use App\Model\Coupon;
use Carbon\Carbon;
use DB;

class CouponLogic{

    public function __construct()
    {
        $this->pid = 'mm_47800736_21362628_72092261';
    }

    /**
     * 获取列表数据
     * @param $params
     */
    public function getListData($params)
    {
        $cid = $params['cid'];
        $type = $params['type'];
        $limit = $params['limit'];
        if (DEV) {
            $objCoupon = new Coupon();
        } else {
            $objCoupon = Coupon::where('Quan_time', '>=', date('Y-m-d H:i:s'));
        }

        // 分类
        $cid && $objCoupon = $objCoupon->where('cid', $cid);

        '9.9' == $type && $objCoupon = $objCoupon->where('Price', '<=', 9.9)->orderBy('Price', 'asc');

        1 == $type && $objCoupon = $objCoupon->where('Price', '<=', 49.9)->orderBy('Price', 'asc');

//        'top' == $type && $objCoupon = $objCoupon->orderBy('Sales_num', 'desc');

        return $couponData = $objCoupon->orderBy('Sales_num', 'desc')->paginate($limit);
    }

    /**
     * 获取排行榜数据
     * @return array
     */
    public function getRankData()
    {
        // 1、获取列表的第一件商品信息做排行榜信息，公用列表页缓存
        $firstData = $this->getListData(['type'=>9.9,'limit'=>1]);
        $secondData = $this->getListData(['type'=>'top','limit'=>1]);

        $data = [
            [
                'name' => '九块九',
                'intro' => $firstData[0]['Title'] ? mb_substr(trim($firstData[0]['Title']), 0, 7, 'utf8') : '汇聚热卖尖货',
                'type' => '9.9',
                'img_url' => Coupon::getImgUrl($firstData[0]['Pic']) . '_150x150.jpg' ?: __ROOT__ . '/images/9_9.png'
            ],
            [
                'name' => '排行榜',
                'intro' => $secondData[0]['Title'] ? mb_substr(trim($secondData[0]['Title']), 0, 7, 'utf8') : '吃货小天堂',
                'type' => 'top',
                'img_url' => Coupon::getImgUrl($secondData[0]['Pic']) . '_150x150.jpg' ?: __ROOT__ . '/images/rank.png'
            ],
        ];

        return $data;
    }

    /**
     * 处理大淘客接口数据
     * @param $data
     */
    public function dealDataokeData($data){
        if( $data ){
            $taobaoLogic = new TaobaoLogic();
            $couponModel = new Coupon();
            foreach ( $data as $val){
                $record = Coupon::where('GoodsID', $val['GoodsID'])->first();

                // 优惠卷链接拼接
                $coupon_url = $couponModel->getQuanUrl($val);
                $insertData['taokouling'] = $taobaoLogic->taokouling($coupon_url, $val['Title'], $val['Pic'].'_150x150.jpg');
                $insertData['Title'] = $val['Title'];
                $insertData['Dsr'] = $val['Dsr'];
                $insertData['Commission_queqiao'] = $val['Commission_queqiao'];
                $insertData['Quan_receive'] = $val['Quan_receive'];
                $insertData['Quan_price'] = $val['Quan_price'];
                $insertData['Quan_time'] = $val['Quan_time'];
                $insertData['Jihua_link'] = $val['Jihua_link'];
                $insertData['Price'] = $val['Price'];
                $insertData['Jihua_shenhe'] = $val['Jihua_shenhe'];
                $insertData['Introduce'] = $val['Introduce'];
                $insertData['Cid'] = $val['Cid'];
                $insertData['Sales_num'] = $val['Sales_num'];
                $insertData['Quan_link'] = $val['Quan_link'];
                $insertData['IsTmall'] = $val['IsTmall'];
                $insertData['GoodsID'] = $val['GoodsID'];
                $insertData['Commission_jihua'] = $val['Commission_jihua'];
                $insertData['Que_siteid'] = $val['Que_siteid'];
                $insertData['Commission'] = $val['Commission'];
                $insertData['Pic'] = $val['Pic'];
                $insertData['Org_Price'] = $val['Org_Price'];
                $insertData['Quan_m_link'] = $val['Quan_m_link'];
                $insertData['Quan_id'] = $val['Quan_id'];
                $insertData['Quan_condition'] = $val['Quan_condition'];
                $insertData['Quan_surplus'] = $val['Quan_surplus'];
                $insertData['SellerID'] = $val['SellerID'];

                if ($record){
                    Coupon::where('GoodsID', $val['GoodsID'])->update($insertData);
                }else{
                    $insertData['created_at'] = $insertData['updated_at'] = Carbon::now();
                    Coupon::insert($insertData);
                }
            }
        }
        return true;
    }

    /**
     * 存储到卷猪数据库
     * @param $data
     */
    public function toJuanzhu($data){
        if( $data ){
            $objJuanzhuzhu = DB::connection('juanzhuMysql')->table('coupon');
            $arrCate = [
                1 => '10',
                2 =>'6',
                3 => '7',
                4 => '13',
                5 => '15',
                6 => '1',
                7 => '16',
                8 => '20',
                9 => '18',
                10 => '24',
            ];
            foreach ( $data as $val){
                $record = $objJuanzhuzhu->where('gid', $val['GoodsID'])->first();
                $quan_url = "https://uland.taobao.com/coupon/edetail?activityId=".$val['Quan_id']."&itemId=".$val['GoodsID']."&pid=mm_47800736_21362628_72092261";

                $insertData['gid'] = $val['GoodsID'];
                $insertData['cate_id'] = $arrCate[$val['Cid']];
                $insertData['g_name'] = $val['Title'];
                $insertData['img_url'] = $val['Pic'];
                $insertData['detail_url'] = "http://item.taobao.com/item.htm?id=".$val['GoodsID'];
                $insertData['shop_name'] = '';
                $insertData['price'] = $val['Org_Price'];
                $insertData['sale_num'] = $val['Sales_num'];
                $insertData['money_rate'] = $val['Commission'];
                $insertData['money'] = $val['Commission']*$val['Price']/100;
                $insertData['coupon_url'] = $insertData['money_url'] = $quan_url;
                $insertData['coupon_total'] = $val['Quan_receive']+$val['Quan_surplus'];
                $insertData['start_time'] = time();
                $insertData['end_time'] = strtotime($val['Quan_time']);
                $insertData['look_num'] = rand(10,100);
                $insertData['quan_money'] = $val['Quan_price'];
                $record ? $objJuanzhuzhu->where('gid', $val['GoodsID'])->update($insertData) : $objJuanzhuzhu->insert($insertData);
            }
        }
        return true;
    }

    /**
     * cid条件
     */
    public function getCidConditon($cid, $objCoupon){
        switch ($cid){
            case '9.9':
                $objCoupon->where('Price', '<', 10);
                break;
            case '19.9':
                $objCoupon->whereBetween('Price', [10, 19.9]);
                break;
            case '666':  //小编推荐
                $objCoupon->whereBetween('Price', [10, 50])->orderBy('Sales_num', 'desc');
                break;
            default:
                $objCoupon->where('cid', $cid);
        }
        return $objCoupon;
    }

    /**
     * 存取惠喵api接口数据
     * @param $data
     */
    public function dealHuiMiaoData($data){
        $taobaoLogic = new TaobaoLogic();
        foreach ($data as $val){
            // 通过链接获取goods_id
            $arrGoodId = explode('=', $val['url']);
            $goods_id = $arrGoodId[1];
            $record = Coupon::where('Quan_time', '>=', date('Y-m-d H:i:s'))->where('GoodsID', $goods_id)->first();
            if($record) continue;

            // 分解获取券链接上参数
            $quanInfo = $this->getQuanUrlByOthers($val['ticket']);
            $quan_url = $quanInfo['url'];
            $taokouling = $taobaoLogic->taokouling($quan_url, $val['title'], $val['img']);
            $insertData['taokouling'] = $taokouling ? $taokouling : '';
            $insertData['Title'] = $val['title'];
            $insertData['Dsr'] = rand(4.6,4.8);
            $insertData['Commission_queqiao'] = 0;
            $insertData['Quan_receive'] = 10;
            $insertData['Quan_price'] = intval($val['value']);
            $insertData['Quan_time'] = date('Y-m-d H:i:s', strtotime('6 day'));
            $insertData['Jihua_link'] = '';
            $insertData['Price'] = $val['price'];
            $insertData['Jihua_shenhe'] = 0;
            $insertData['Introduce'] = $val['title'];
            $insertData['Cid'] = 0;
            $insertData['Sales_num'] = intval(mb_substr($val['receive'], 2, 5));
            $insertData['Quan_link'] = $quan_url;
            $insertData['IsTmall'] = strpos($val['url'], 'tmall') ? 1 :0;
            $insertData['GoodsID'] = $goods_id;
            $insertData['Commission_jihua'] = '';
            $insertData['Que_siteid'] = $val['Que_siteid'];
            $insertData['Commission'] = rand(20,40);
            $insertData['Pic'] = $val['img'];
            $insertData['Org_Price'] = $val['price'] + intval($val['value']);
            $insertData['Quan_m_link'] = $quan_url;
            $insertData['Quan_id'] = $quanInfo['Quan_id'];
            $insertData['Quan_condition'] = '';
            $insertData['Quan_surplus'] = 100;
            $insertData['SellerID'] = 0;

            $record ? Coupon::where('GoodsID', $val['GoodsID'])->update($insertData) : Coupon::insert($insertData);
        }
        return true;
    }

    /**
     * 分解别人优惠卷链接转换成自己的
     * @param $url
     */
    public function getQuanUrlByOthers($url, $typ = 1)
    {
        $data = [];
        if (2 == $typ) { // 更换链接上的pid
            $arrUrl = explode('&',$url);
            foreach ($arrUrl as $key => $str){
                if(0===strpos($str,'pid')){
                    $arrUrl[$key] = 'pid='.$this->pid;
                }
            }
            $data['url'] = implode('&', $arrUrl);
        } else {
            $arrParams = explode('=', $url);
            $data['Quan_id'] = substr($arrParams[1], 0, -4);
            $data['url'] = $arrParams[0] . '=' . $arrParams[1] . '=' . $this->pid . '&itemId=' . $arrParams[3];
        }
        return $data;
    }

    /**
     * 处理省钱快报数据
     * @param $data
     */
    public function dealibantang($data, $cid = 1){
        $taobaoLogic = new TaobaoLogic();
        foreach ($data as $val){
            $goods_id = $val['item_id'];
            $record = Coupon::where('Quan_time', '>=', date('Y-m-d H:i:s'))->where('GoodsID', $goods_id)->first();
            if($record) continue;

            // 分解获取券链接上参数
            $quanInfo = $this->getQuanUrlByOthers($val['url'], 2);
            $quan_url = $quanInfo['url'];
            $taokouling = $taobaoLogic->taokouling($quan_url, $val['title'], $val['thumbnail_pic']);
            $insertData['taokouling'] = $taokouling ? $taokouling : '';
            $insertData['Title'] = $val['title'];
            $insertData['Dsr'] = rand(4.6,4.8);
            $insertData['Commission_queqiao'] = 0;
            $insertData['Quan_receive'] = 10;
            $insertData['Quan_price'] = intval($val['gap_price']);
            $insertData['Quan_time'] = date('Y-m-d H:i:s', $val['coupon_end_time']);
            $insertData['Jihua_link'] = '';
            $insertData['Price'] = $val['coupon_price'];
            $insertData['Jihua_shenhe'] = 0;
            $insertData['Introduce'] = $val['description'] ? $val['description'] : $val['title'];
            $insertData['Cid'] = $cid;
            $insertData['Sales_num'] = intval($val['month_sales']);
            $insertData['Quan_link'] = $quan_url;
            $insertData['IsTmall'] = rand(0,1);
            $insertData['GoodsID'] = $goods_id;
            $insertData['Commission_jihua'] = '';
            $insertData['Que_siteid'] = '';
            $insertData['Commission'] = rand(20,40);
            $insertData['Pic'] = $val['thumbnail_pic'];
            $insertData['Org_Price'] = $val['raw_price'];
            $insertData['Quan_m_link'] = $quan_url;
            $insertData['Quan_id'] = '';
            $insertData['Quan_condition'] = '';
            $insertData['Quan_surplus'] = 100;
            $insertData['SellerID'] = 0;
            $insertData['create_at'] = date('Y-m-d H:i:s');
            !$record && $insertData['updated_at'] = date('Y-m-d H:i:s');

            $record ? Coupon::where('GoodsID', $val['GoodsID'])->update($insertData) : Coupon::insert($insertData);
        }
        return true;
    }

    /**
     * sphinx搜索
     * @param $search
     */
    public function getCouponIdsBySphinx($search, $condition = [], $limit = 20)
    {
        $data = [];
        // 基本参数
        $cid = $condition['cid'];
        $c_check = $condition['c_check'];
        $cr_min = $condition['cr_min'];
        $cr_max = $condition['cr_max'];
        $p_min = $condition['p_min'];
        $p = $condition['page'] ?: 1;
        $order = $condition['order'];

        if (DEV) {
            require_once(app_path('Util/sphinxapi.php'));
        }
        $sphinxSearch = new \SphinxClient();
        $sphinxSearch->SetServer('119.29.27.122', 9312);
        $sphinxSearch->SetArrayResult(true);
        $sphinxSearch->SetConnectTimeout(60);

        // 筛选条件
        $cid && $sphinxSearch->SetFilter("Cid", array($cid));

        1 == $c_check && $p_max = 9.9;
        3 == $c_check && $sphinxSearch->SetFilter("IsTmall", array(1));
        $p_min && $p_max && $sphinxSearch->SetFilterFloatRange("Price", (float)$p_min, (float)$p_max);
        $cr_min && $cr_max && $sphinxSearch->SetFilterFloatRange("Commission", (float)$cr_min, (float)$cr_max);

        // 排序
        switch ($order) {
            case 'price_down':
                $sphinxSearch->SetSortMode(SPH_SORT_ATTR_ASC, 'Price');
                break;
            case 'price_up':
                $sphinxSearch->SetSortMode(SPH_SORT_ATTR_DESC, 'Price');
                break;
            case 'sale':
                $sphinxSearch->SetSortMode(SPH_SORT_ATTR_DESC, 'Sales_num');
                break;
            case 'save':
                $sphinxSearch->SetSortMode(SPH_SORT_ATTR_DESC, 'Quan_price');
                break;
            default:
                $sphinxSearch->SetSortMode(SPH_SORT_ATTR_DESC, 'ids');
        }

        // 匹配模式，匹配所有查询词
        $sphinxSearch->SetMatchMode(SPH_MATCH_ALL);
        $sphinxSearch->SetLimits($limit * ($p - 1), $limit, 100);
        // 匹配模式，匹配所有查询词
        $result = $sphinxSearch->Query($search, 'mysql');

        if ($result['matches']) {
            foreach ($result['matches'] as $vo) {
                $data['ids'][] = $vo['id'];
            }
        }
        $data['total'] = $result['total_found'];

        return $data;
    }
}