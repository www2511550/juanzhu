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
use App\Service\HaodankuService;
use App\Service\ToolService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DaidaiController extends BaseController
{
    /**
     * 首页
     */
    public function index(Request $request)
    {
        if ($request->method() == 'POST') {

        } else {
            return is_mobile() ? view('daidai.wap.index', ['action' => 'index']) : view('daidai.index');
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
            if (!$pid) {
                return response()->json(['status' => 0, 'info' => '请选择联盟PID']);
            }
            if (0 === strpos($url, 'http')) {
                $url = $this->transferSinaUrl($url);
            }
            $quanInfo = $toolLogic->getQuanUrlByPid($url, $pid, 1);
            if (!$quanInfo) { // 无法获取的使用大淘客接口查询
                $goodsInfo = $toolLogic->getGoodsInfo($url);
                // 通过大淘客接口给他转换pid
                $url = $this->getHighRateById($goodsInfo['num_iid'], $pid);
                if (!$url) {
                    return response()->json(['status' => 0, 'info' => '未找到联盟商品']);
                }
                // 转短链接
                $short = $toolLogic->getShortUrl($url);
                if (!$short['status']) {
                    return response()->json(['status' => 0, 'info' => '网络繁忙，稍后再试！']);
                }
                // $quanInfo变量重新复值
                $quanInfo = [
                    'coupon_short_url' => $short['data']['url'],
                    'zk_final_price' => $goodsInfo['zk_final_price'],
                    'title' => $goodsInfo['title'],
                    'tbk_pwd' => $goodsInfo['tbk_pwd'],
                ];
            }
            $weibo = (new UrlLogic())->getShortUrl($quanInfo['coupon_short_url'], 3);
            $data = (isset($quanInfo['zk_final_price']) ? $quanInfo['zk_final_price'] : '')
                . '【' . (isset($quanInfo['title']) ? $quanInfo['title'] : '') . '】'
                . (isset($weibo['data']['url']) ? $weibo['data']['url'] : '') . ' ，('
                . (isset($quanInfo['tbk_pwd']) ? $quanInfo['tbk_pwd'] : '') . ')。';

            return response()->json(['status' => 1, 'data' => $data]);
        } else {
            // pid配置
            $config = DB::table('daidai_config')->where('status', 1)->get();
            return is_mobile() ? view('daidai.wap.oneLink', ['config' => $config, 'action'=>'oneLink']) : view('daidai.oneLink', ['config' => $config]);
        }
    }

    /**
     *链接批量转换
     */
    public function moreLink(Request $request,  ToolLogic $toolLogic)
    {
        if ($request->method() == 'POST') {
            $str = $request->get('content');
            $pid = $request->get('pid');
            if (!$pid) {
                return response()->json(['status' => 0, 'info' => '请选择联盟PID']);
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
                $strUrl = '';
                // 新浪url转成淘宝url
                $url = $this->transferSinaUrl($v);
                $quanInfo = $toolLogic->getQuanUrlByPid($url, $pid, 1);
                if ($quanInfo) {
                    $strUrl = $quanInfo['coupon_short_url'];
                } else { // 无法获取的使用大淘客接口查询
                    $goodsInfo = $toolLogic->getGoodsInfo($url);
                    // 通过大淘客接口给他转换pid
                    $url = $this->getHighRateById($goodsInfo['num_iid'], $pid);
                    if ($url) {
                        // 转短链接
                        $short = $toolLogic->getShortUrl($url);
                        if ($short['status']) {
                            $strUrl = $short['data']['url'];
                        }
                    }
                }
                if ($strUrl) {
                    $weibo = (new UrlLogic())->getShortUrl($strUrl, 3);
                    $strUrl = isset($weibo['data']['url']) ? $weibo['data']['url'] : '';
                }

                $_tmp[] = $strUrl;
                $str = $replaceOnce($tmp[0] . $v, '', $str);
            }
            $content = join($_tmp, ' ');
            return response()->json(['status' => 1, 'data' => $content]);
        } else {
            // pid配置
            $config = DB::table('daidai_config')->where('status', 1)->get();
            return is_mobile() ? view('daidai.wap.moreLink', ['config'=>$config, 'action'=>'moreLink']) : view('daidai.moreLink', ['config'=>$config]);
        }
    }

    /**
     * 微博跳转淘宝app
     */
    public function weiboToTaobao(Request $request)
    {
        if ($request->method() == 'POST') {

        } else {
            return is_mobile() ? view('daidai.wap.weibo', ['action'=>'weibo']) : view('daidai.weibo');
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
            if (!(strpos($url, 'uland.taobao.com') || strpos($url, 's.click.taobao.com'))){
                return response()->json(['status' => 0, 'info' => '目前只支持s.click.taobao.com和uland.taobao.com域名！']);
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
        if (strpos($url, 'taobao.com') || strpos($url, 'tb.cn')){
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
                if (is_array($url)){
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
            $insert = ['pid'=>$pid, 'name'=>$name];
            $config = DB::table('daidai_config')->where('pid', $pid)->first();
            if ($config){
                $insert['updated_at'] = Carbon::now();
                $status = DB::table('daidai_config')->where('id', $config->id)->update($insert);
            }else{
                $insert['created_at'] = $insert['updated_at'] = Carbon::now();
                $status = DB::table('daidai_config')->insert($insert);
            }
            if (false === $status){
                return response()->json(['status'=>0, 'info'=>'服务器异常，稍后再试！']);
            }
            return response()->json(['status'=>1, 'info'=>'保存成功！']);
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
        $arrConfig = ['312490106'=>'tkmai3', '353600165'=>'tkcb4'];
        $arrPid = explode('_', $pid);
        $request_url = 'http://v2.api.haodanku.com/ratesurl/ratesurl';
        $request_data['apikey'] = 'buybuypignull';
        $request_data['itemid'] = $itemid;
        $request_data['activityid'] = $activityid;
        if (isset($arrConfig[$arrPid[1]]) && $arrConfig[$arrPid[1]]){
            $request_data['pid'] = $pid;
            $request_data['tb_name'] = $arrConfig[$arrPid[1]];
        }else{ // 默认配置
            $request_data['pid'] = 'mm_312490106_356400025_99534050095';
            $request_data['tb_name'] = 'tkmai3';
        }

        $res = http($request_url, $request_data, 'POST');
        $result = json_decode($res, true);
        if (isset($result['data']['item_url'])){
//        if (isset($result['data']['coupon_click_url'])){
//            return $result['data']['coupon_click_url'] ?: $result['data']['item_url'];
            return $result['data']['item_url'];
        }else{
            return '';
        }
    }

}