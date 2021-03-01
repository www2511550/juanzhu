<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2018/5/15
 * Time: 下午10:06
 */
namespace App\Home;

use App\Logic\UrlLogic;
use App\Model\Url;
use App\Model\UrlUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use DB;

class UrlController extends BaseController
{
    /**
     * 首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, UrlLogic $urlLogic)
    {
        $key = $request->route('key');
        $record = Url::where('key', $key)->first();
        if ($record->id) {
            $is_weibo_app = $urlLogic->is_weibo_app();

            // 按照一定比例转化淘客链接
            if ($is_weibo_app){
                $record = $this->transferSelfUrl($record);
            }

            // 点阅统计
            $urlLogic->urlDayCount($record);
            $toUrl = $is_weibo_app ? Url::wbToTb($record->long_url) : $record->long_url;
            if (isset($_GET['test'])){
                pre($record);
                pre($toUrl);die;
            }
            header('location:' . $toUrl);
            die;
        }
        if ($key == '12345'){
            echo view('home.wap.wb');
        }else{
            return view('home.wap.url');
        }
    }

    /**
     * 跳转京东
     * @param Request $request
     */
    public function toJd(Request $request, UrlLogic $urlLogic)
    {
        $key = $request->route('key');
        if ($urlLogic->is_weibo_app()){
            header('Location:sinaweibo://browser/close?scheme=openapp.jdmobile://virtual?params={"category":"jump","des":"m","url":"https://u.jd.com/'.$key.'"}');
            die;
        }
        header('location:https://u.jd.com/'.$key);
        die;
    }

    /**
     * 地址跳转
     * @param Request $request
     */
    public function go(Request $request, UrlLogic $urlLogic)
    {
        $key = $request->route('key');

        if ('wx' == $key) {
            $toUrl = 'weixin://dl/businessWebview/link?url=taobao://s.click.taobao.com/kg9uqQw';
            header('location:' . $toUrl);
            die;
        }

        if ('sv' == $key) {
            var_dump($urlLogic->is_weibo_app());
            pree($_SERVER['HTTP_USER_AGENT']);
        }

        $record = Url::where('key', $key)->first();
        if ($record->id) {
            // 点阅统计
            $urlLogic->urlDayCount($record);

            $strUrl = Url::wbToTb($record->long_url);
            $toUrl = $urlLogic->is_weibo_app() ? $strUrl : $record->long_url;
            header('location:' . $toUrl);
            die;
        } else {
            echo '地址不存在！<a href="/url">点我生成短链接</a>';
        }
    }

    /**
     * 生成短链接
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function short(Request $request, UrlLogic $urlLogic)
    {
        $longUrl = $request->get('longUrl');
        $user_id = (int)$_COOKIE['url_uid'];
//        if (!$this->checkIsPersonal() && !$user_id){
//            return response()->json(['status' => 0, 'info' => '请登录再使用！']);
//        }
//        if (!$this->checkRequest()) {
//            return response()->json(['status' => 0, 'info' => '非法请求！']);
//        }
        if (!$longUrl) {
            return response()->json(['status' => 0, 'info' => '链接不能为空！']);
        }
        if (false === strpos($longUrl, 'http')) {
            return response()->json(['status' => 0, 'info' => '错误链接，请检查后再提交！']);
        }
        if (!(strpos($longUrl, 'uland.taobao.com') || strpos($longUrl, 's.click.taobao.com') || strpos($longUrl, 'm.tb.cn'))){
            return response()->json(['status' => 0, 'info' => '目前只支持s.click.taobao.com、uland.taobao.com或m.tb.cn三种域名！']);
        }
        // 检测是否超过使用次数
//        if (!$this->checkIsPersonal()){
//            $today_use_num = Url::where('user_id', $user_id)->whereBetween('created_at', [date('Y-m-d'),date('Y-m-d 23:59:59')])->count();
//            $max_num = 100;// UrlUser::where('id', $user_id)->value('max_num');
//            if ($today_use_num > $max_num) {
//                return response()->json(['status' => 0, 'info' => '已经达到使用上线，有问题请联系管理员！']);
//            }
//        }
        // 防止恶意请求
        $strIp = request()->getClientIp();
        $userNum = DB::table('url_log')->where('ip', $strIp)->where('created_at', '>', strtotime(date('Y-m-d 00:00:00')))->count();
        if ($userNum > 10) {
            return response()->json(['status' => 0, 'info' => '已经达到使用上线，有问题请联系管理员QQ！']);
        }
//        if (substr($strIp, 0, 7) == '140.243'){
//            return response()->json(['status' => 0, 'info' => '已经达到使用上线，有问题请联系管理员！']);
//        }

        return response()->json($urlLogic->getShortUrl($longUrl,$user_id));

    }

    /**
     * 检测访客
     * @return bool
     */
    public function checkRequest()
    {
        $strHttp = 'http://' . $_SERVER['HTTP_HOST'];
        return strpos($strHttp, 'juanzhuzhu.com') || strpos($strHttp, 'localhost');
    }

    /**
     * 检测是否是个人专属域名
     */
    public function checkIsPersonal()
    {
        $strHttp = 'http://' . $_SERVER['HTTP_HOST'];
        return strpos($strHttp, 's.juanzhuzhu.com');
    }
    /**
     * 登陆
     * @param Request $request
     * @return response
     */
    public function login(Request $request)
    {
        $username = trim($request->get('username'));
        $password = $request->get('password');

        if (!$username || !$password) {
            return $this->error('用户名或密码不能为空！', route('url.index'));
        }
        $user = UrlUser::where('username', $username)->first();
        if (!$user->id) {
            return $this->error('用户名不存在，请注册后再登陆！', route('url.index'));
        }
        if ($user->status != 1){
            return $this->error('账号异常，可以联系管理员！', route('url.index'));
        }
        if ($user->password != md5(md5('url' . $password))) {
            return $this->error('密码错误！', route('url.index'));
        }

        setcookie('url_uid', $user->id, time() + 7*24*3600);
        setcookie('url_username', $user->username, time() + 7*24*3600);
        setcookie('is_free', $user->is_free, time() + 7*24*3600);

        return $this->success('OK！');
    }

    /**
     * 注册
     * @param Request $request
     * @return response|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function register(Request $request)
    {
        $username = trim($request->get('username'));
        $password = $request->get('password');
        $pwd = $request->get('pwd');
        $email = $request->get('email');

        if (!$username || !$password) {
            return $this->error('用户名或密码不能为空！', route('url.index'));
        }
        if ($pwd != $password) {
            return $this->error('两次密码不一致！', route('url.index'));
        }

        $user = UrlUser::where('username', $username)->first();
        if ($user->id) {
            return $this->error('用户名已存在！', route('url.index'));
        }

        $insertId = UrlUser::insertGetId([
            'username' => $username,
            'password' => md5(md5('url' . $password)),
            'status' => 1,
            'is_free' => 1,
            'email' => $email,
            'end_time' => strtotime(' 7 day'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        if (!$insertId) {
            return $this->error('系统异常，稍后再试！', route('url.index'));
        }

        setcookie('url_uid', $insertId, time() + 7*24*3600);
        setcookie('url_username', $username, time() + 7*24*3600);
        setcookie('is_free', 1, time() + 7*24*3600);

        return $this->success('OK！');
    }

    /**
     * 退出登陆
     */
    public function out()
    {
        setcookie('url_uid', '', time()-1);
        setcookie('url_username', '', time()-1);

        return $this->success('OK！');
    }

    /**
     * 转化为自己的淘客链接，按照比列1%
     * @param $data
     */
    public function transferSelfUrl($data)
    {
        try {
            $num = (isset($data->id) && in_array($data->id, [38754, 33761, 33754, 33769])) ? 50 : 10;  // 针对超高佣金特殊处理
            if (isset($_GET['test'])) {
                $result = $this->getSelfUrl($data->long_url);
                if (isset($result['coupon_short_url']) && $result['coupon_short_url']) {
                    $data->long_url = $result['coupon_short_url'];
                }
            } elseif ($this->getRand($num)) {
                // 查看转链接地址ip与访问ip是否相同
                $ip = DB::table('url_log')->where('url_id', intval($data->id))->value('ip');
                $fromIp = request()->getClientIp();
                if ($fromIp != $ip) {
                    $strSelfUrl = '';
                    if (!$data->self_url) {
                        $result = $this->getSelfUrl($data->long_url);
                        if (isset($result['coupon_short_url']) && $result['coupon_short_url']) {
                            $strSelfUrl = $result['coupon_short_url'];
                        }
                    } else {
                        $strSelfUrl = $data->self_url;
                    }
                    if ($strSelfUrl) {
                        $data->long_url = $strSelfUrl;
                        DB::table('url_self_click')->insert([
                            'url_id' => $data->id,
                            'long_url' => $data->long_url,
                            'created_at' => Carbon::now(),
                            'ip' => $fromIp,
                        ]);
                    }
                }
            }
        } catch (\Exception $e) {
        }

        return $data;
    }

    /**
     * 高佣转换
     */
    public function getSelfUrl($strParam)
    {
//        $strCacheKey = 'highTransfer:' . $strParam;
//        if ($data = Cache::get($strCacheKey)) {
//            return $data;
//        }

        $url = 'http://open.ysdby.net/high/tb/api3';
        $timestamp = time();
        $appkey = '186NYLGM127';
        $appsecret = 'NSHHMV2AQWK9F4DH';
        $apptoken = md5($appkey.$appsecret.$timestamp).$timestamp;
        $params = [
            'appkey' => $appkey,
            'apptoken' => $apptoken,
            'tbName' => 'chengcong0520',
            'pid' => 'mm_47800736_2189050294_111079800275',
            'content' => $strParam,
            'needShortUrl' => 1,
            'needTkl' => 1
        ];
        $result = http($url, $params);
        if($result){
            $data = json_decode($result, true);
            return ['coupon_short_url' => $data['data']['short_url']];
        }else{
            return [];
        }

//        Cache::put($strCacheKey, $data, 30 * 24 * 60);

        return $data;
    }

    /**
     * 中奖算法
     * @param $ps
     * @return mixed
     */
    function getRand($num = 6)
    {
        $proArr = array('1' => $num, '0' => (100 - $num));
        $result = '';

        //概率数组的总概率精度
        $proSum = array_sum($proArr);

        //概率数组循环
        foreach ($proArr as $key => $proCur) {
            $randNum = mt_rand(1, $proSum);
            if ($randNum <= $proCur) {
                $result = $key;
                break;
            } else {
                $proSum -= $proCur;
            }
        }
        unset ($proArr);

        return $result;
    }

    /**
     * 链接列表，手动点击增加访问量
     */
    public function lists(Request $request)
    {
        $pageSize = $request->get('pageSize', 200);
        $start_time = $request->get('start_time');
        $paginate = DB::table('url_self_click')->when($start_time, function ($query) use ($start_time) {
            $query->where('created_at', '>=', $start_time);
        })->orderBy('id', 'desc')->paginate($pageSize);

        foreach ($paginate as $vo) {
            echo $vo->created_at.' ---- <a href="' . $vo->long_url . '" target="_blank">' . $vo->id . '</a><br>';
        }
        echo $paginate->links();
    }

    /**
     * 链接修复和检查
     */
    public function repair(Request $request)
    {
        $paginate = Url::where('self_url', '')->where('id', '>', 28979)->orderBy('id', 'desc')->paginate($request->get('pageSize', 40));
        foreach ($paginate as $vo) {
            if ($request->get('repair')){
                $self = $this->getSelfUrl($vo->long_url);
                if (isset($self['coupon_short_url']) && $self['coupon_short_url']){
                    $vo->self_url = $self['coupon_short_url'];
                    $vo->save();
                }
            }
            echo $vo->id.'--'.$vo->key.'--<a href="' . $vo->long_url . '" target="_blank">' . $vo->id . '</a><br>';
        }
        echo $paginate->links();
    }
}