<?php
/**
 * 呆呆个人定制淘客工具系统
 * User: chengcong
 * Date: 2019/2/18
 * Time: 8:42 PM
 */
namespace App\Home;

use App\Logic\TaobaoLogic;
use App\Logic\ToolLogic;
use App\Logic\UrlLogic;
use App\Logic\WeiboLogic;
use App\Service\HaodankuService;
use App\Service\ToolService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DaidaiController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        if (!(isset($_COOKIE['daidai_uid']) && $_COOKIE['daidai_uid'])){
            $arrAction = request()->route()->getAction();
            if (!(isset($arrAction['as']) && in_array($arrAction['as'], ['dd.login', 'dd.register', 'dd.out']))){
                header('location:/dd/login');die;
            }
        }
    }

    /**
     * 首页
     */
    public function index(Request $request)
    {
        if ($request->method() == 'POST') {

        } else {
            // pid配置
            $config = DB::table('daidai_config')->where('status', 1)->orderBy('id', 'desc')->get();
            return is_mobile() ? view('daidai.wap.moreLink', ['config' => $config, 'action' => 'moreLink']) : view('daidai.index');
        }

    }

    /**
     * 单链接转换
     */
    public function oneLink(Request $request, ToolLogic $toolLogic)
    {
        if ($request->method() == 'POST') {
            $url = trim($request->get('content'));
            $pid = $request->get('pid');
//            $tbkSession = $request->get('tbk_session', '70000100e0397191e7b27a9266f8ecffc79581814c1003e4d0ea76b5aa8e0576d412c172652123108');
//            // 判断链接所属，只需要微博仿屏蔽，不需要转换
//            $wb_short_url = '';
//            $weiboLogic = new WeiboLogic();
//            if (strpos($url, 'jd.com')) {
//                $wb_short_url = $weiboLogic->wbToApp($url, 'jd');
//            } elseif (strpos($url, 'pinduoduo.com')) {
//                $wb_short_url = $weiboLogic->wbToApp($url, 'pdd');
//            } elseif (strpos($url, 'taobao.com') || strpos($url, 'tb.cn')) {
//                $wb_short_url = $weiboLogic->wbToApp($url, 'tb');
//            }
//
//            if ($wb_short_url) {
//                return ['status' => 1, 'data' => $wb_short_url];
//            }
//            return ['status' => 0, 'info' => '只支持jd.com，pinduoduo.com和taobo.com链接'];

            // 呆呆好单裤授权转链接口，京东和拼多多
            $apikey = 'buybuypignull';
//            $weiboLogic = new WeiboLogic();
            if (strpos($url, 'pinduoduo.com')){
                // 检测pid是否选择正确
                if (count(explode('_', $pid)) != 2){
                    return ['status'=>0, 'info'=>'拼多多pid选择错误！'];
                }
                // 短链接解析
                $headers = get_headers($url, true);
                $location = $headers['Location'];
                $arrLocaiton = explode('?', $location);
                parse_str($arrLocaiton[1], $urlParams);

                $params = ['apikey'=>$apikey, 'pid' =>$pid, 'goods_id'=>$urlParams['goods_id'], 'goods_sign'=>$urlParams['goods_sign']];
                $request_url = 'http://v2.api.haodanku.com/get_pdditems_link';
                $result = json_decode(http($request_url, $params, 'POST'), true);
                if ($result['code'] == 200){
//                    $wb_short_url = $weiboLogic->wbToApp($result['data']['shortUrl'], 'pdd');
                    // 暂时不要微博跳转功能
                    $wb_short_url = $result['data']['mobile_short_url'];
                    return ['status'=>1, 'data'=>$wb_short_url];
                }
                return ['status'=>0, 'info'=>$result['msg'] ?? '转换失败，稍后再试！'];
            }elseif(strpos($url, 'jd.com')){
                // 检测pid是否选择正确
                if (count(explode('_', $pid)) != 1){
                    return ['status'=>0, 'info'=>'京东pid选择错误！'];
                }
                $params = ['url'=>$url, 'pid'=>$pid, 'from'=>'daidai'];
                $request_url = 'http://tk.2yhq.top/api/tbk/jd-goods';
                $result = json_decode(http($request_url, $params), true);
                if ($result['status']){
//                    $wb_short_url = $weiboLogic->wbToApp($result['data']['shortUrl'], 'jd');
                    // 暂时不要微博跳转功能
                    $wb_short_url = $result['data']['shortUrl'];
                    return ['status'=>1, 'data'=>$wb_short_url];
                }
                return $result;
            }
            return ['status' => 0, 'info' => '只支持jd.com和pinduoduo.com等链接'];
        } else {
            // pid配置
            $config = DB::table('daidai_config')->where('status', 1)->orderBy('id', 'desc')->get();
            return is_mobile() ? view('daidai.wap.oneLink', ['config' => $config, 'action' => 'oneLink']) : view('daidai.oneLink', ['config' => $config]);
        }
    }

    /**
     *链接批量转换
     */
    public function moreLink(Request $request, ToolLogic $toolLogic)
    {
        if ($request->method() == 'POST') {
            $str = $request->get('content');
            $pid = $request->get('pid');
            if (!$pid) {
//                return response()->json(['status' => 0, 'info' => '请选择联盟PID']);
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
            $total_url = count($arr[0]);
            $weiboLogic = new WeiboLogic();
            foreach ($arr[0] as $k => $v) {
                if ('http' !== substr($v, 0, 4)) continue;
                $tmp = explode($v, $str);
                $_tmp[] = $tmp[0];
                $strUrl = '【链接未识别！】';
                // 新版20210305
                if (strpos($v, 'jd.com')) {
                    $strUrl = $weiboLogic->wbToApp($v, 'jd');

                } elseif (strpos($v, 'pinduoduo.com')) {
                    $strUrl = $weiboLogic->wbToApp($v, 'pdd');
                } elseif (strpos($v, 'taobao.com') || strpos($v, 'tb.cn')) {
//                    $strUrl = $weiboLogic->wbToApp($v, 'tb'); // 淘宝的屏蔽
                }
                $_tmp[] = $strUrl;
                $str = $replaceOnce($tmp[0] . $v, '', $str);
                if ($total_url - 1 == $k) {
                    $_tmp[] = $tmp[1];
                }
            }
            $content = join($_tmp, ' ');
            return response()->json(['status' => 1, 'data' => $content]);
        } else {
            // pid配置
            $config = DB::table('daidai_config')->where('status', 1)->orderBy('id', 'desc')->get();
            return is_mobile() ? view('daidai.wap.moreLink', ['config' => $config, 'action' => 'moreLink']) : view('daidai.moreLink', ['config' => $config]);
        }
    }

    /**
     * 微博跳转淘宝app
     */
    public function weiboToTaobao(Request $request)
    {
        if ($request->method() == 'POST') {

        } else {
            return is_mobile() ? view('daidai.wap.weibo', ['action' => 'weibo']) : view('daidai.weibo');
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
            return view('daidai.tklCreate');
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
            if (!(strpos($url, 'uland.taobao.com') || strpos($url, 's.click.taobao.com') || strpos($url, 'm.tb.cn'))) {
                return response()->json(['status' => 0, 'info' => '目前只支持s.click.taobao.com、m.tb.cn和uland.taobao.com域名！']);
            }
            return $urlLogic->getShortUrl($url, 3);
        } else {
            return view('daidai.shortUrl');
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


        $url = 'https://api.open.21ds.cn/apiv1/tpwdtoid';
        $params = [
            'apkey' => '5c42cb82-d83d-f473-1268-f65d14e8f62e',
            'tpwd' => '(sOzTbG36Tse)',
        ];
        $result = http($url, $params);
        pre($result);
        die;


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
        pre($result);
        die;

        $toolService = new ToolService();
        $data = $toolService->sclicktoid('https://s.click.taobao.com/xDTIkIw');


        $haodankuService = new HaodankuService();
        $data = $haodankuService->search('544113036971');
        pre($data);
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
            return view('daidai.textUrl');
        }
    }

    /**
     * sina地址转换为淘客地址
     * @param $url
     * @return mixed|string
     */
    public function transferSinaUrl($url)
    {
        if (strpos($url, 'taobao.com') || strpos($url, 'tb.cn')) {
            return $url;
        }
        $tkUrl = '';
        $header = get_headers($url, 1);
        if (strpos($header[0], '301') !== false || strpos($header[0], '302') !== false) {
//            $data = 'http://1.coupongirl.applinzi.com/fdasf.php?get=cy5jbGljay50YW9iYW8uY29tL3A1cFVsRnc=';
//            pre($this->get_content($data));die;
//            pre($header['Location']);die;
            if (array_key_exists('Location', $header)) {
                $url = $header['Location'];
                if (is_array($url)) {
                    $url = array_pop($url);
                }
                return $url ?: '';
            }
        }
        return $tkUrl;
    }

    /**
     * 配置设置
     */
    public function setConfig(Request $request)
    {
        if ($request->method() == 'POST') {
            $pid = $request->get('pid');
            $name = $request->get('pid_name');
            // pid拆分
            $arrPid = explode('_', $pid);
            if (count($arrPid) != 4 || $arrPid[0] != 'mm') {
                return ['status' => 0, 'info' => '请输入正确的联盟PID！'];
            }
            // 存储
            $insert = ['pid' => $pid, 'name' => $name];
            $config = DB::table('daidai_config')->where('pid', $pid)->first();
            if ($config) {
                $insert['updated_at'] = Carbon::now();
                $status = DB::table('daidai_config')->where('id', $config->id)->update($insert);
            } else {
                $insert['created_at'] = $insert['updated_at'] = Carbon::now();
                $status = DB::table('daidai_config')->insert($insert);
            }
            if (false === $status) {
                return response()->json(['status' => 0, 'info' => '服务器异常，稍后再试！']);
            }
            return response()->json(['status' => 1, 'info' => '保存成功！']);
        } else {
            return view('daidai.setConfig');
        }
    }

    /**
     * 呆呆专属，记得提醒他每个月去授权
     * @param $itemid
     * @return array
     */
    public function getHighRateById($itemid, $pid, $activityid = '')
    {
        $arrConfig = ['312490106' => 'tkmai3', '353600165' => 'tkcb4'];
        $arrPid = explode('_', $pid);
        $request_url = 'http://v2.api.haodanku.com/ratesurl/ratesurl';
        $request_data['apikey'] = 'buybuypignull';
        $request_data['itemid'] = $itemid;
        $request_data['activityid'] = $activityid;
        if (isset($arrConfig[$arrPid[1]]) && $arrConfig[$arrPid[1]]) {
            $request_data['pid'] = $pid;
            $request_data['tb_name'] = $arrConfig[$arrPid[1]];
        } else { // 默认配置
            $request_data['pid'] = 'mm_312490106_356400025_99534050095';
            $request_data['tb_name'] = 'tkmai3';
        }

        $res = http($request_url, $request_data, 'POST');
        $result = json_decode($res, true);
        if (isset($result['data']['item_url'])) {
//        if (isset($result['data']['coupon_click_url'])){
//            return $result['data']['coupon_click_url'] ?: $result['data']['item_url'];
            return $result['data']['item_url'];
        } else {
            return '';
        }
    }

    /**
     * 登录
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    function login(Request $request)
    {
        if ($request->method() == 'POST') {
            $username = trim($request->get('username'));
            $password = $request->get('password');

            if (!$username || !$password) {
                return response()->json(['status' => 0, 'info' => '用户名或密码不能为空']);
            }
            $user = DB::table('daidai_user')->where('username', $username)->first();
            if (!$user->id) {
                return response()->json(['status' => 0, 'info' => '用户名不存在，请注册后再登陆！']);
            }
            if ($user->status != 1) {
                return response()->json(['status' => 0, 'info' => '账号异常，可以联系管理员！']);
            }
            if ($user->password != md5(md5('url' . $password))) {
                return response()->json(['status' => 0, 'info' => '密码错误！']);
            }
            setcookie('daidai_uid', $user->id, time() + 7 * 24 * 3600, '/');
            setcookie('daidai_username', $user->username, time() + 7 * 24 * 3600, '/');
            setcookie('daidai_pid', $user->pid, time() + 7 * 24 * 3600, '/');

            return response()->json(['status' => 1, 'info' => 'success']);
        } else {
            return view('daidai.login');
        }
    }

    /**
     * 注册
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    function register(Request $request)
    {
        if ($request->method() == 'POST') {
            $username = trim($request->get('username'));
            $password = $request->get('password');

            $result = $this->insertUser($username, $password);
            if (!$result['status']){
                return $result;
            }

            setcookie('daidai_uid', $result['insertId'] ?? 0, time() + 7 * 24 * 3600, '/');
            setcookie('daidai_username', $username, time() + 7 * 24 * 3600, '/');
            setcookie('daidai_pid', 1, time() + 7 * 24 * 3600, '/');

            return response()->json(['status' => 1, 'info' => 'success']);
        } else {
            return view('daidai.register');
        }
    }

    /**
     * 退出
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function out()
    {
        setcookie('daidai_uid', '', time() - 100, '/');
        setcookie('daidai_username', '', time() - 100, '/');
        setcookie('daidai_pid', '', time() - 100, '/');

        return $this->success('退出成功！');
    }

    /**
     * 添加新用户
     * @param Request $request
     * @return array
     */
    function addUser(Request $request)
    {
        if ($request->method() == 'POST'){
            $username = trim($request->get('username'));
            $password = $request->get('password');

            return  $this->insertUser($username, $password);
        }else{
            return view('daidai.addUser');
        }
    }

    function insertUser($username, $password)
    {
        if (!$username || !$password) {
            return ['status' => 0, 'info' => '用户名或密码不能为空！'];
        }

        $user = DB::table('daidai_user')->where('username', $username)->first();
        if ($user->id) {
            return ['status' => 0, 'info' => '用户名已存在！！'];
        }

        $insertId = DB::table('daidai_user')->insertGetId([
            'username' => $username,
            'password' => md5(md5('url' . $password)),
            'status' => 1,
            'pid' => intval($_COOKIE['daidai_uid']),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        if (!$insertId) {
            return ['status' => 0, 'info' => '系统异常，稍后再试！！'];
        }
        return ['status' => 1, 'info' => '操作成功！', 'insertId'=>$insertId];
    }

    /**
     * 用户列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function userList()
    {
        if (!isset($_COOKIE['daidai_uid'])){
            header('location:/');die;
        }
        $userId = $_COOKIE['daidai_uid'] ?? 0;
        $data = DB::table('daidai_user')->select('id','username', 'status','created_at','updated_at')
            ->where('status', 1)->where('pid', $userId)->get();
        return view('daidai.userList', ['m' => 'user', 'data' => $data]);
    }

    /**
     * 删除用户
     * @param Request $request
     */
    function delUser(Request $request)
    {
        $id = intval($request->get('id'));
        $record = DB::table('daidai_user')->where('status', 1)->find($id);
        if (isset($record->id) && $record->id) {
            if ($_COOKIE['daidai_uid'] != $record->pid) {
                return ['status' => 0, 'info' => '该用户不是你创建，无法删除'];
            }
            $updateStatus = DB::table('daidai_user')->where('id', $id)->update(['status' => 0, 'updated_at' => date('Y-m-d H:i:s')]);
            if ($updateStatus !== false) {
                return ['status' => 1, 'info' => '删除成功！'];
            }
        }
        return ['status' => 0, 'info' => '操作失败，请稍后再试！！'];
    }
}