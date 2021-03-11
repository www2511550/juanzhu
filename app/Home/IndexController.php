<?php
/**
 * Created by Chengcong.
 * Date: 2017/4/13 17:42
 */
namespace App\Home;

use App\Logic\CouponLogic;
use App\Logic\IndexLogic;
use App\Logic\TaobaoLogic;
use App\Logic\WeiboLogic;
use App\Model\Category;
use App\Model\Coupon;
use App\Model\Dapei;
use App\Model\User;
use App\Model\WzAds;
use App\Service\BaiduService;
use App\Service\Catch7dapeiService;
use App\Service\CatchAdsService;
use App\Service\DataokeService;
use App\Service\JdService;
use Illuminate\Http\Request;
use DB;
use Cache;
use Cookie;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class IndexController extends BaseController{
    public function __construct()
    {
        parent::__construct();
        // if(is_mobile() && !strpos(url()->current(), '/web/')){
//            header("location:".url('/home/wap/index'));die;
        //   header("location:http://coupon.juanzhuzhu.com/index.php?r=index/wap");die;
        // }

//        $couponLogic = new CouponLogic();
//        $arrId = $couponLogic->getCouponIdsBySphinx('女装');
//        pree($arrId);

//        $taobaoLogic = new TaobaoLogic();
//        $taobaoLogic->conponInfo();die;


//            $weiboLogic = new WeiboLogic();
//        echo $weiboLogic->shortUrl();die;

//        $catchAdsService = new CatchAdsService();
//        $catchAdsService->fububu_com();

//        $jdSerivce = new JdService();
//        $jdSerivce->hotGoods();

//        $baiduService = new BaiduService();
//        pree($baiduService->plan());

//        $catch = new Catch7dapeiService();
//        $catch->index();
    }


    function getUrl($url)
    {
        $ch = curl_init();
        // 设置 url
        curl_setopt($ch, CURLOPT_URL, $url);
        // 设置浏览器的特定header
        // 页面内容我们并不需要
        curl_setopt($ch, CURLOPT_NOBODY, 1);
        // 只需返回HTTP header
        curl_setopt($ch, CURLOPT_HEADER, 1);
        // 返回结果，而不是输出它
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        // 有重定向的HTTP头信息吗?
        if (preg_match('!Location: (.*)!', $output, $matches)) {
            return $matches[1];
        } else {
            return false;
        }
    }

    /**
     * 首页
     */
    public function index(Request $request, IndexLogic $indexLogic)
    {
        header("location:http://tool.juanzhuzhu.com");die;
        return view('home.index.indexDtk'); // 大淘客替代

        // 1、获取商品分类和对应的字体图标
        $arrCate = Category::where('status', 1)->get();
        if ($arrCate) {
            foreach ($arrCate as $key => $val) {
                $data['cate'][$key] = $val->formatCateData($val);
                $data['goods_total'] += $data['cate'][$key]['total'];
            }
            $data['cate'][] = ['cid'=>0, 'c_name'=>'其他', 'total'=>999];
        }
        $data['arrIcon'] = $this->getArrIcon();

        // 2、获取商品
        if (1) {

            $taobaoLogic = new TaobaoLogic();
            $tbData = $taobaoLogic->jingxuan(4094);
            foreach ($tbData->result_list->map_data as $vo){
                $data['data'][] = [
                    'Title' => $vo->title,
                    'Org_Price' => $vo->reserve_price,
                    'Price' => $vo->zk_final_price,
                    'Pic' => $vo->pict_url,
                    'Quan_price' => $vo->coupon_amount,
                    'Quan_time' => date('Y-m-d H:i:s', intval($vo->coupon_start_time)),
                    'to_url' => $vo->coupon_share_url ?: $vo->click_url,
                ];
            }


//            $result = $indexLogic->searchList($request->all());
//            if (count($result['ids']) > 0) {
//                foreach ($result['ids'] as $id) {
//                    $coupon = Coupon::find($id);
//                    if (!$coupon->id) continue;
//
//                    $data['data'][] = $coupon;
//                }
//            }
//            $data['total'] = $result['total'];

        } else {

            $strKey = 'list1_' . implode('_', $request->all());
            // Cache::forget($strKey);
            $data['data'] = Cache::remember($strKey, 10, function () use ($indexLogic, $params) {
                return $indexLogic->getIndexData($params);
            });
        }


        $data['cid'] = intval($request->get('cid'));
        $data['mid'] = $request->get('mid') ?: '';

        // taokeweb临时调用
        if ($request->get('tkweb')){
            return response()->json($data);
        }

        return view('home.index.indexNew', $data);
    }

    /**
     * 异步追加
     */
    public function append(Request $request, IndexLogic $indexLogic)
    {
        $data = [];
        $result = $indexLogic->searchList($request->all());
        if (count($result['ids']) > 0) {
            foreach ($result['ids'] as $id) {
                $data['data'][] = Coupon::find($id);
            }
        }

        return view('home.index.public.goods', $data);
    }
    /**
     * 优惠券搜索
     */
    public function search(Request $request, CouponLogic $couponLogic)
    {
        $cid = $request->get('cid', 1);
        $order = $request->get('order');
        $p_min = $request->get('p_min') ?: 0;  // 单价
        $p_max = $request->get('p_max') ?: 99999;
        $cr_min = $request->get('cr_min'); // 佣金
        $cr_max = $request->get('cr_max');
        $c_check = $request->get('c_check');  // 勾选条件
        $search = $request->get('search');
        $p = intval($request->get('p')) ?: 1;
        $limit = 24;

        // 小编推荐
        if (!$request->all()) {
            $data['recom'] = Cache::remember('recom', 10, function () {
                return Coupon::where('cid', 1)->where('Price', '<=', 50)
                    ->where('Quan_time', '>=', date('Y-m-d H:i:s', strtotime('2 hour')))
                    ->orderBy('Quan_time', 'asc')->paginate(4);
            });
        }

        // 获取商品分类
        $arrCate = Category::where('status', 1)->get();
        if ($arrCate) {
            foreach ($arrCate as $key => $val) {
                $data['cate'][$key] = $val->formatCateData($val);
                $data['goods_total'] += $data['cate'][$key]['total'];
            }
        }

        // 缓存
//        $strKey = 'search1_'.implode('_', $request->all());
        if(!Cache::has($strKey)){
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
            $sphinxSearch->SetFilterFloatRange("Price", (float)$p_min, (float)$p_max);
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
            if ($_GET['test']) {
                pre($result);
                pree($sphinxSearch);
            }
            if ($result['matches']) {
                foreach ($result['matches'] as $vo) {
                    $data['data']['list'][] = Coupon::find($vo['id']);
                }
            }
            $data['data']['total'] = $result['total_found'];
//            Cache::put($strKey, $data, 60);
        }


//        $data['data'] = Cache::get($strKey);
        $data['page'] = Coupon::where('id','<=',intval($data['data']['total']))->paginate($limit);

        return view('home.index.quan', $data);
    }
    /**
     * 优惠券列表
     */
    public function quan(Request $request, CouponLogic $couponLogic){
        $cid = $request->get('cid', 1);
        $order = $request->get('order');
        $p_min = $request->get('p_min');  // 单价
        $p_max = $request->get('p_max');
        $cr_min = $request->get('cr_min'); // 佣金
        $cr_max = $request->get('cr_max');
        $c_check = $request->get('c_check');  // 勾选条件
        $search = $request->get('search');

        // 小编推荐
        if (!$request->all()) {
            $data['recom'] = Cache::remember('recom', 10, function () {
                return Coupon::where('cid', 1)->where('Price', '<=', 50)
                    ->where('Quan_time', '>=', date('Y-m-d H:i:s', strtotime('2 hour')))
                    ->orderBy('Quan_time', 'asc')->paginate(4);
            });
        }

        $data['goods_total'] = 0;
        // 获取商品分类
        $arrCate = Category::where('status', 1)->get();
        if( $arrCate ) {
            foreach ( $arrCate as $key=>$val ) {
                $data['cate'][$key] = $val->formatCateData($val);
                $data['goods_total'] += $data['cate'][$key]['total'];
            }
        }

        // 获取商品
        $objCoupon = Coupon::where('Quan_time', '>=', date('Y-m-d H:i:s'));
        $record = Category::where('status', 1)->where('cid', $cid)->first();
        if( $record ) {
            $objCoupon->where('Cid', $cid);
        }

        // 使用sphinx获取物件id
        if($search){
            $arrId = $couponLogic->getCouponIdsBySphinx($search);
            $objCoupon->whereIn('id', $arrId);
        }

        $arrKw = array_filter(explode(' ', $search));
        if($arrKw){
            foreach ($arrKw as $strKw){
                $objCoupon->where('Title', 'like', '%'.$strKw.'%');
            }
        }

        $p_min && $objCoupon->where('Price','>=', $p_min);
        $p_max && $objCoupon->where('Price','<=', $p_max);
        $cr_min && $objCoupon->where('Commission','>=', $cr_min);
        $cr_max && $objCoupon->where('Commission','<=', $cr_max);

        // $c_check 勾选条件,可以多选
        1 == $c_check && $objCoupon->where('Price','<=', 9.9);
//        2 == $c_check && $objCoupon->where('Price','<=', 9.9);
        3 == $c_check && $objCoupon->where('IsTmall', 1);
//        4 == $c_check && $objCoupon->where('Price','<=', 9.9);

        // 排序
        switch ( $order ) {
            case 'price_down':
                $objCoupon->orderBy('Price', 'asc');
                break;
            case 'price_up':
                $objCoupon->orderBy('Price', 'desc');
                break;
            case 'sale':
                $objCoupon->orderBy('Sales_num', 'desc');
                break;
            case 'save':
                $objCoupon->orderBy('Quan_price', 'desc');
                break;
            default:
                $objCoupon->orderBy('id', 'desc');
        }

        $strKey = 'quan2_'.implode('_', $request->all());
        Cache::forget($strKey);
        $data['data'] = Cache::remember($strKey, 5, function () use ($objCoupon) {
            return $objCoupon->paginate(24);
        });


        return view('home.index.quan', $data);
    }

    /**
     * 详细页
     */
    public function detail(Request $request)
    {
        $id = $request->get('id') ?: $request->route('id');
        $data['info'] = Coupon::find($id);
        if (!$data['info']->id) {
            if ( !strpos($_SERVER['HTTP_REFERER'], 'juanzhuzhu.com')){  // 来源非本站直接去首页
                return redirect('/');
            }else{
                return $this->error('商品不存在或已下架！', '/');
            }
        }
        $data['info']->cate = Category::where('cid', intval($data['info']->Cid))->value('c_name');

        // 获取浏览纪录
        $data['history'] = $data['info']->getHistory($data['info']);

//        echo view('home.index.detail', $data)->__toString();die;
        return view('home.index.detail', $data);
    }

    /**
     * 异步获取猜你喜欢
     * @param Request $request
     */
    public function guessLike(Request $request)
    {
        $id = intval($request->id);
        $cid = intval($request->cid);
        $price = intval($request->price);

        $arrOrder = ['id', 'Quan_time', 'Sales_num', 'Price', 'Quan_price'];
        $strOrder = $arrOrder[rand(0, 4)];
        $guessLike = Coupon::where('Quan_time', '>=', date('Y-m-d H:i:s'))->where('cid', $cid)
            ->where('Price', '<=', $price * 1.2)->where('id', '!=', $id)
            ->orderBy($strOrder, 'desc')->paginate(16);
        return view('home.index.guessLike', ['data' => $guessLike]);
    }

    /**
     * 登陆
     */
    public function login(Request $request)
    {
        if (!$_POST) {
            return view('home.index.login');
        } else {
            $username = trim($request->get('username'));
            $pwd = trim($request->get('pwd'));

            $record = User::where('username', $username)->first();
            if (!$record) return $this->error('用户名不存在!');
            if (User::md5Pwd($pwd, $record->token) != $record->pwd) return $this->error('密码错误!');

            session(['uid' => $record->id, 'username' => $record->username]);
            return $this->success('登陆成功!');
        }
    }

    /**
     * 注册
     */
    public function register(Request $request)
    {
        return view('home.index.register');
    }

    public function test()
    {
/*        // 获取token
//        $arrToken = json_decode(file_get_contents('https://openapi.baidu.com/oauth/2.0/token?grant_type=client_credentials&client_id=M3l7f6M6lc1SQnUdGeGFGW7oCSyGLHUW&client_secret=krsu9KA0rfpogduSVvc02xwapgCwDIkc&scope=smartapp_snsapi_base'), true);
        $arrToken = ['access_token' => '24.1d5d6036ae8681afa7064568b16453b4.2592000.1614666210.282335-23543349'];
        $api = 'https://openapi.baidu.com/rest/2.0/smartapp/access/submitresource';
        $dataBrand = DB::table('bd_brand')->where('status', 1)->whereIn('id',[99])->paginate(100);
        foreach ($dataBrand as $brand){
            $arrContent = json_decode($brand->content_arr, true);
//            pre($arrContent);die;
            if (count($arrContent) < 4) continue;
            $params = [
                'access_token' => $arrToken['access_token'],
                'path' => '/pages/articleDetail/articleDetail?id='.$brand->id,
                'title' => $brand->title,
                'images' => json_encode([$arrContent[1]['img'], $arrContent[2]['img'], $arrContent[3]['img']]),
                'body' => $arrContent[0]['desc'], // 内容的介绍，最多 2000 字符
                'feed_type' => '综合',
                'feed_sub_type' => '综合',
                'mapp_type' => '1000',
                'mapp_sub_type' => '1001',
                'ext' => json_encode([
                    'author_name' => '优惠券猪猪',
                    'publish_time' => date('Y年m月d日'),
                ]),
            ];
            echo $brand->id;
            pre(httpCurl($api, $params));
        }

        die('aa');*/

//        // 获取邮箱标题
//        $title = '入群留意-新群提醒-【查看】'.date('Y年m月d日');
//
//        $toMail = '1248694991@qq.com';
//
////        $content = '<img src="https://img.alicdn.com/bao/uploaded/i2/2074450097/O1CN01J0ztWf1CaT4lSMefT_!!0-item_pic.jpg_130x130.jpg" />';
////        Mail::raw($content, function ($message) use ($toMail, $title) {
////            $message->subject($title);
////            $message->to($toMail);
////        });
//
//        // 第一个参数填写模板的路径，第二个参数填写传到模板的变量
//        Mail::send('mail',['name' => 'laravel'],function ($message) use ($toMail, $title){
//            // 发件人（你自己的邮箱和名称）
////            $message->from('yn3259@163.com', 'laravel');
//            // 收件人的邮箱地址
//            $message->to($toMail);
//            // 邮件主题
//            $message->subject($title);
//        });
//die('aa');

        if($_GET['test']){
            phpinfo();die;
        }

        $taobaoLogic = new TaobaoLogic();
        $data = $taobaoLogic->jingxuan(30443);
//        $data = $taobaoLogic->search('【红袍花椒】四川大红袍花椒粒100g');
        if (!count($data->result_list->map_data)) {
            pre($data);die;
        }
        foreach ($data->result_list->map_data as $value){

            echo '<a href="'.($value->coupon_share_url ?: $value->click_url).'" target="_blank"><img src="'.$value->pict_url.'" /></a><br/><br/><br/>';
            pre($value);
        }

        pre($data->result_list);die;

        $dataokeService = new DataokeService();
        $data = $dataokeService->getGoodsList();

        pre($data);die;

        $weibo = new WeiboLogic();
        pre($weibo->getFashionList());die;

//        $sphinxSearch = new SphinxClient();
//
//        $sphinxSearch->setArrayResult(true);
//        $sphinxSearch->SetLimits(20, 40, 1000);
//        $sphinxSearch->setMaxQueryTime(100);
//        // 根据属性排序
//        $sphinxSearch->SetSortMode('SPH_SORT_ATTR_DESC', 'id');
//        // 匹配模式，匹配所有查询词
//        $sphinxSearch->SetMatchMode('SPH_MATCH_ALL');
//        $result = $sphinxSearch->query('T恤 上', 'coupon');
//        pree($result);

    }

    function getmeiyou(){
        $url = 'http://ad.seeyouyima.com/getad?platform=android&v=5.9.2&pageid=1600&device_id=359881067371716&forum_id=26&push_idstr=mye-633_425_610_2373_8_2_QdNKg445bb620&mode=0&iswake=0&fcatid=0&topic_id=36366383&resolution=1080%2C1920';
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curl, CURLOPT_ENCODING, "gzip"); // 关键在这里
        $content = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($content, true);
        pree($data);
        if($data[0]) {
            $adsModel = M('ads');
            $record = $adsModel->where("url = '".$data[0]['attr_text']."'")->find();
            if( !$record ){
                $data = array('name'=>$data[0]['planid'], 'title'=>$data[0]['title'], 'url'=>$data[0]['attr_text'],'addtime'=>time());
                $adsModel->add($data);
            }
        }
        echo 'success!';
    }

    // 微信小程序嵌套
    public function iframe(Request $request)
    {
        $data['url'] = '//' . ($request->route('type') == 'jd' ? 'jd' : 'coupon') . '.juanzhuzhu.com';

        return view('home.index.iframe', $data);
    }

    /**
     * 网赚广告列表
     */
    public function wzAds()
    {
        $data = WzAds::where('status', 1)->get();
        foreach ($data as $val){
            echo "<p><b style='padding-right: 50px;;'>".$val['cate_name']."</b><a target='_blank' href='".$val['href']."'>".$val['title']."</a></p>";
        }
    }

    public function sendWeibo()
    {
        $weiboLogic = new WeiboLogic();

//        $status = $weiboLogic->sendWeibo();
        $status = $weiboLogic->sendYangMao();
        return response()->json(['status' => $status]);
    }


    public function sendArticle()
    {
        if ((date('H:i') >= '10:00' && date('H:i') < '12:00') || (date('H:i') >= '14:10' && date('H:i') <= '17:30')){
            $weiboLogic = new WeiboLogic();

            $dapei = Dapei::orderByRaw('rand()')->first();
            $content = $text = '';
            $arrContent = json_decode($dapei->content, true);
            foreach ($arrContent as $k => $val) {
                $content .= (str_replace('【赠运费险】', '', $val['intro']) . '<a href="http://2dapei.com.cn/detail/'.$dapei->id.'.html"><img src="' . $val['cover'] . '"/></a>') . '<br/>';
                if (!$text && $k == rand(1, 4)) {
                    $text = $val['intro'];
                }
            }
            $arrCover = explode(',', $dapei->cover);
            $dapei->intro = str_replace('【赠运费险】', '', $dapei->intro);
            $buy_url = 'http://2dapei.com.cn/detail/'.$dapei->id.'.html';
            $text = $dapei->intro.$buy_url;
            $result = $weiboLogic->sendAritcle($dapei->title, $arrCover[0], $content, $dapei->intro, $text);
            if ($result['code'] == 100000){
                $dapei->is_send_weibo = 1;
                $dapei->save();
            }
        }

    }

    public function url(){
        $test = 'https://uland.taobao.com/coupon/edetail?activityId=3b1e9704f692467e8f2ece981d30e03a&itemId=564300191492&pid=mm_47800736_21362628_72092261';
        header('Location:'.$test);die;
    }

    /**
     * 淘礼金免单采集网-首发0元购免单
     */
    public function freeTaoLiJin()
    {
        return view('home.index.freeTaoLiJin');
    }

    /**
     * 大淘客，好单裤商家、淘客联系方式数据
     */
    public function tkData()
    {
        if($_GET['type'] == 'dtk'){
            $data = DB::table('dtk_data')->orderBy('id', 'desc')->paginate(50);
            foreach ($data as $vo) {
                preg_match('/uin\=(.*)\&site/', $vo->qq, $qq);
                $vo->qq = $qq[1];
            }
        }else{
            $data = DB::table('saler_data')->orderBy('id', 'desc')->paginate(50);
        }

        return view('home.index.tkData', ['data' => $data]);
    }

    /**
     * 微信每日早报图片
     */
    public function zaobao()
    {
        $data = json_decode(file_get_contents('http://dwz.2xb.cn/zaob'), true);
        if ($data['code'] == 200){
            return '<img src="'.$data['imageUrl'].'" >';
        }
        return 'no img';
    }
}