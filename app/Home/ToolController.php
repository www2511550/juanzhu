<?php
/**
 * 工具类
 * User: chengcong
 * Date: 2018/12/12
 * Time: 下午8:28
 */
namespace App\Home;

use App\Logic\TaobaoLogic;
use App\Logic\ToolLogic;
use App\Logic\UrlLogic;
use App\Logic\WeiboLogic;
use App\Model\Url;
use App\Model\UrlUser;
use App\Service\HaodankuService;
use App\Service\ToolService;
use Illuminate\Http\Request;

class ToolController extends BaseController
{
    public $user, $pid;

    public function __construct()
    {
        parent::__construct();
        $this->user = UrlUser::find(intval($_COOKIE['url_uid']));
        $this->pid = 'mm_113220731_2218350342_111200050341';
        view()->share('a','');
    }

    /**
     * 微博跳app生产页面
     */
    public function wbapp(Request $request)
    {
        return view('tool.wbapp');
    }
    /**
     * 登陆
     */
    public function login(Request $request)
    {
        if ($request->method() == 'POST') {
            $username = trim($request->get('username'));
            $password = $request->get('password');

            if (!$username || !$password) {
                return response()->json(['status'=>0, 'info'=>'用户名或密码不能为空']);
            }
            $user = UrlUser::where('username', $username)->first();
            if (!$user->id) {
                return response()->json(['status'=>0, 'info'=>'用户名不存在，请注册后再登陆！']);
            }
            if ($user->status != 1){
                return response()->json(['status'=>0, 'info'=>'账号异常，可以联系管理员！']);
            }
            if ($user->password != md5(md5('url' . $password))) {
                return response()->json(['status'=>0, 'info'=>'密码错误！']);
            }
            setcookie('url_uid', $user->id, time() + 7*24*3600, '/');
            setcookie('url_username', $user->username, time() + 7*24*3600, '/');
            setcookie('is_free', $user->is_free, time() + 7*24*3600, '/');
            setcookie('end_time', $user->end_time, time() + 7 * 24 * 3600, '/');

            return response()->json(['status'=>1, 'info'=>'success']);
        } else {
            return view('tool.login');
        }
    }

    /**
     * 注册
     */
    public function register(Request $request)
    {
        if ($request->method() == 'POST') {
            $username = trim($request->get('username'));
            $password = $request->get('password');
            $email = $request->get('email');

            if (!$username || !$password) {
                return response()->json(['status' => 0, 'info' => '用户名或密码不能为空！']);
            }
            // 用户名改用邮箱，方便后续找回
            $pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
            if (!preg_match($pattern, $username)) {
                return response()->json(['status' => 0, 'info' => '请输入正确的邮箱格式！']);
            }

            $user = UrlUser::where('username', $username)->first();
            if ($user->id) {
                return response()->json(['status' => 0, 'info' => '用户名已存在！！']);
            }

            $end_time = strtotime(' 1 day'); // 试用期一天
            $insertId = UrlUser::insertGetId([
                'username' => $username,
                'password' => md5(md5('url' . $password)),
                'status' => 1,
                'is_free' => 1,
                'email' => $email,
                'end_time' => $end_time,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            if (!$insertId) {
                return response()->json(['status' => 0, 'info' => '系统异常，稍后再试！！']);
            }

            setcookie('url_uid', $insertId, time() + 7 * 24 * 3600, '/');
            setcookie('url_username', $username, time() + 7 * 24 * 3600, '/');
            setcookie('is_free', 1, time() + 7 * 24 * 3600, '/');
            setcookie('end_time', $end_time, time() + 7 * 24 * 3600, '/');

            return response()->json(['status' => 1, 'info' => 'success']);
        } else {
            return view('tool.register');
        }
    }

    /**
     * 退出
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function out()
    {
        setcookie('url_uid', '', time() - 100, '/');
        setcookie('url_username', '', time() - 100, '/');

        return $this->success('退出成功！');
    }

    /**
     * 首页
     */
    public function index(Request $request)
    {
        if ($request->method() == 'POST') {

        } else {
            return view('tool.index');
        }

    }

    /**
     * 微博跳转淘宝app
     */
    public function weiboToTaobao(Request $request)
    {
        if ($request->method() == 'POST') {

        } else {
            view()->share('a', 'weibo-to-taobao');
            return view('tool.weibo');
        }

    }

    /**
     * 微博跳转拼多多app
     */
    public function weiboToPinduoduo(Request $request)
    {
        if ($request->method() == 'POST') {

        } else {
            view()->share('a', 'weibo-to-pinduoduo');
            return view('tool.pinduoduo');
        }

    }

    /**
     * 微博跳转京东app
     */
    public function weiboToJd(Request $request)
    {
        if ($request->method() == 'POST') {

        } else {
            view()->share('a', 'weibo-to-jd');
            return view('tool.jd');
        }

    }

    /**
     * 他人链接转为自己链接
     */
    public function toSelfUrl(Request $request, ToolLogic $toolLogic)
    {
        if ($request->method() == 'POST') {
            $url = trim($request->get('content'));
            $pid = $request->get('pid') ?: $this->user->tbk_pid;
            if (!$pid){
                return response()->json(['status'=>0, 'info'=>'请选择联盟PID']);
            }
            $tbkSession = trim($request->get('tbk_session')) ? trim($request->get('tbk_session')) : $this->user->tbk_session;
            if (!$tbkSession){
                return response()->json(['status'=>0, 'info'=>'请填写授权session']);
            }
            $quanInfo = $toolLogic->tklExplainAndConvert($url, $pid, $tbkSession);
            if (!$quanInfo['status']){
                return response()->json(['status'=>0, 'info'=>'未找到联盟商品']);
            }
            $weibo = (new UrlLogic())->getShortUrl($quanInfo['coupon_url'], 3);
            $data = '微博跳手淘APP：'.$weibo['data']['url'].PHP_EOL
                .'淘口令：'.$quanInfo['data']['tkl'];

            return response()->json(['status'=>1, 'data'=>$data]);
        } else {
            view()->share('a', 'to-self-url');
            return view('tool.toSelfUrl');
        }
    }

    /**
     * 口令解密
     */
    public function tklDecrypt(Request $request, ToolLogic $toolLogic)
    {
        if ($request->method() == 'POST') {
            $url = $request->get('content');
            $quanInfo = $toolLogic->getQuanUrlByPid($url, $this->pid, 1);
            if (!$quanInfo) {
                return response()->json(['status' => 0, 'info' => '未找到联盟商品']);
            }
            $data = $quanInfo['title'] . PHP_EOL . '商品id：' . $quanInfo['num_iid'] . PHP_EOL
                . '商品地址：' . $quanInfo['item_url'];

            return response()->json(['status' => 1, 'data' => $data]);
        } else {
            view()->share('a', 'tkl-decrypt');
            return view('tool.tklDecrypt');
        }
    }

    /**
     * 淘口令生成
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tklCreate(Request $request, ToolLogic $toolLogic)
    {
        if ($request->method() == 'POST') {
            if (!($content = $request->get('content'))) {

            }
            if (!($toUrl = $request->get('to_url'))) {

            }
            return $toolLogic->createTkl($content, $toUrl, $request->get('logo_url', ''));
        } else {
            view()->share('a', 'tkl-create');
            return view('tool.tklCreate');
        }
    }

    /**
     * 淘宝短链接生成，支持口令和链接
     */
    public function shortUrl(Request $request, ToolLogic $toolLogic)
    {
        if ($request->method() == 'POST') {
            if (!($url = $request->get('url'))) {
                return ['status' => 0, 'info' => '请输入正确的链接地址或口令！'];
            }
            // 判断是链接还是口令
            if (strpos($url, 'http') !== 0){
                $result = $toolLogic->tklUrlGet($url, 1);
                if (!$result['status']){
                    return $result;
                }
                $url = $result['data']['url'];
            }else{
                // 链接
                if (!(strpos($url, 'm.tb.cn') || strpos($url, 's.click.taobao.com') || strpos($url, 'uland.taobao.com'))){
                    return response()->json(['status' => 0, 'info' => '链接只支持s.click.taobao.com、m.tb.cn和uland.taobao.com域名！']);
                }
                if (strpos($url, 'uland.taobao.com')){
                    $requestData = json_decode(http('http://tk.2yhq.top/api/tbk/short-url', ['url'=>$url]), true);
                    if (!$requestData['status']){
                        return $requestData;
                    }
                    $url = $requestData['data'];
                }
            }

            return $toolLogic->getWeiboShortUrl($url, 'tb');
        } else {
            view()->share('a', 'short-url');
            return view('tool.shortUrl');
        }
    }

    /**
     * 微博拼多多，京东app短链接
     */
    public function short(Request $request, ToolLogic $toolLogic)
    {
        $longUrl = $request->get('longUrl') ?: $request->get('url');
        $type = $request->get('type');
        if (!in_array($type, ['pdd', 'jd']) || !$longUrl){
            return ['status'=>0, 'info'=>'参数错误！'];
        }
        if ($type == 'pdd' && !strpos($longUrl, 'pinduoduo.com')){
            return response()->json(['status' => 0, 'info' => '非拼多多链接不支持转换！']);
        }
        if ($type == 'jd' && !strpos($longUrl, 'jd.com')){
            return response()->json(['status' => 0, 'info' => '非京东链接不支持转换！']);
        }

        return $toolLogic->getWeiboShortUrl($longUrl, $type);
    }

    /**
     * 高佣金api
     */
    public function highRate(Request $request, ToolLogic $toolLogic)
    {
        if ($request->method() == 'POST') {
            if (!($itemId = $request->get('itemId'))) {
                return ['status' => 0, 'info' => '请输入正确的商品id！'];
            }
            $pid = $request->get('pid') ?: $this->user->tbk_pid;
            if (!$pid) {
                return ['status' => 0, 'info' => '请输入联盟PID！'];
            }
            // pid拆分
            $arrPid = explode('_', $pid);
            if (count($arrPid) != 4) {
                return ['status' => 0, 'info' => '请输入正确的联盟PID！'];
            }
            $tbkSession = $request->get('session') ?: $this->user->tbk_session;
            if (!$tbkSession) {
                return ['status' => 0, 'info' => '请输入正确的授权session！'];
            }

            return $toolLogic->getHighRate($itemId, $arrPid[2], $arrPid[3], $tbkSession, $this->user->id);
        } else {
            view()->share('a', 'high-rate');
            return view('tool.highRate');
        }
    }

    /**
     * 淘宝客订单
     */
    public function tbkOrder(Request $request, ToolLogic $toolLogic)
    {
        if ($request->method() == 'POST') {
            $start_time = $request->get('start_time');
            if (false === strtotime($start_time)){
                return response()->json(['status'=>0, 'info'=>'请填写正确的开始时间！']);
            }
            $tbkSession = trim($request->get('tbk_session')) ? trim($request->get('tbk_session')) : $this->user->tbk_session;
            if (!$tbkSession){
                return response()->json(['status'=>0, 'info'=>'请填写授权session']);
            }

            $data = $toolLogic->getTbOrder($start_time, $tbkSession);

            return response()->json(['status'=>1, 'data'=>$data]);
        } else {
            view()->share('a', 'tbk-order');
            return view('tool.tbkOrder');
        }
    }

    /**
     * 个人中心
     */
    public function personal(Request $request)
    {
        $url_uid = $_COOKIE['url_uid'];
        $user = UrlUser::find($url_uid);
        if ($request->method() == 'POST') {
            if (!isset($user->id)){
                return response()->json(['status'=>0, 'info'=>'请登录后在操作！']);
            }
            $tbk_session = trim($request->get('tbk_session'));
            $tbk_pid = trim($request->get('tbk_pid'));
            if (!($tbk_session || $tbk_pid)){
                return response()->json(['status'=>0, 'info'=>'授权或联盟pid不能为空！']);
            }
            if ($tbk_session){
                if (strlen($tbk_session) < 80){
                    return response()->json(['status'=>0, 'info'=>'授权码长度错误，如有疑问联系管理员！']);
                }
                // 新session，更新有效期
                if ($user->tbk_session != $tbk_session){
                    $user->tbk_session = $tbk_session;
                    $user->session_created_at = time();
                }
            }
            if ($tbk_pid){
                if (substr($tbk_pid, 0, 3) != 'mm_'){
                    return response()->json(['status'=>0, 'info'=>'联盟PID格式错误！']);
                }
                $user->tbk_pid = $tbk_pid;
            }
            $user->save();
            return response()->json(['status'=>1, 'info'=>'保存成功！']);
        }else{
            if ($user && $user->session_created_at > 0){
                $useDay = ceil((time() - $user->session_created_at)/3600/24);
                $user->last_day = $useDay >= 30 ? 0 : (30 - $useDay);
            }
            return view('tool.personal', compact('user'));
        }

    }

    /**
     * 优惠券查找
     */
    public function search(Request $request, HaodankuService $haodankuService)
    {
        $data = [];
        $toolService = new ToolService();
        $result = $haodankuService->search('女装');
        if ($result) {
            foreach ($result as $val) {
                $couponurl = $val['couponurl'] . '&pid=mm_47800736_21362628_72084401';
                $shortCouponUrl = $toolService->getShortUrl($couponurl);
                $data[] = [
                    'itemtitle' => $val['itemtitle'],
                    'couponstarttime' => $val['couponstarttime'],
                    'couponendtime' => $val['couponendtime'],
                    'couponmoney' => $val['couponmoney'],
                    'activityid' => $val['activityid'],
                    'itemprice' => $val['itemprice'],
                    'couponurl' => $shortCouponUrl ?: $couponurl,
                ];

                pre($shortCouponUrl);
                die;
                pre($highUrl);
                pre($data);
                die;
            }
        }
        return response()->json(['status' => 1, 'data' => $data]);
        if ($request->method() == 'POST') {
            $data = $haodankuService->search('女装');
        } else {
            return view('tool.links');
        }
    }


    public function test(Request $request)
    {
//        $url = 'https://p.pinduoduo.com/ygZcZjcX';
        $url = 'https://u.jd.com/ih7ggQm';
        $weiboLogic = new WeiboLogic();
        $data = $weiboLogic->wbToApp($url, 'jd');
        pre($data);die;

//        $url = 'https://api.open.21ds.cn/apiv1/sclicktoid';
//        $params = [
//            'apkey' => '5c42cb82-d83d-f473-1268-f65d14e8f62e',
//            'sclickurl' => $request->get('url'),
//        ];
//        $result = http($url, $params);
//        pre($result);die;

        $url = 'https://api.open.21ds.cn/apiv1/gettbshorturl';
        $params = [
            'apkey' => '5c42cb82-d83d-f473-1268-f65d14e8f62e',
            'url' => urlencode('https://uland.taobao.com/coupon/edetail?e=0rCw5S9e8kcGQASttHIRqZ3zztpA4xe98s%2Bz5%2F%2FStC%2BsFjEX7akjeyfuVmp%2BDJOKwh5M8aKs798616ZhS6UQhY1qE%2Bxryk77GyW%2B9l4dctD0pRrjipOmj%2Bdth9k8bqqSHKTgBzHkoM7XTQC0vfau6E%2F9Zk7cDx8UPY2GSU4OeGfJJou2Mb1Is%2BrxULtiuQMn&traceId=0b01782d15507553985734086e&union_lens=lensId:0bb698e5_0bc3_169103983be_9771&xId=D0Vbd3Z6VUGVrwqXDpPEel38hMEKQ3i5ZbyeDK6yUacUU3BWHDixCOpMMcx1s3atzovyeRh6XLzvGGkSZykEe2&thispid=mm_314610028_313700444_87055650474&src=fklm_hltk&from=tool&sight=fklm'),
        ];
        $result = json_decode(http($url, $params), true);
        if ($result['code'] == 200){
            return ['status' => 1, 'info' => 'success', 'data' => [
                'url' => $result['data']
            ]];
        }

        pre($result);die;

        $url = 'https://api.open.21ds.cn/apiv1/tpwdtoid';
        $params = [
            'apkey' => '5c42cb82-d83d-f473-1268-f65d14e8f62e',
            'tpwd' => '(sOzTbG36Tse)',
        ];
        $result = http($url, $params);
        pre($result);die;



//        $baseUrl = 'http://api.vephp.com/directhc';
//        $baseUrl = 'http://api.vephp.com/hcapi';
        $baseUrl = 'http://api.vephp.com/dec';
//        $baseUrl = 'http://api.vephp.com/hclink';
        $params = [
            'vekey' => 'V00000836Y52123108',
            'para' => '￥sOzTbG36Tse￥',//$request->get('url', 'https://m.tb.cn/h.3FpwdFf'),
//            'para' => 'https://s.click.taobao.com/frGPBGw',
            'pid' => 'mm_47800736_21362628_72092261',
//            'pid' => 'mm_17474597_13388964_120156186',
        ];
        $result = json_decode(http($baseUrl, $params), true);
        pre($result);die;

        $toolService = new ToolService();
        $data = $toolService->sclicktoid('https://s.click.taobao.com/xDTIkIw');


        $haodankuService = new HaodankuService();
        $data = $haodankuService->search('544113036971');
        pre($data);
    }


    /**
     * url修复
     */
    public function repairUrl(Request $request)
    {
        if ($request->method() == 'POST') {
            $id = (int)$request->get('id');
            $selfUrl = trim($request->get('selfUrl'));
//            if (!$selfUrl || !strpos($selfUrl, 's.click.taobao')) {
//                return ['status' => 0, 'info' => '请输入https://s.click.taobao.com开头的地址'];
//            }
            $record = Url::find($id);
            if (!isset($record->id)) {
                return ['status' => 0, 'info' => 'id错误'];
            }
            $record->self_url = $selfUrl;
            $record->save();
            return ['status' => 1, 'info' => '保存成功！'];
        } else {
            $paginate = Url::where('self_url', '=', '')->where('id', '>', 28000)->orderBy('id', 'desc')->paginate(20);
            return view('tool.repairUrl', ['data' => $paginate]);
        }
    }


    /**
     * 文本链接转换
     */
    public function textUrl(Request $request)
    {
        if ($request->method() == 'POST') {
            if (!($str = $request->get('content'))) {
                return ['status' => 0, 'info' => '请输入需要转换的文本内容！'];
            }
            $pid = $request->get('pid') ?: $this->user->tbk_pid;
            if (!$pid) {
                return ['status' => 0, 'info' => '请输入联盟PID！'];
            }
            // pid拆分
            $arrPid = explode('_', $pid);
            if (count($arrPid) != 4) {
                return ['status' => 0, 'info' => '请输入正确的联盟PID！'];
            }

            preg_match_all('/((http|ftp|https):\/\/)?([\w_-]+(?:(?:\.[\w_-]+)+))([\w.,@?^=%&:\/~+#-]*[\w@?^=%&\/~+#-])?/', $str, $arr);
            if (!$arr[0]) {
                return ['status' => 0, 'info' => '未检测到链接'];
            }
            $replaceOnce = function ($needle, $replace, $haystack) {
                $pos = strpos($haystack, $needle);
                if ($pos === false) {
                    return $haystack;
                }
                return substr_replace($haystack, $replace, $pos, strlen($needle));
            };
            $_tmp = [];
            $toolLogic = new ToolLogic();
            foreach ($arr[0] as $v) {
                if ('http' !== substr($v, 0, 4)) continue;
                $tmp = explode($v, $str);
                $_tmp[] = $tmp[0];
                // 新浪url转成淘宝url
                $taobaoUrl = $this->transferSinaUrl($v);
                $_tmp[] = $toolLogic->getQuanUrlByPid($taobaoUrl, $pid);
                $str = $replaceOnce($tmp[0] . $v, '', $str);
            }
            $content = join($_tmp, ' ');
            return response()->json(['status' => 1, 'data' => $content]);
        } else {
            return view('tool.textUrl');
        }
    }

    /**
     * 文本链接转换，自己使用
     */
    public function text(Request $request)
    {
        if ($request->method() == 'POST') {
            if (!($str = $request->get('content'))) {
                return ['status' => 0, 'info' => '请输入需要转换的文本内容！'];
            }

            // 临时测试调用
            return $this->textTkl($str);


            preg_match_all('/((http|ftp|https):\/\/)?([\w_-]+(?:(?:\.[\w_-]+)+))([\w.,@?^=%&:\/~+#-]*[\w@?^=%&\/~+#-])?/', $str, $arr);
            if (!$arr[0]) {
                return ['status' => 0, 'info' => '未检测到链接'];
            }
            $replaceOnce = function ($needle, $replace, $haystack) {
                $pos = strpos($haystack, $needle);
                if ($pos === false) {
                    return $haystack;
                }
                return substr_replace($haystack, $replace, $pos, strlen($needle));
            };
            $_tmp = [];
            $total_url = count($arr[0]);
            foreach ($arr[0] as $k =>$v) {
                if ('http' !== substr($v, 0, 4)) {
                    continue;
                }
                $tmp = explode($v, $str);
                $_tmp[] = $tmp[0];
                $self_short_url = '【链接未识别！】';
                // 转自己的短链接
                if (strpos($v, 'jd.com')){
                    $result = json_decode(http('http://tk.2yhq.top/api/tbk/jd-goods', ['url'=>$v]), true);
                    if ($result['status'] == 1){
                        $self_short_url = $result['data']['shortUrl'];
                    }
                }elseif(strpos($v, 'pinduoduo.com')){
                    $result = json_decode(http('http://tk.2yhq.top/api/tbk/pdd-goods', ['url'=>$v]), true);
                    if ($result['status'] == 1){
                        $self_short_url = $result['data']['mobileShortUrl'];
                    }
                }else{
//                $taobaoUrl = $this->transferSinaUrl($v);
//                $selfUrl = $this->getSelfUrl($taobaoUrl, 1);
                }
                $_tmp[] = $self_short_url;
                $str = $replaceOnce($tmp[0] . $v, '', $str);
                if ($total_url - 1 == $k) {
                    $_tmp[] = $tmp[1];
                }
            }
            $content = join($_tmp, ' ');
            return response()->json(['status' => 1, 'data' => $content]);
        } else {

            $str = '{"leixing":"400","type":"2003","robot_wxid":"wxid_8nbdgxheva4722","from_wxid":"20327713391@chatroom","from_name":"\u8c46\u6ce1\u514d\u5355??07\u7fa4","json_msg":"{\"group_name\":\"\u8c46\u6ce1\u514d\u5355??07\u7fa4\",\"group_wxid\":\"20327713391@chatroom\",\"guest\":{\"nickname\":\"\u598d\u7199\",\"wxid\":\"wxid_auhwlq6jh6yh22\"},\"inviter\":{\"nickname\":\"BETRAYAL\",\"wxid\":\"wxid_v7y2idjkifqz22\"}}"}';
            $arr = json_decode($str, true);
            $json_msg = json_decode($arr['json_msg'], true);
            pre($json_msg);

            return view('tool.text');
        }
    }

    /**
     * 批量转淘口令
     * @param $str
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function textTkl($str)
    {
        preg_match_all('/(\w{11})/', $str, $arr);
        if (!$arr[0]) {
            return ['status' => 0, 'info' => '未检测到口令'];
        }
        $replaceOnce = function ($needle, $replace, $haystack) {
            $pos = strpos($haystack, $needle);
            if ($pos === false) {
                return $haystack;
            }
            return substr_replace($haystack, $replace, $pos, strlen($needle));
        };
        $_tmp = [];
        $total_url = count($arr[0]);
        $toolLogic = new ToolLogic();
        $weiboLogic = new WeiboLogic();
        foreach ($arr[0] as $k => $v) {
            $tmp = explode($v, $str);
//            $_tmp[] = $tmp[0];
            $_tmp[] = mb_substr($tmp[0], 0, -1, 'utf8'); // 特殊处理，口令左右两边符号去掉
            $self_short_url = '【口令未识别！】';
            // 口令转换
            $strTkl = '¥' . $v . '¥';
            $result = $toolLogic->tklUrlGet($strTkl, 1);
            if ($result['status']) {
                $self_short_url = $weiboLogic->wbToApp($result['data']['url'], 'tb');
            }

            $_tmp[] = $self_short_url;
            $str = $replaceOnce($tmp[0] . $v, '', $str);
            // 特殊处理，口令左右两边符号去掉
            $str = mb_substr($str, 1, null,'utf8');

            if ($total_url - 1 == $k) {
//                $_tmp[] = $tmp[1];
                $_tmp[] = mb_substr($tmp[1], 1, null, 'utf8'); // 特殊处理，口令左右两边符号去掉
            }
        }
        $content = join($_tmp, ' ');
        return response()->json(['status' => 1, 'data' => $content]);
    }



    /**
     * 转换层自己的链接
     * @param $strParam
     * @param $juanzhuzhu 是否生产juanzhzuhu链接，1-是
     */
    public function getSelfUrl($strParam, $juanzhuzhu = 0)
    {
        // uland.taobao.com做二次转换
        if (strpos($strParam, 'uland.taobao.com') > 0) {
            $arrShortUrl = (new ToolLogic())->getShortUrl($strParam);
            $strParam = isset($arrShortUrl['data']['url']) ? $arrShortUrl['data']['url'] : '';
        }

        $request_url = 'http://api.vephp.com/hcapi?vekey=V00000836Y52123108&para=' . $strParam;
        $result = http($request_url, []);
        $result = json_decode($result, true);
        $data = isset($result['data']) ? $result['data'] : '';
        if ($data['coupon_short_url'] && $juanzhuzhu) {
            $url = $data['coupon_short_url'];
            $record = Url::where('long_md5', md5($url))->first();
            if ($record->id) {
                $url = 'http://s.juanzhuzhu.com/' . $record->key;
            } else {
                $strKey = substr(md5($url), -8);
                $insertId = Url::insertGetId([
                    'key' => $strKey,
                    'long_url' => strpos($strParam, 's.click.taobao.com') ? $strParam : $url,
                    'user_id' => 1,
                    'long_md5' => md5($url),
                    'money' => 0,
                    'self_url' => $url,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
                if ($insertId > 0) {
                    $url = 'http://s.juanzhuzhu.com/' . $strKey;
                }
            }
        }

        return ['url'=>$url, 'tkl' => isset($data['tbk_pwd']) ? $data['tbk_pwd'] : ''];
    }

    /**
     * sina地址转换为淘客地址
     * @param $url
     * @return mixed|string
     */
    public function transferSinaUrl($url)
    {
        if (strpos($url, 'taobao.com') || strpos($url, 'tb.cn')){
            return $url;
        }
        $tkUrl = '';
        $header = get_headers($url, 1);
        if (strpos($header[0], '301') !== false || strpos($header[0], '302') !== false) {
            if (array_key_exists('Location', $header)) {
                $url = $header['Location'];
                if (is_array($url)){
                    $url = array_pop($url);
                }
                return $url ?: '';
            }
        }
        return $tkUrl;
    }

    /**
     * 创建淘礼金
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function createTlj(Request $request)
    {
        if ($request->method() == 'POST'){
            $params = $request->all();
            if (strpos($params['item_id'], 'http') === 0){
                preg_match('/id=([0-9]*)?/',$params['item_id'], $arr);
                if (!isset($arr[1])){

                }
                $params['item_id'] = $arr[1];
            }
            return json_decode(http('http://tk.2yhq.top/api/tbk/create-tlj', $params), true);
        }else{
            return view('tool.createTlj');
        }
    }


    /**
     * 商品查询
     */
    public function itemDetail(Request $request, TaobaoLogic $taobaoLogic)
    {
        $data = [];
        $url = $request->get('url');
        if (!$url){
            return ['status'=>0, 'info'=>'缺失商品链接或ID'];
        }
        if (strpos($url, 'http') === 0){
            $result = $taobaoLogic->search($url);
        }else{
            $result = $taobaoLogic->search($url, [], 1);
        }
        if (isset($result->result_list->map_data) && ($info = (array)$result->result_list->map_data)){
            $data = [
                'item_id' => $info['item_id'],
                'pic_url' => $info['pict_url'],
                'coupon_url' => $info['coupon_share_url'],
                'price' => $info['zk_final_price'],
                'coupon_amount' => $info['coupon_amount'],
                'final_price' => bcsub($info['zk_final_price'], $info['coupon_amount'], 2),
                'commission_rate' => bcdiv($info['commission_rate'], 10000, 2),
                'yongjin' => bcmul(bcdiv($info['commission_rate'], 10000, 2), bcsub($info['zk_final_price'], $info['coupon_amount'], 2), 2),
            ];
            return ['status'=>1, 'data'=>$data];
        }
        return ['status'=>0, 'data'=>$data, 'info'=>'未查询到联盟商品'];
    }

}