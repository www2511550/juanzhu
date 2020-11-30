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
use App\Model\Url;
use App\Model\UrlUser;
use App\Service\HaodankuService;
use App\Service\ToolService;
use Illuminate\Http\Request;

class ToolController extends BaseController
{
    public $user;

    public function __construct()
    {
        parent::__construct();
        $this->user = UrlUser::find(intval($_COOKIE['url_uid']));
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

            $user = UrlUser::where('username', $username)->first();
            if ($user->id) {
                return response()->json(['status' => 0, 'info' => '用户名已存在！！']);
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
                return response()->json(['status' => 0, 'info' => '系统异常，稍后再试！！']);
            }

            setcookie('url_uid', $insertId, time() + 7 * 24 * 3600, '/');
            setcookie('url_username', $username, time() + 7 * 24 * 3600, '/');
            setcookie('is_free', 1, time() + 7 * 24 * 3600, '/');

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
            return view('tool.weibo');
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
            $quanInfo = $toolLogic->getQuanUrlByPid($url, $pid, 1);
            if (!$quanInfo){
                return response()->json(['status'=>0, 'info'=>'未找到联盟商品']);
            }
            $weibo = (new UrlLogic())->getShortUrl($quanInfo['coupon_short_url'], 3);
            $data = $quanInfo['title'].PHP_EOL.'微博跳手淘APP：'.$weibo['data']['url'].PHP_EOL
                .'淘口令：'.$quanInfo['tbk_pwd'];

            return response()->json(['status'=>1, 'data'=>$data]);
        } else {
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
            $quanInfo = $toolLogic->getQuanUrlByPid($url, 'mm_47800736_21362628_72092261', 1);
            if (!$quanInfo) {
                return response()->json(['status' => 0, 'info' => '未找到联盟商品']);
            }
            $data = $quanInfo['title'] . PHP_EOL . '商品id：' . $quanInfo['num_iid'] . PHP_EOL
                . '商品地址：' . $quanInfo['item_url'];

            return response()->json(['status' => 1, 'data' => $data]);
        } else {
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
            return view('tool.tklCreate');
        }
    }

    /**
     * 淘宝短链接生成
     */
    public function shortUrl(Request $request, UrlLogic $urlLogic)
    {
        if ($request->method() == 'POST') {
            if (!($url = $request->get('url')) || strpos($request->get('url'), 'http') !== 0) {
                return ['status' => 0, 'info' => '请输入正确的链接地址！'];
            }
            if (!(strpos($url, 'uland.taobao.com') || strpos($url, 's.click.taobao.com'))){
                return response()->json(['status' => 0, 'info' => '目前只支持s.click.taobao.com和uland.taobao.com域名！']);
            }
            return $urlLogic->getShortUrl($url, intval($_COOKIE['url_uid']));
        } else {
            return view('tool.shortUrl');
        }
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
            foreach ($arr[0] as $v) {
                if ('http' !== substr($v, 0, 4)) continue;
                $tmp = explode($v, $str);
                $_tmp[] = $tmp[0];
                // 新浪url转成淘宝url
                $taobaoUrl = $this->transferSinaUrl($v);
                $selfUrl = $this->getSelfUrl($taobaoUrl, 1);
                $_tmp[] = '拍 '.$selfUrl['url'].' [最右] 打不开链接的小可爱，复制('.($selfUrl['tkl'] ? mb_substr($selfUrl['tkl'], 1, -1, 'utf8') : '' ).')后打开手淘';
                $str = $replaceOnce($tmp[0] . $v, '', $str);
            }
            $content = join($_tmp, ' ');
            return response()->json(['status' => 1, 'data' => $content]);
        } else {
            return view('tool.text');
        }
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
                $url = 'http://b.juanzhuzhu.com/' . $record->key;
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
                    $url = 'http://b.juanzhuzhu.com/' . $strKey;
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

}