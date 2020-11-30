<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2017/9/20
 * Time: 下午11:27
 */
namespace App\Api;

use App\Logic\AppLogic;
use App\Logic\CouponLogic;
use App\Logic\IndexLogic;
use App\Logic\TaobaoLogic;
use App\Model\Category;
use App\Model\Coupon;
use App\Model\HotWord;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;


class IndexController extends BaseController
{
    /**
     * app首页接口
     */
    public function index(Request $request,AppLogic $appLogic)
    {
        $data = ['status'=>1, 'info'=>'success!'];
        $user_id = $request->get('user_id');

        // 1、识别用户身份，新人(1)或老用户(0)
        if ($user_id) {
            $created_at = User::where('id', $user_id)->value('created_at');
            $is_old_user = time() - strtotime($created_at) > 30 * 24 * 3600;
        }
        $data['new_user'] = $is_old_user ? 0 : 1;
        $data['data']['division'] = [
            ['type' => '3', 'list_type' => '', 'title' => '签到', 'url' => '', 'img' => __ROOT__ . '/images/index_3.png'],
            ['type' => '2', 'list_type' => '1', 'title' => '一元起购', 'url' => '', 'img' => __ROOT__ . '/images/index_2.png'],
            ['type' => '1', 'list_type' => '', 'title' => '邀请送话费', 'url' => __ROOT__ . '/home/activity/friend', 'img' => __ROOT__ . '/images/index_1.png'],
        ];

        // 2、获取首页banner
        $data['data']['banner'] = $appLogic->getIndexBanner();

        // 3、获取排行榜和9.9图片
        $couponLogic = new CouponLogic();
        $data['data']['rank'] = $couponLogic->getRankData();

        return response()->json($data);
    }

    /**
     * 有券头条
     */
    public function news(AppLogic $appLogic)
    {
        $data = ['status'=>1, 'info'=>'success!'];
        $data['data'] =  $appLogic->getNewsData();

        return response()->json($data);
    }

    /**
     * 获取分类
     * $params type 1-带图片
     */
    public function category(Request $request)
    {
        $data = ['status' => 1, 'info' => 'success!'];
        $type = $request->type ?: 0;

        $data['data'] = Category::getArrCate($type);

        return response()->json($data);
    }

    /**
     * 列表数据
     */
    public function lists(Request $request,CouponLogic $couponLogic)
    {
        $data = ['status'=>1, 'info'=>'success!'];
        $type = $request->type; // 1->1元起购，9.9->九块九专区，top->排行榜专区
        $cid = $request->cid ?: 0;
        $page = intval($request->page) ?: '1';
        $limit = 20;

        // 缓存
//        $strKey = 'searchList_'.$type.'_'.$cid.'_'.$page.'_'.$limit;
//        if(Cache::has($strKey)) return  response()->json(Cache::get($strKey));

        // 获取数据
        $data['data']['list'] = [];
        $couponData = $couponLogic->getListData([
            'type' => $type,
            'cid' => $cid,
            'limit' => $limit
        ]);
        if(count($couponData)){
            foreach ($couponData as $coupon){
                $data['data']['list'][] = $coupon->formatApiData($coupon);
            }
        }
        $data['totalRecord'] = $couponData->total();
        $data['totalPage'] = ceil($data['totalRecord']/$limit);
        $data['page'] = $page;

//        Cache::put($strKey, $data, 5);

        return  response()->json($data);

    }

    /**
     * 外部公共搜索入口
     */
    public function searchList(Request $request, IndexLogic $indexLogic)
    {
        $page_size = $request->get('page_size') ?: 24;
        $result = $indexLogic->searchList($request->all(), $page_size);
        if (count($result['ids']) > 0) {
            $data['data'] = Coupon::whereIn('id', $result['ids'])->get();
        }
        $data['total'] = $result['total'];

        return $data;
    }

    /**
     * 搜索列表
     * @param Request $request
     */
    public function search(Request $request)
    {
        $data = ['status' => 1, 'info' => ''];
        $words = $request->words ?: '';
        $sort = $request->sort ?: 'sale';
        $order = intval($request->order) ?: 0;
        $cid = $request->get('cid');
        $page = intval($request->page) ?: 1;
        $device = strtolower($request->get('device', ''));
        $limit = intval($request->get('page_size', 20));

        // 缓存
//        $strKey = 'searchList_'.$words.'_'.$cid.'_'.$sort.'_'.$order.'_'.$page.'_'.$limit;
//        if(Cache::has($strKey)) return  response()->json(Cache::get($strKey));

        $arrSort = ['sale' => 'Sales_num', 'price' => 'Price', 'quan' => 'Quan_price', 'dsr' => 'Dsr'];
        $strSort = $arrSort[$sort] ?: 'Sales_num';
        if('android'==$device){
            $strOrder = 1 == $order ? 'desc' : 'asc';
        }else{
            $strOrder = 0 == $order ? 'desc' : 'asc';
        }

        $objCoupon = Coupon::where('Quan_time', '>=', date('Y-m-d H:i:s'));

        $cid && $objCoupon = $objCoupon->where('cid', $cid);

        $arrWord = array_filter(explode(' ', $words));
        if ($arrWord) {
            foreach ($arrWord as $word) {
                $objCoupon = $objCoupon->where('Title', 'like', '%' . $word . '%');
            }
        }

        // 获取数据
        $data['data']['list'] = [];
        $couponData = $objCoupon->orderBy($strSort, $strOrder)->paginate($limit);
        if (count($couponData)) {
            foreach ($couponData as $coupon) {
                $data['data']['list'][] = $coupon->formatApiData($coupon);
            }
        }
        $data['totalRecord'] = $couponData->total();
        $data['totalPage'] = ceil($data['totalRecord'] / $limit);
        $data['page'] = $page;

//        Cache::put($strKey, $data, 5);

        return response()->json($data);
    }

    /**
     * 搜索词推荐
     */
    public function searchName()
    {
        $data = ['status' => 1, 'info' => '', 'data' => []];
        // 三组，随机取一组数据
        $num = rand(1, 3);
        $hotData = HotWord::where('type', $num)->get();
        if (count($hotData) > 0) {
            foreach ($hotData as $hot) {
                $data['data'][] = $hot->name;
            }
        }

        return response()->json($data);
    }

    /**
     * 首页搜索数据
     */
    public function indexSearch()
    {
        $data = ['status' => 1, 'info' => '', 'data' => []];

        // 1、热门搜索
        $data['data']['hotName'] = [];
        $hotData = HotWord::orderBy('updated_at')->take(10)->get();
        if (count($hotData) > 0) {
            foreach ($hotData as $hot) {
                $data['data']['hotName'][] = $hot->name;
            }
        }

        // 2、分类筛选
        $category = Category::where('status',1)->get();
        if(count($category)>0){
            foreach ($category as $cate){
                if($cate->cid > 8) continue; // 男装和内衣合并到女装服饰
                $data['data']['cate'][] = $cate->formatIndexCate($cate);
            }
        }

        return response()->json($data);
    }

    /**
     * 商品详细页
     * @param Request $request
     */
    public function detail(Request $request, AppLogic $appLogic)
    {
        $data = ['status'=>1, 'info'=>'', 'data'=>[]];
        $id = $request->get('id');

        $coupon = Coupon::find($id);
        if(!$coupon->id){
            $data['status'] =0;
            $data['info'] = '商品不存在或者已下架！';
            return response()->json($data);
        }
        $taobaoLogic = new TaobaoLogic();
        $data['data'] = $appLogic->getDetailData($coupon, $taobaoLogic);

        return response()->json($data);
    }

}