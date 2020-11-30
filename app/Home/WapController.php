<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 17/5/5
 * Time: 下午10:12
 */
namespace App\Home;

use App\Logic\CouponLogic;
use App\Logic\TaobaoLogic;
use App\Logic\UrlLogic;
use App\Logic\UserLogic;
use App\Model\Category;
use App\Model\ClickDetail;
use App\Model\Coupon;
use App\Model\Order;
use App\Model\TbOrder;
use App\Model\Url;
use App\Model\User;
use Illuminate\Http\Request;
use Cache;
use DB;

class WapController extends BaseController
{
    /**
     *  手机端首页
     */
    public function index(Request $request, CouponLogic $couponLogic)
    {
        $cid = $request->get('mid', 0);
        $kw = $request->get('kw');
        $data['goods_total'] = 0;


        // 获取商品分类
        $arrCate = Category::where('status', 1)->get();
        if ($arrCate) {
            foreach ($arrCate as $key => $val) {
                $data['cate'][$val->cid] = $val->formatCateData($val);
                $data['goods_total'] += $data['cate'][$key]['total'];
            }
        }

        // 获取商品
//        $objCoupon = new Coupon();
        $objCoupon = Coupon::where('Quan_time', '>=', date('Y-m-d'));
        if($data['cate'][$cid] || in_array($cid, ['9.9', '19.9', '666'])){
            $objCoupon = $couponLogic->getCidConditon($cid, $objCoupon);
        }
        $arrKw = array_filter(explode(' ', $kw));
        if($arrKw){
            foreach ($arrKw as $strKw){
                $objCoupon->where('Title', 'like', '%'.$strKw.'%');
            }
        }else{
            // 获取banner图片
            $data['banner'] = $this->getBannerData($cid);
        }

        $data['total'] = $objCoupon->count();
        $strKey = 'wap_index2'.implode('_', $request->all());
//        Cache::forget($strKey);
        $data['data'] = Cache::remember($strKey, 60, function () use ($objCoupon) {
            return $objCoupon->orderBy('id', 'desc')->take(20)->get();
        });
        // 搜索无数据，跳转到淘宝官网优惠卷
        if($kw && !$data['data']->toArray()) return redirect('https://temai.m.taobao.com/search.htm?pid=mm_47800736_21362628_72092261&q='.$kw);

        // 下载链接
        $data['down_url'] = $this->getDownUrl();

        // 是否弹出下载
        $data['is_down'] = $_COOKIE['down'];

        return view('home.wap.index', $data);
    }

    /**
     * 详细页
     */
    public function detail(Request $request)
    {
        $id = $request->get('id');
        $uid = $request->get('uid');
        $data = Coupon::find($id);
        if (!$data) return redirect('/');
        $data['is_wx'] = is_wx_browser();
        $data['quan_url'] = $data->getQuanUrl($data);
        $data['title'] = $data->Title;
        $data['img'] = $data->Pic . '_150x150.jpg';
        // 下载链接
        $data['down_url'] = $this->getDownUrl();

        // 分享点击统计
        $this->addShareCount($request, $uid, $data->GoodsID);
        return view('home.wap.detail', $data);
    }
    /**
     * 手机端抽奖
     */
    public function reward()
    {
        $data['action'] = 'reward';
        return view('home.wap.reward', $data);
    }

    /**
     * 登陆
     */
    public function login(Request $request)
    {
        if('GET' == $request->method()){
            return view('home.center.login');
        }else{
            $username = $request->get('username');
            $pwd = $request->get('pwd');

            $record = User::where('username', $username)->first();
            if (!$record) return $this->error('用户名不存在!');
            if (User::md5Pwd($pwd, $record->token) != $record->pwd) return $this->error('密码错误!');

            setcookie('uid', $record->id);
            setcookie('username', $record->username);

            return redirect('/home/center');
        }

    }

    /**
     * 注册
     */
    public function register(Request $request, UserLogic $userLogic)
    {
        if('GET' == $request->method()){
            return view('home.center.register');
        }else{
            $data = $userLogic->validateUser($request->all());
            if( 0 == $data['status'] ) return $this->error($data['msg']);

            return $this->success('注册成功!');
        }

    }

    /**
     * 退出登录
     * @author chengcong
     */
    public function out(){
        setcookie('uid', null);
        setcookie('username', null);
        return redirect('/');
    }

    /**
     * 获取中奖号
     */
    public function toReward(Request $request){
        $res = array('status' => 0, 'msg' => '');
        $order_num = $request->get('order_num');
        if (!$order_num) {
            $res['msg'] = "订单号不能为空！";
            return response()->json($res);
        }
        if (strlen($order_num) != 16) {
            $res['msg'] = "淘宝订单号长度为16位！";
            return response()->json($res);
        }
        $record = TbOrder::where('order_num', $order_num)->first();
        if (!$record) {
            $res['msg'] = "订单号不存在,请私信博主核对！";
            return response()->json($res);
        }
        if ($record->status == 2) {
            $res['msg'] = "订单已退货，无法参与抽奖！";
            return response()->json($res);
        }
        if ($record->reward != 0 || $record->status == 3) {
            $res['msg'] = "该订单号已经抽奖，若未领取，可私信博主领取！";
            return response()->json($res);
        }
        // 中奖号
        $rewardLogic = D('Common/reward', 'Logic');
        $prize_arr = $rewardLogic->getWeiboRate();
        foreach ($prize_arr as $key => $val) {
            $arr[$val['id']] = $val['v'];
        }
        $rid = $this->get_rand($arr); //根据概率获取奖项id
        // 中奖号，佣金较少的给谢谢参与奖
        if ($record->money <= 1.88) {
            $rid = 1;
        } elseif ($record->money <= 8.88 && $rid > 2) {
            $rid = 2;
        }
        $res['yes_num'] = $rid;
        $res['yes_name'] = "恭喜你获得" . $prize_arr[$rid - 1]['prize']; //中奖项
        unset($prize_arr[$rid - 1]); //将中奖项从数组中剔除，剩下未中奖项
        shuffle($prize_arr); //打乱数组顺序
        // for($i=0;$i<count($prize_arr);$i++){
        //     $pr[] = $prize_arr[$i]['prize'];
        // }
        // $res['no'] = $pr;
        // 更新中奖号
        $record->reward = $rid;
        if ($record->save() === false) {
            $res['msg'] = "系统出错，请重新抽奖！";
            return response()->json($res);
        }
        $res['status'] = 1;
        $res['msg'] = "Success!";
        return response()->json($res);
    }

    /**
     * 异步追加
     */
    public function append(Request $request)
    {
        $page = $request->get('page', 2);
        $mid = $request->get('mid');
        $kw = trim($request->get('kw'));

        // 获取数据
        $objCoupon = Coupon::where('Quan_time', '>=', date('Y-m-d'));
        $mid && $objCoupon->where('Cid', $mid);
        $kw && $objCoupon->where('Title', 'like', '%' . $kw . '%');
        $skip = ($page - 1) * 20;
        $data = $objCoupon->orderBy('id', 'desc')->skip($skip)->take(20)->get();

        if ($data) {
            $str = '';
            foreach ($data as $vo) {
                $str .= '<div class="one_out">
                        <b class="is_new"></b>
                        <a href="'.$vo->getQuanUrl($vo).'" class="is_quan"><span>内部券<br/>'.$vo->Quan_price.'元</span><img src="/images/qulingquan.png" alt="优惠卷"></a>
                        <div class="one_img" style="overflow:hidden">
                            <a href="' . $vo->getQuanUrl($vo) . '">
                                <img class="lazy" src="' . $vo->Pic . (strpos($vo->pic,'alicdn') ? '_320x320.jpg' : '').'"  alt="' . $vo->Title . '" style="height:170px;" />
                            </a>
                        </div>
                        <p class="title">
                            <a href="' . $vo->getQuanUrl($vo) . '.">'.$vo->Title.'</a>
                        </p>
                        <div class="price">
                            <p class="new_price">
                                卷后<b>￥</b><span>' . $vo->Price . '</span>
                            </p>
                            <a href="' . $vo->getQuanUrl($vo) . '" class="buy">' . $vo->Quan_price . '元卷</a>
                        </div>
                    </div>';
            }
        }
        return response()->json($str);
    }

    /**
     * 用户分享积分添加
     */
    public function addShareCount($request, $uid, $gid)
    {
        if ($request && $uid && $gid) {
            $ip = $request->getClientIp();
            $longip = ip2long($ip);

            $record = ClickDetail::where('user_id', $uid)->where('gid', $gid)->where('ip', $longip)->first();
            if ($record) {
                ClickDetail::where('id', $record->id)->update(['updated_at'=>date('Y-m-d H:i:s')]);
            }else{
                $longip = ip2long($ip);
                $insertData['user_id'] = $uid;
                $insertData['gid'] = $gid;
                $insertData['ip'] = $longip;
                $insertData['created_at'] = $insertData['updated_at'] = date('Y-m-d H:i:s');
                ClickDetail::insert($insertData);
            }
        }
    }

    /**
     * 积分商城
     */
    public function shop(Request $request)
    {
        $uid = $request->get('uid');
        $token = $request->get('token');
        $page = $request->get('page', 1);
        $isAjax = $request->get('isAjax');
//        if ( (!$uid || $token != getApiToken($uid)) && $page <= 1) return redirect('/');

        $data['score'] = User::where('id', $uid)->value('score');
        $data['action'] = 'shop';
        $pageSize = 10;
        $skip = ($page - 1) * $pageSize;
        $data['data'] = DB::table('score_shop')->where('status',1)->where('end_time', '>=', date('Y-m-d H:i:s'))->skip($skip)->take($pageSize)->get()->toArray();
        if($isAjax && $data['data'] ){
            $str = '';
            foreach ($data['data'] as $vo){
                $str .= '<div class="one_out">
                        <b class="is_new"></b>
                        <a href="javascript:;" class="is_quan"><span>积分<br/>换购</span></a>
                        <div class="one_img" style="overflow:hidden">
                            <a href="javascript:;">
                                <img class="lazy" src="'.$vo->pic_url.'"_320x320.jpg"  alt="'.$vo->title.'" style="height:170px;" />
                            </a>
                        </div>
                        <p class="title">
                            <a href="javascript:;">'.$vo->title.'</a>
                        </p>
                        <div class="price">
                            <p class="new_price">
                                <span>'.$vo->score.'</span><b>积分</b>
                            </p>
                            <p class="old_price">
                            </p>
                            <a href="javascript:;" class="buy" onclick="showOrder(this)" uid="'.$uid.'" gid="'.$vo->gid.'" g_score="'.$vo->score.'" g_title="'.$vo->title.'">兑换</a>
                        </div>
                    </div>';
            }
            return response()->json($str);
        }

        return view('home.wap.shop', $data);
    }

    /**
     * 添加积分商城订单
     */
    public function addScoreOrder(Request $request)
    {
        $data = ['status' => 0, 'msg' => ''];
        $gid = $request->get('gid');
        $uid = $request->get('uid');
        $tel = $request->get('tel');
        $address = $request->get('address');
        $name = $request->get('name');
        $score = intval($request->get('score'));

        if (!$gid || !$uid || !$tel || !$address || !$name || !$score) {
            $data['msg'] = '参数异常,稍后再试!';
            return response()->json($data);
        }
        $userInfo = User::find($uid);
        if (!$userInfo->id) {
            $data['msg'] = '用户不存在,稍后再试!';
            return response()->json($data);
        }
        $score1 = DB::table('score_shop')->where('gid', $gid)->value('score');
        if($score != $score1){
            $data['msg'] = '积分参数异常,稍后再试!';
            return response()->json($data);
        }
        if ($score > $userInfo->score) {
            $data['msg'] = '积分不足!';
            return response()->json($data);
        }
        $insertData['gid'] = $gid;
        $insertData['uid'] = $uid;
        $insertData['address'] = $address;
        $insertData['score'] = $score;
        $insertData['name'] = $name;
        $insertData['created_at'] = $insertData['updated_at'] = date('Y-m-d H:i:s');
        $status = Order::insert($insertData);

        if (false === $status) {
            $data['msg'] = '订单提交失败,稍后再试!';
            return response()->json($data);
        }else{
            // 扣除积分
            $scoreDetail['user_id'] = $uid;
            $scoreDetail['gid'] = $gid;
            $scoreDetail['score'] = -1*$score;
            $scoreDetail['status'] = 1;
            $scoreDetail['note'] = '积分商品兑换';
            $scoreDetail['created_at'] = $scoreDetail['updated_at'] = date('Y-m-d H:i:s');
            DB::table('score_detail')->insert($scoreDetail);
            User::where('id', $uid)->decrement('score', $score);
        }
        $data['msg'] = '提交成功,预计3-7天可以收到您的宝贝!';
        $data['status'] = 1;
        return response()->json($data);
    }

    /**
     * 下载app
     */
    public function down()
    {
        if($_GET['test']){
            echo '<script src="https://apps.bdimg.com/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://tout.yanwen.com/qgstw/images/clipboard.js" type="text/javascript" charset="utf-8"></script>
';
            echo '<button class="click_copy" style="border:1px solid #437ecf;border-radius:8px;padding:0px 6px;background:#437ecf;box-shadow:3px 3px 4px #333;color:white;text-decoration:none;">点我启动微信添加👈</button>';

            echo "<script type='text/javascript'>
        window.onload = function() {
            var clipboard = new Clipboard('.click_copy', {
                text: function() {
                    return 'cc379624432';
                }
            });
            clipboard.on('success', function(e) {
                alert('微信号复制成功，立刻为您打开微信');
                location.href='weixin://';
            });
            // 复制失败
            clipboard.on('error', function(e) {
                alert('复制失败');
            });
        }
</script>";die;
        }
        $downUrl = $this->getDownUrl();
        return redirect($downUrl);
    }

    /**
     * 植物识别app下载
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * author chengcong
     */
    public function downPlan()
    {
        $downUrl = $this->getDownUrl();
        return redirect($downUrl);
    }

    /**
     * 支付宝红包领取页面
     */
    public function zhifubao()
    {
        return view('home.wap.zhifubao');
    }


    public function url()
    {

        $data['url1'] = 'https://uland.taobao.com/coupon/edetail?activityId=3b1e9704f692467e8f2ece981d30e03a&itemId=564300191492&pid=mm_47800736_21362628_72092261';
        $data['url2'] = 'https://s.click.taobao.com/jxg9uQw';
        return view('home.wap.url', $data);
    }

    /**
     * 微博跳转到淘宝app
     */
    public function toTb(Request $request)
    {
        $gid = $request->get('gid');
        $coupon = Coupon::find($gid);
        if ($coupon->id) {// 优惠券地址
            if ($coupon->Quan_id && $coupon->GoodsID) {
                $pid = 'mm_47800736_21362628_72092261';
                $redirect = 'https://uland.taobao.com/coupon/edetail?activityId=' . $coupon->Quan_id . '&itemId=' . $coupon->GoodsID . '&pid=' . $pid;
            } else {
                $redirect = $coupon->Quan_link;
            }
        } else {
            $redirect = 'http://coupon.juanzhuzhu.com';
        }
        return view('home.wap.totb', ['title' => $coupon->title, 'url' => $redirect]);
    }

    public function juanUrl(Request $request, UrlLogic $urlLogic)
    {
        $gid = $request->get('gid');
        $coupon = Coupon::find($gid);
        if ($coupon->id) {// 优惠券地址
            if ($coupon->Quan_id && $coupon->GoodsID) {
                $pid = 'mm_47800736_21362628_72092261';
                $redirect = 'https://uland.taobao.com/coupon/edetail?activityId=' . $coupon->Quan_id . '&itemId=' . $coupon->GoodsID . '&pid=' . $pid;
            } else {
                $redirect = $coupon->Quan_link;
            }
        } else {
            $redirect = 'http://coupon.juanzhuzhu.com';
        }
//        $strUrl = $urlLogic->is_weibo_app() ? Url::wbToTb($redirect) : $redirect;
        $strUrl = $urlLogic->is_weibo_app() ? 'http://coupon.juanzhuzhu.com' : $redirect;
        if ($_GET['test']){
            $strUrl = Url::wbToTb($redirect);
            pree($strUrl);
        }
        header('location:' . $strUrl);
    }
}