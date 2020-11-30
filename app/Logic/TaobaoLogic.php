<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 17/5/7
 * Time: 下午8:38
 * 淘宝客api
 */
namespace App\Logic;

require app_path('../vendor/taobao-sdk/TopSdk.php');


class TaobaoLogic{

    public function __construct()
    {
        $this->appkey = '25307921';
        $this->secret = '88aa7d37745851551ef857ba72c43fde';
        $this->pid = 'mm_47800736_21362628_72084401';
        $this->thirdPid = '431230024';
    }

    /**
     * 淘宝短链接
     * http://open.taobao.com/docs/api.htm?spm=a219a.7386797.0.0.nitvdk&source=search&apiId=27832
     */
    public function shortUrl($longUrl)
    {
        $c = new \TopClient;
        $c->appkey = $this->appkey;
        $c->secretKey = $this->secret;
        $req = new \TbkSpreadGetRequest;
        $requests = new \TbkSpreadRequest;
        $requests->url = $longUrl;
        $req->setRequests(json_encode($requests));
        $resp = $c->execute($req);
        pree($resp);
    }
    /**
     * 海淘抢api
     * http://open.taobao.com/docs/api.htm?spm=a219a.7629065.0.0.FL8QCF&apiId=27543
     */
    public function haitao()
    {
        $c = new \TopClient;
        $c->appkey = $this->appkey;
        $c->secretKey = $this->secret;
        $req = new \TbkJuTqgGetRequest;
        $req->setAdzoneId($this->thirdPid);
        $req->setFields("click_url,pic_url,reserve_price,zk_final_price,total_amount,sold_num,title,category_name,start_time,end_time");
        $req->setStartTime(date('Y-m-d 00:00:00'));
        $req->setEndTime(date('Y-m-d 00:00:00', strtotime('2 day')));
        $req->setPageNo("1");
        $req->setPageSize("40");
        $resp = $c->execute($req);
        pree($resp);
    }

    /**
     * 淘口令生成
     * 禁止自动程式调用淘口令
     */
    public function taokouling($url, $text, $logo_url = '', $is_use = 0)
    {
        $str = '';
        if ($is_use) {

//            return '';
            require app_path('../vendor/taobao-sdk/top/request/TbkTpwdCreateRequest.php');
            $c = new \TopClient;
            $c->appkey = $this->appkey;
            $c->secretKey = $this->secret;
            $req = new \TbkTpwdCreateRequest();
            $req->setUserId("123");
            $req->setText($text);
            $req->setUrl($url);
            $req->setLogo($logo_url);
            $req->setExt("{}");
            $resp = $c->execute($req);
            $arr = (array)$resp->data;
            return $arr['model'] ?: '';
        }

        return $str;
    }

    /**
     * 好券清单api[导购]
     * http://open.taobao.com/docs/api.htm?spm=a219a.7386797.0.0.qH6lRP&source=search&apiId=29821
     */
    public function haoQuan($q = "女")
    {
        $c = new \TopClient();
        $c->appkey = $this->appkey;
        $c->secretKey = $this->secret;
        $req = new \TbkDgItemCouponGetRequest;
        $req->setAdzoneId($this->thirdPid);
        $req->setPlatform("2");
//        $req->setCat("16,18,1625");
        $req->setPageSize("100");
//        $req->setQ($q);
        $req->setPageNo("2");
        $resp = $c->execute($req);
        return $data = $this->dealTaoBaoResult($resp->results->tbk_coupon);
    }

    /**
     * 获取单个商品优惠卷
     */
    public function oneCoupon($q = '女装')
    {
        $c = new \TopClient();
        $c->appkey = '21074255';
        $c->secretKey = 'ff2712ae1ad2f824259107b06188bcb8';
        $req = new \TbkItemCouponGetRequest();
        $req->setPlatform("1");
        $req->setCat("16,18");
        $req->setPageSize("1");
        $req->setQ($q);
        $req->setPageNo("1");
        $req->setPid($this->pid);
        $resp = $c->execute($req);
        pree($resp);
    }

    /**
     * 获取联盟选品数据
     */
    public function selectGoods($page = 1, $pageSize = 100, $fid = '16889394')
    {
        $c = new \TopClient;
        $c->appkey = $this->appkey;
        $c->secretKey = $this->secret;
        $req = new \TbkUatmFavoritesItemGetRequest;
        $req->setPlatform("2");
        $req->setPageSize($pageSize);
        $req->setAdzoneId($this->thirdPid);
        $req->setUnid("3456");
        $req->setFavoritesId($fid);
        $req->setPageNo($page);
        $field = "num_iid, title, pict_url, zk_final_price_wap, click_url, user_type, volume, event_start_time, event_end_time, coupon_click_url";
        $req->setFields($field);
        $resp = $c->execute($req);
        $data = $this->dealTaoBaoResult($resp->results->uatm_tbk_item);
        return $data;
    }

    /**
     * 淘宝返回数据处理
     */
    public function dealTaoBaoResult($params)
    {
        $data = [];
        if ($params) {
            foreach ($params as $val) {
                $data[] = $this->formatSelect($val);
            }
        }
        return $data;
    }

    public function formatSelect($val)
    {
        $data = [];
        if ($val) {
            if (is_object($val)) $val = (array)$val;
            $data['title'] = $val['title'];
            $data['price'] = $val['zk_final_price_wap'];
            $data['gid'] = $val['num_iid'];
            $data['pic_url'] = $val['pict_url'];
            $data['url'] = $val['click_url'];
            $data['type'] = $val['user_type'];
            $data['sale_num'] = $val['volume'];
            $data['start_time'] = $val['event_start_time'];
            $data['end_time'] = $val['event_end_time'];
        }
        return $data;
    }

    /**
     * 通过登录后的cookie获取成交订单
     * author chengcong
     */
    public function getTbOrder()
    {
        $strCookie = 'cna=FcBAEoSuFnMCAbcLy3abBVY7;cookie31=NDc4MDA3MzYsd3d3MjUxMTU1MCwzNzk2MjQ0MzJAcXEuY29tLFRC;cookie2=ac41bed428975b1f0fc978cae5d54dfe;t=8d735d35dffb36ed630d98a3eeae9675;_tb_token_=CC22MZoTJ0r;v=0;login=U%2BGCWk%2F75gdr5Q%3D%3D;cookie32=906e21bdab996a97cf37cb977372dabf;isg=AunpxDh0lKFleqgVKZAM9C6K-JWDHt_9SRhnz4vecFAPUglk0wbtuNfCYsEe;alimamapw=QEQVBQJQBVcAAGgIBFQBB1lWAAMAAgBYBgFTAAILBgMGUwlWBlVWBlMEVg%3D%3D;alimamapwag=TW96aWxsYS81LjAgKFdpbmRvd3MgTlQgMTAuMDsgV09XNjQpIEFwcGxlV2ViS2l0LzUzNy4zNiAoS0hUTUwsIGxpa2UgR2Vja28pIENocm9tZS82MC4wLjMxMTIuOTAgU2FmYXJpLzUzNy4zNg%3D%3D;apush99819d347881b30e8ba22dc3d163bb3c=%7B%22ts%22%3A1505350177311%2C%22parentId%22%3A1505350177306%7D;';
        header("Content-type:text/html;Charset=utf8");
        $ch = curl_init();
        $url = 'http://pub.alimama.com/report/getTbkPaymentDetails.json?startTime=2017-06-13&endTime=2017-09-10&payStatus=&queryType=1&toPage=1&perPageSize=20&total=&t=1505137198709&pvid=&_tb_token_=Ohs3wrYi5yq&_input_charset=utf-8';
        curl_setopt($ch, CURLOPT_URL, $url);

        $header = array();
        //curl_setopt($ch,CURLOPT_POST,true);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        // curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file); //使用上面获取的cookies
        curl_setopt($ch, CURLOPT_COOKIE, $strCookie);


        $content = curl_exec($ch);
        pree($content);
        die;
    }

    /**
     * 获取商品详情图集
     * @param $goods_id
     * @param $is_detail  1-详细信息
     */
    public function getGoodsImages($goods_id, $is_detail = 0, $strSize = '400x400.jpg')
    {
        $data = [];
        $c = new \TopClient;
        $c->appkey = $this->appkey;
        $c->secretKey = $this->secret;
        $req = new \TbkItemInfoGetRequest;
        $req->setFields("num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url,volume");
        $req->setPlatform('1');
        $req->setNumIids($goods_id);
        $resp = $c->execute($req);
        if($resp->results->n_tbk_item){
            if ($is_detail){
                $data = (array)$resp->results->n_tbk_item;
            }else{
                $data[] = current($resp->results->n_tbk_item->pict_url).$strSize;
                foreach ($resp->results->n_tbk_item->small_images->string as $img){
                    $data[] = $img.'_400x400.jpg';
                }
            }
        }
        return $data;
    }

    /**
     * 淘客媒体内容 暂无权限
     * @param int $type
     * author chengcong
     */
    public function tbkContent($type = 1)
    {
        $c = new \TopClient;
        $c->appkey = $this->appkey;
        $c->secretKey = $this->secret;
        $req = new \TbkContentGetRequest();
        $req->setAdzoneId($this->thirdPid);
        $req->setType("1");
        $req->setBeforeTimestamp("1491454244598");
        $req->setCount("10");
        $req->setCid("2");
//        $req->setImageWidth("300");
//        $req->setImageHeight("300");
//        $req->setContentSet("1");
        $resp = $c->execute($req);
        pree($resp);
    }

    /**
     * 通用物料搜索API（导购）
     * author chengcong
     * http://open.taobao.com/docs/api.htm?spm=a219a.7629065.0.0.ZaoxeU&apiId=35896&scopeId=11655
     */
    public function tbkSearch()
    {
        $c = new \TopClient;
        $c->appkey = $this->appkey;
        $c->secretKey = $this->secret;
        $req = new \TbkDgMaterialOptionalRequest;
//        $req->setStartDsr("10");
        $req->setPageSize("20");
        $req->setPageNo("1");
        $req->setPlatform("1");
        $req->setEndTkRate("9999");
        $req->setStartTkRate("3000");
        $req->setEndPrice("59");
        $req->setStartPrice("2");
//        $req->setIsOverseas("false");
        $req->setIsTmall("true");
        $req->setSort("total_sales_des");
//        $req->setItemloc("杭州");
        $req->setCat("16,18");
//        $req->setQ("女装");
        $req->setHasCoupon("true");
        $req->setAdzoneId($this->thirdPid);
        $resp = $c->execute($req);
        if (isset($resp->result_list)){
            return $resp->result_list;
        }
        return [];
    }

    /**
     * 聚划算
     * http://open.taobao.com/docs/api.htm?spm=a219a.7395905.0.0.TFMxBC&scopeId=11655&apiId=28762
     */
    public function juSearch()
    {
        $c = new \TopClient;
        $c->appkey = $this->appkey;
        $c->secretKey = $this->secret;
        $req = new \JuItemsSearchRequest;
        $param_top_item_query = new \TopItemQuery;
        $param_top_item_query->current_page = "1";
        $param_top_item_query->page_size = "20";
        $param_top_item_query->pid = $this->pid;
        $param_top_item_query->postage = "true";
        $param_top_item_query->status = "2";
//        $param_top_item_query->taobao_category_id = "1000";
//        $param_top_item_query->word = "test";
        $req->setParamTopItemQuery(json_encode($param_top_item_query));
        $resp = $c->execute($req);
        pree($resp);
    }

    /**
     * 推广券信息查询
     * @param $item_id
     * @param $activity_id
     * @param $me
     */
    public function couponInfo($item_id = '', $activity_id = '', $me = '')
    {
        $c = new \TopClient;
        $c->appkey = $this->appkey;
        $c->secretKey = $this->secret;

        $req = new \TbkCouponGetRequest;
        $me && $req->setMe($me);
        $item_id && $req->setItemId($item_id);
        $activity_id && $req->setActivityId($activity_id);
        $resp = $c->execute($req);
        if (isset($resp->data)) {
            return (array)$resp->data;
        } else {
            return (array)$resp;
        }
    }

    /**
     * 获取物料链接地址
     */
    public function spreadUrl($url)
    {
        $c = new \TopClient;
        $c->appkey = $this->appkey;
        $c->secretKey = $this->secret;
        $req = new \TbkSpreadGetRequest;
        $requests = new \TbkSpreadRequest;
        $requests->url = $url;
        $req->setRequests(json_encode($requests));
        $resp = $c->execute($req);
        pre($resp);die;
    }

    public function oneGoods($goodsId)
    {
        $c = new \TopClient;
        $c->appkey = $this->appkey;
        $c->secretKey = $this->secret;
        $req = new \TbkItemInfoGetRequest;
        $req->setNumIids($goodsId);
        $req->setPlatform("1");
        $resp = $c->execute($req);
        pre($resp);
        die;
    }

}