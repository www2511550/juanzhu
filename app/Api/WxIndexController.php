<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2017/9/16
 * Time: 下午12:01
 */
namespace App\Api;


use App\Logic\CouponLogic;
use App\Logic\TaobaoLogic;
use App\Logic\WeixinLogic;
use App\Model\Category;
use App\Model\Coupon;
use App\Model\HotWord;
use App\Model\TbOrder;
use App\Model\User;
use App\Service\BaiduService;
use Illuminate\Http\Request;
use DB;

class WxIndexController extends BaseController
{

    public function index(WeixinLogic $weixinLogic)
    {
        $data = ['errno' => 0, 'data' => []];

        $data['data']['banner'] = $weixinLogic->getIndexBanner();
        $data['data']['channel'] = $weixinLogic->getIndexChannel();

        // 获取商品
        $coupon = Coupon::where('Quan_time', '>=', date('Y-m-d H:i:s'))->whereIn('Cid', [1,2,3,5,7,8,9,10])->orderBy('id', 'desc')->paginate(20);
        $data['data']['goodsList'] = [];
        if (count($coupon)) {
            foreach ($coupon as $vo) {
                $data['data']['goodsList'][] = $vo->formatWxapp($vo, 'wx');
            }
        }
        $data['data']['totalPages'] = $coupon->total();

        return response()->json($data);
    }


    public function detail(Request $request)
    {
        $data = ['errno' => 0, 'data' => []];
        $id = $request->get('id');
        $user_id = intval($request->get('user_id'));
        $coupon = Coupon::find($id);
        if (!$coupon->id) {
            $data['errno'] = 1;
            return response()->json($data);
        }

        $taobaoLogic = new TaobaoLogic();
        // 获取商品图集by 淘宝
        $goodsImages = [];//$taobaoLogic->getGoodsImages($coupon->GoodsID);
        if(!count($goodsImages)){
            $goodsImages[] = $coupon->Pic;
        }

//        if (!$coupon->taokouling) {
        if (0) {
            $strTaokouling = $taobaoLogic->taokouling($coupon->getQuanUrl($coupon, '', $user_id), $coupon->Title, $coupon->Pic . '_150x150.jpg');
            $strTaokouling && Coupon::where('id', $coupon->id)->update(['taokouling' => $strTaokouling]);
        } else {
            $strTaokouling = $coupon->taokouling;
        }
        $data['taokouling'] = $strTaokouling ?: '';
        $data['title'] = $data->Title;
        $data['img'] = $data->Pic . '_150x150.jpg';
        $data['data'] = [
            'info' => [
                'title' => $coupon->Title, 'price_info' => $coupon->Price, 'taokouling' => $strTaokouling,
                'intro' => $coupon->Introduce, 'quan_price' => $coupon->Quan_price, 'sale_num' => $coupon->Sales_num
            ],
            'gallery' => [

                ['img_url' => $goodsImages]
            ],
            'brand' => 'cccc',
            'attribute' => 'aaaaa',
            'issue' => 'aaaaa',
            'comment' => 'aaaaa',
            'brand' => 'aaaaa',
            'specificationList' => 'aaaaa',
            'productList' => 'aaaaa',
            'userHasCollect' => 'aaaaa',
        ];
        return response()->json($data);
    }

    public function lists(Request $request, CouponLogic $couponLogic)
    {
        $data = ['errno' => 0, 'data' => ['goodsList'=>[]]];
        $cid = $request->get('cid');
        $kw = $request->get('kw');
        $type = $request->type; // hot->热销，9.9->九块九专区
        $sort = $request->get('sort');

        if($kw){

            $arrCoupon = $couponLogic->getCouponIdsBySphinx($kw, $request->all());
            $data['data']['totalPages'] = $arrCoupon['total'];
            if(count($arrCoupon['ids']) > 0){
                foreach ($arrCoupon['ids'] as $coupon_id){
                    $coupon = Coupon::find($coupon_id);
                    $coupon && $data['data']['goodsList'][] = $coupon->formatWxapp($coupon, 'wx');
                }
            }

        }else{
            // 获取商品
            $objCoupon = Coupon::where('Quan_time', '>=', date('Y-m-d H:i:s'));
            $cid && $objCoupon = $objCoupon->where('cid', $cid);
            $kw && $objCoupon = $objCoupon->where('Title', 'like', '%'.$kw.'%');

            9.9 == $type && $objCoupon = $objCoupon->where('Price', '<=', 9.9);
            'hot' == $type && $objCoupon = $objCoupon->where('Price', '<', 20);
            'recom' == $type && $objCoupon = $objCoupon->where('Price', '<', 50)->whereIn('Cid', [1,2,5,7,8,10]);

            ('hot' == $type || 'sale' == $sort) && $objCoupon = $objCoupon->orderBy('Sales_num', 'desc');
            'price' == $sort && $objCoupon = $objCoupon->orderBy('Price', 'asc');
            'quan' == $sort && $objCoupon = $objCoupon->orderBy('Quan_price', 'desc');
            'recom' == $type &&  $objCoupon = $objCoupon->orderBy('Dsr', 'desc')->orderBy('Sales_num', 'desc');

            $coupon = $objCoupon->paginate(20);

            $data['data']['goodsList'] = [];
            if (count($coupon)) {
                foreach ($coupon as $vo) {
                    $data['data']['goodsList'][] = $vo->formatWxapp($vo, 'wx');
                }
            }

            $data['data']['totalPages'] = $coupon->total();
        }

        return response()->json($data);
    }

    /**
     * 详细页相关商品推荐
     */
    public function related(Request $request)
    {
        $data = ['errno' => 0, 'data' => []];
        $id = $request->get('id');
        $coupon = Coupon::find($id);
        if(0){
            if (DEV) {
                require_once(app_path('Util/sphinxapi.php'));
            }
            $sphinxSearch = new \SphinxClient();
            $sphinxSearch->SetServer('119.29.27.122', 9312);
            $sphinxSearch->SetArrayResult(true);
            $sphinxSearch->SetConnectTimeout(60);

            // 筛选条件
            $sphinxSearch->SetFilter("Cid", array($coupon->Cid));
            // 匹配模式，匹配所有查询词
            $sphinxSearch->SetMatchMode(SPH_MATCH_ANY);
            $sphinxSearch->SetLimits(0, 20, 100);
            // 匹配模式，匹配所有查询词
            $result = $sphinxSearch->Query($coupon->Title, 'mysql');

            if ($_GET['test']) {
                pre($result);
                pree($sphinxSearch);
            }
            if ($result['matches']) {
                foreach ($result['matches'] as $vo) {
                    $oneCoupon = Coupon::find($vo['id']);
                    if($oneCoupon->id){
                        $data['data']['goodsList'][] = $oneCoupon->formatWxapp($oneCoupon, 'wx');
                    }
                }
            }
        }else{
            $recomData = Coupon::where('Quan_time', '>=', date('Y-m-d H:i:s'))->where('Cid', $coupon->Cid)
            ->whereBetween('Price', [$coupon->Price*0.7, $coupon->Price*1.3])->orderBy('Sales_num', 'desc')->paginate(20);
            if(count($recomData)>0){
                foreach ($recomData as $vo){
                    $data['data']['goodsList'][] = $vo->formatWxapp($vo, 'wx');
                }
            }
        }

        return response()->json($data);
    }

    /**
     * 分类数据
     */
    public function catalog()
    {
        $data = ['errno' => 0, 'data' => []];

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
                $data['data']['cateList'][] = $cate->formatIndexCate($cate);
            }
        }

        return response()->json($data);
    }

    /**
     * 微信授权登陆
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginByWeixin(Request $request, WeixinLogic $weixinLogic)
    {
        $params = $request->all();
        $user_id = $weixinLogic->bindOpenid($params['code'], $params['userInfo']['userInfo']);
        $data['data'] = [
            'userInfo' => $params['userInfo']['userInfo'],
            'token' => $params['userInfo']['signature'],
            'code' => $params['code'],
            'user_id' => $user_id,
        ];

        return response()->json($data);
    }

    /**
     * 佣金订单列表
     */
    public function orderList(Request $request)
    {
        $data = ['errno'=>0];
        $user_id = intval($request->get('user_id'));
        $orderData = TbOrder::where('user_id', $user_id)->orderBy('g_time', 'desc')->paginate(8);
        $data['data']['orderList'] = [];
        if ($orderData){
            foreach ($orderData as $order){
                $data['data']['orderList'][] = $order->formatOrderList($order);
            }
        }
        $data['data']['total_money'] = TbOrder::where('user_id', $user_id)->where('status', 1)->sum('reward');
        $user = User::find($user_id);
        $data['data']['agent_status'] = $user->status;

        return response()->json($data);
    }

    /**
     * 奖励排行榜
     */
    public function rewardList()
    {
        $data = ['errno' => 0, 'data' => []];
        $arrName = [
            '*柠檬', '*紫幽香', '*葱逝去', '*剑东方', '*骄傲花', '*雪飞', '*ガ小子', '*莲茉茉', '*凝梦', '*色天竺'
        ];
        for ($i = 1; $i <= 10; $i++) {
            $data['data']['rewardList'][] = [
                'rank_id' => $i,
                'username' => $arrName[$i-1],
                'money' => 3000 - date('md') - $i*99 - $i*8 + date('d'),
                'avatar' => 'http://juanzhuzhu.com/avatar_'.$i.'.jpg',
            ];
        }

        return response()->json($data);
    }

    /**
     * 意见反馈收集
     * @param Request $request
     */
    public function feedBack(Request $request)
    {
        $content = $request->get('content');
        $moble = $request->get('mobile'); // 联系方式
        if(!$content || !$moble){
            return response()->json(['info'=>'内容或联系方式不能为空！']);
        }
        DB::table('feedback')->insert([
            'content' => $content,
            'mobile' => $moble,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        return response()->json(['error' => 0]);
    }

    /**
     * 查询是否是前50免费申请
     */
    public function applyAgent(Request $request)
    {
        $type = $request->get('type');
        $user = User::find(intval($request->get('user_id')));
        if ('select' == $type) {
            // 查询免费代理资格
            $errno = 1;
            if (!$user->id || $user->user_role != 2) {
                $agentCount = User::where('user_role', 2)->whereIn('status', [1, 5])->count();
                $agentCount < 50 && $errno = 0;
            }

            return response()->json(['errno'=>$errno]);

        } else {
            // 申请为代理
            if(!$user->id){
                return response()->json(['errno'=>1,'info'=>'请在会员中心登陆后再申请！']);
            }
            $user->user_role = 2;
            $user->status = 5;
            if(false === $user->save()){
                return response()->json(['errno'=>1,'info'=>'网络异常，稍后再试！']);
            }
            return response()->json(['errno'=>0,'info'=>'']);
        }
    }

    /**
     * 图片识别
     */
    public function image(Request $request)
    {
        $data = ['status' => 0, 'info' => '', 'data' => []];

        $type = $request->get('type');
        $imgUrl = $_FILES['img']['tmp_name'];
        if (!$imgUrl){
            $data['info'] = 'params error！';
            return response()->json($data);
        }

        if ($imgUrl) {
            $baiduService = new BaiduService($imgUrl);
            if ($baiduService->checkImg()) {
                $result = $baiduService->commom();
                if ($result) {
                    $data['status'] = 1;
                    $data['data']['name'] = $result['name'];
                }
            }
            if ($data['status'] != 1) $data['info'] = '上传失败，请重新尝试！';
        }

        return response()->json($data);
    }

}