<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 17/5/2
 * Time: 下午10:28
 */
namespace App\Api;

use App\Logic\CouponLogic;
use App\Model\Banner;
use App\Model\Category;
use App\Model\Coupon;
use Illuminate\Http\Request;

class QuanController extends BaseController
{

    /**
     * 菜单栏接口
     */
    public function menu(){
        $data = ['status'=>1, 'info'=>'', 'data'=>[]];
        $arrCate = Category::where('status', 1)->get()->toArray();
        if( $arrCate ) {
            foreach ($arrCate as $key => $cate){
                $data['data']['menu'][$key]['mid'] = $cate['cid'];
                $data['data']['menu'][$key]['title'] = $cate['c_name'];
            }
            array_unshift($data['data']['menu'], ['mid'=>'0', 'title'=>'今日上新']);
        }
        return response()->json($data);
    }

    /**
     * 列表页接口
     */
    public function lists(Request $request, CouponLogic $couponLogic){
        $data = ['status'=>1, 'info'=>'', 'data'=>[]];
        // 参数处理
        $cid = $request->get('mid');
        $kw = $request->get('kw');
        $sort = strtolower($request->get('s'));
        $order = $request->get('o');
        $page = $request->get('p', 1);
        $pageSize = 20;

        // 获取banner数据
        $data['banner'] = $this->getBannerData($cid);
        // 获取数据
        $objCoupon = Coupon::where('Quan_time', '>=', date('Y-m-d H:i:s'));
//        $objCoupon = new Coupon;
        if( $cid ){
            $objCoupon = $couponLogic->getCidConditon($cid, $objCoupon);
        }
        if( $kw ) {
            $arrKw = explode(' ', $kw);
            if ( $kw ) {
                foreach ($arrKw as $val) {
                    $val && $objCoupon->where('Title','like', '%'.$val.'%');
                }
            }
        }
        $data['totalRecord'] = $objCoupon->count();
        // 排序
        $arrOrder = ['price' => 'Price', 'sale' => 'Sales_num', 'discount' => 'Quan_price'];
        if ($arrOrder[$order]) {
            $s = 'asc' == $sort ? 'asc' : 'desc';
            $objCoupon->orderBy($arrOrder[$order], $s);
        }else{
            $objCoupon->orderBy('id', 'desc');
        }
        $skip = ($page - 1) * $pageSize;
        $arrData = $objCoupon->skip($skip)->take($pageSize)->get();
        $data['page'] = ceil($data['totalRecord']/$pageSize);

        $data['data']['list'] = [];
        if( $arrData ){
            foreach ( $arrData as $key => $val){
                $data['data']['list'][$key] = $val->formatApilistData($val);
            }
        }

        return response()->json($data);
    }

    /**
     * 获取app banner数据
     */
    public function getBannerData($cid = 0)
    {
        $data = [];
        $defaultData = array(
            array('title' => '韩都衣舍旗舰店', 'img_url' => 'http://juanzhuzhu.com/wap/imgs/handu.jpeg', 'toUrl' => 'https://handuyishe.tmall.com/shop/view_shop.htm?user_number_id=263817957&ali_trackid=2%3Amm_47800736_13948422_56422521%3A1488636329_3k5_1984535979'),
            array('title' => '劲霸男装旗舰店', 'img_url' => 'http://juanzhuzhu.com/wap/imgs/jinba.jpeg', 'toUrl' => 'https://kboxing.tmall.com/shop/view_shop.htm?user_number_id=645371883&ali_trackid=2%3Amm_47800736_13948422_56422521%3A1488636514_3k4_1520347781'),
            array('title' => '兰蔻官方旗舰店', 'img_url' => 'http://juanzhuzhu.com/wap/imgs/lankou.jpeg', 'toUrl' => 'https://lancome.tmall.com/shop/view_shop.htm?user_number_id=2360209412&ali_trackid=2%3Amm_47800736_13948422_56422521%3A1488636557_3k3_1885765926'),
        );
        $banner = Banner::where('status', 1)->where('cid', intval($cid))->get();
        if ($banner) {
            foreach ($banner as $key => $vo) {
                $data[$key] = $vo->formatBanner($vo, 'app');
            }
        }
        $data = $data ? $data : $defaultData;

        return $data;
    }

}