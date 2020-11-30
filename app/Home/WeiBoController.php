<?php
/**
 *
 * Created by cc.
 * Date: 2019/4/23
 * Time: 12:19
 */

namespace App\Home;

use App\Logic\TaobaoLogic;
use App\Service\WeiboService;
use Illuminate\Http\Request;

require app_path('../vendor/weibo-sdk/saetv2.ex.class.php');

class WeiBoController extends BaseController
{
    public function __construct()
    {
        define("WB_AKEY", '2689312362');
        define("WB_SKEY", 'd6cd7be53231308204df644aa52220e2');
        define("WB_CALLBACK_URL", 'http://juanzhuzhu.com/wb/callback');
    }

    public function index()
    {
        $o = new \SaeTOAuthV2(WB_AKEY, WB_SKEY);
        $code_url = $o->getAuthorizeURL(WB_CALLBACK_URL);

        return view('dapei.wbindex', compact('code_url'));
    }

    public function callback()
    {
        $o = new \SaeTOAuthV2(WB_AKEY, WB_SKEY);

        if (isset($_REQUEST['code'])) {
            $keys = array();
            $keys['code'] = $_REQUEST['code'];
            $keys['redirect_uri'] = WB_CALLBACK_URL;
            try {
                $token = $o->getAccessToken('code', $keys);
            } catch (\OAuthException $e) {
            }
        }
        if (isset($token) && $token) {
            $_SESSION['token'] = $token;
            setcookie('weibojs_' . $o->client_id, http_build_query($token));
            header('location:/wb/lists');
//            echo '授权完成,<a href="/wb/lists">进入你的微博列表页面</a><br />';
        } else {
            echo '授权失败。';
        }
    }

    public function lists()
    {
        $c = new \SaeTClientV2(WB_AKEY, WB_SKEY, $_SESSION['token']['access_token']);

        echo WB_AKEY.'----'.WB_SKEY.'---'.$_SESSION['token']['access_token'].PHP_EOL;


        if (isset($_REQUEST['text'])) {
            // 注意至少要带上一个链接。
            echo $_REQUEST['text'].PHP_EOL;
            $ret = $c->share($_REQUEST['text'].'http://2dapei.com.cn');    //发送微博
            if (isset($ret['error_code']) && $ret['error_code'] > 0) {
                echo "<p>发送失败，错误：{$ret['error_code']}:{$ret['error']}</p>";
            } else {
                echo "<p>发送成功</p>";
            }
        } else {
            $ms = $c->home_timeline(); // done
            $uid_get = $c->get_uid();
            $uid = $uid_get['uid'];
            $user_message = $c->show_user_by_id($uid);//根据ID获取用户等基本信息

            return view('dapei.wblists', compact('user_message', 'ms'));
        }
    }

    /**
     * 微博登陆
     */
    public function login(Request $request)
    {
        $params = [
            'username' => $request->get('username'),
            'pwd' => $request->get('password'),
        ];
        $result = json_decode(http('http://tk.juanzhuzhu.com/wb/login', $params, 'POST'), true);
        if ($result['status'] == 0) {
            return $this->error($result['info']);
        }
        // 设置cookie
        $_SESSION['wb_cookie'] = $result['data'];
        return $this->success('授权成功！');
    }


    /**
     * 上传图片并发布一条微博
     */
    public function picText(Request $request)
    {
        $text = $request->get('content');
        $imgs = $request->get('imgs');
        $cookie = $_SESSION['wb_cookie'];
        $comment = $request->get('comment', '哈哈哈');

        if (!$cookie){
            return response()->json(['status'=>0, 'info'=>'微博未授权，请授权后再使用']);
        }
        if (!trim($text)){
            return response()->json(['status'=>0, 'info'=>'微博内容不允许为空']);
        }
        if (mb_strlen($text) > 140){
            return response()->json(['status'=>0, 'info'=>'微博内容不允许超过140个字符']);
        }

        $weiboService = new WeiboService();
        // 图片上传
        $arrPid = [];
        if ($imgs){
            $arrPid[] = $weiboService->uploadpic($imgs, $cookie);
        }

        // 发布
        $data = $weiboService->publish($text, $cookie, $arrPid, $comment);
        return response()->json($data);

    }


    /**
     * 评论微博
     */
    public function commit()
    {

    }


    /**
     * 获取淘宝商品库
     */
    public function getTbImgs(Request $request, TaobaoLogic $taobaoLogic)
    {
        $goodsId = (int)$request->get('goods_id');
        $isDetail = (int)$request->get('is_detail', 0);

        $data = $taobaoLogic->getGoodsImages($goodsId, $isDetail, '_300x300.jpg');
        if (count($data) > 0) {
            return response()->json(['status' => 1, 'data' => $data]);
        }
        return response()->json(['status' => 0, 'info' => '图片不存在，请检查商品id是否正确']);
    }

}