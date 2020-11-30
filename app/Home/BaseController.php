<?php
/**
 * Created by Chengcong.
 * Date: 2017/4/13 17:43
 */
namespace App\Home;

use App\Http\Controllers\Controller;
use App\Model\Banner;

class BaseController extends Controller{

    public function __construct()
    {
        view()->share('pid', 'mm_47800736_21362628_72092261');
    }


    /**
     * 获取banner数据
     */
    public function getBannerData( $cid = 0 ){
        $data = [];
        $defaultData = array(
            array('title'=>'韩都衣舍旗舰店', 'img_url'=>'/wap/imgs/handu.jpeg','toUrl'=>'https://handuyishe.tmall.com/shop/view_shop.htm?user_number_id=263817957&ali_trackid=2%3Amm_47800736_13948422_56422521%3A1488636329_3k5_1984535979'),
            array('title'=>'劲霸男装旗舰店', 'img_url'=>'/wap/imgs/jinba.jpeg','toUrl'=>'https://kboxing.tmall.com/shop/view_shop.htm?user_number_id=645371883&ali_trackid=2%3Amm_47800736_13948422_56422521%3A1488636514_3k4_1520347781'),
            array('title'=>'兰蔻官方旗舰店', 'img_url'=>'/wap/imgs/lankou.jpeg','toUrl'=>'https://lancome.tmall.com/shop/view_shop.htm?user_number_id=2360209412&ali_trackid=2%3Amm_47800736_13948422_56422521%3A1488636557_3k3_1885765926'),
        );
        $banner = Banner::where('status', 1)->where('cid', intval($cid))->get();
        if( $banner ){
            foreach ( $banner as $key => $vo ) {
                $data[$key] = $vo->formatBanner($vo);
            }
        }
        $data = $data ? $data : $defaultData;

        return $data;
    }

    /**
     * 获取图标对应的识别符号
     */
    public function getArrIcon()
    {
        return [1 => '&#xe62b;', 2 => '&#xe61e;', 3 => '&#xe602;', 4 => '&#xe601;', 5 => '&#xe60f;', 6 => '&#xe600;'
            , 7 => '&#xe680;', 8 => '&#xe67f;', 9 => '&#xe65e;', 10 => '&#xe638;', 11=>'&#xe60b;', 12=>'&#xe72b;'];
    }
    /**
     * 拋出異常並跳轉
     *
     * @param string $msg 提示信息
     * @param string $url 跳轉連結
     *
     * @return response
     */
    protected function error($msg, $url = '/', $second = 3)
    {
        $data = [
            'msg' => $msg,
            'url' => $url,
            'second' => $second,
            'explain' => '<br/><a href="' . $url . '">如果您不想等待，请点击此处链接</a>'
        ];
        $strMuban = is_mobile() ? 'home.wap.error' : 'error';
        return view($strMuban, $data);

    }

    /**
     * 成功跳转
     * @param string $msg  提示信息
     * @param string $url  跳轉連結
     */
    protected function success($msg, $url = '/', $second = 3)
    {
        $data = [
            'msg' => $msg,
            'url' => $url,
            'second' => $second,
            'explain' => '<br/><a href="' . $url . '">如果您不想等待，请点击此处链接</a>'
        ];
        $strMuban = is_mobile() ? 'home.wap.success' : 'success';
        return view($strMuban, $data);

    }

    /**
     * 获取下载地址
     * @return string
     */
    public function getDownUrl()
    {
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') || strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')) {
            $down_url = 'https://itunes.apple.com/cn/app/%E5%8D%B7%E7%8C%AA/id1238112219?mt=8';
        } else {
//            strpos($_SERVER['HTTP_USER_AGENT'], 'Android')
            $down_url = 'http://mobile.baidu.com/item?docid=11368616&source=pc';
        }
        return $down_url;
    }
}