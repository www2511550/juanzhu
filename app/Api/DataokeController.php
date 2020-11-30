<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 17/4/25
 * Time: 下午9:14
 * 调用大淘客api接口
 */
namespace App\Api;

use App\Logic\CouponLogic;
use Illuminate\Http\Request;

class DataokeController extends BaseController
{

    private $api_base;
    private $appKey;

    public function __construct()
    {
        parent::__construct();

        $this->appKey   = '268977f5ba';
        // v 2-utf-8编码的json格式数据,1-(默认值): 返回gbk编码json格式数据
        $this->api_base = 'http://api.dataoke.com/index.php';
    }

    /**
     * 网站专用api接口
     */
    public function web(Request $request){
        $params['r'] = 'goodsLink/www';
        $params['type'] = 'www_quan';
        $params['appkey'] = $this->appKey;
        $params['v'] = 2;
        $arrData = http($this->api_base, $params);
        pree($arrData);
    }

    /**
     * 全站领券商品API接口
     */
    public function allWeb(CouponLogic $couponLogic){
        $params['r'] = 'Port/index';
        $params['type'] = 'total';
        $params['appkey'] = $this->appKey;
        $params['v'] = 2;
        $arrData = http($this->api_base, $params);
        $data = json_decode($arrData, true);
        if( $data['result'] ){
            $couponLogic->dealDataokeData($data['result']);
        }
        echo  'success!';
    }

    /**
     * 实时跑量榜API接口
     */
    public function saleTop(Request $request){
        $params['r'] = 'Port/index';
        $params['type'] = 'paoliang';
        $params['appkey'] = $this->appKey;
        $params['v'] = 2;
        $arrData = http($this->api_base, $params);
        pree($arrData);
    }

    /**
     * TOP100人气榜API接口
     */
    public function top100(Request $request){
        $params['r'] = 'Port/index';
        $params['type'] = 'top100';
        $params['appkey'] = $this->appKey;
        $params['v'] = 2;
        $arrData = http($this->api_base, $params);
        pree($arrData);
    }

}