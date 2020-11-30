<?php
/**
 * wechat
 *
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2018/1/9
 * Time: 下午8:24
 */
namespace App\Weixin;

use Storage;

include_once app_path('include/wx/WXBizMsgCrypt.php');

class IndexController
{
    private $encodingAesKey,
        $Secret,  // 管理组
        $token,
        $corpId,
        $wxcpt;
    private $_art_url = "http://bbs.addcn.com/Home/Wxmenu/click.html?work_id=%s&art_id=%d&art_url=%s";

    public function __construct()
    {
        // 企业公众号参数设置
        $this->corpId = "wx22c97cf958fb8726";
        $this->token = "omJNpZEhZeHj1ZxFECKkP48B5VFbk1HP";
        $this->encodingAesKey = "9kE2dDcEQmgn7svbFTAupkA8xqlSoHXLyX9xUcf2cOI";
        $this->Secret = "79615a8e6a810f80e8f205e808e9107e";

//        $this->wxcpt = new \WXBizMsgCrypt($this->token, $this->encodingAesKey, $this->corpId);
        $this->wxcpt = new \WXBizMsgCrypt($this->token, $this->encodingAesKey, $this->corpId);
    }

    /**
     * 判断回调方式
     *
     * @return
     * @author cong.cheng <2016年6月6日 上午10:46:12>
     */
    public function valid()
    {
        if (isset($_GET['echostr'])) {
            echo $_GET['echostr'];die;
            $this->validate();
            die;
        } else if (strtolower($_GET['send']) == 'all') {
            $agentId = !$_GET['aid'] ? 1 : $_GET['aid'];
            // 群发接口
            $this->sendAll($agentId);
            die;
        }
        $this->DecryptUserMsg();

    }

    /**
     * 初次关注绑定身份并存储
     *
     * @return
     * @author cong.cheng <2016年6月17日 上午10:58:39>
     */
    public function initAuthUser($work_id, $agentId)
    {
        if (!$work_id || !$agentId) return false;
        $wxinfoModel = M('wx_info');
        $data['work_id'] = $work_id;
        $data['app_id'] = $agentId;
        $data['status'] = 1;
        $data['addtime'] = time();
        // 获取所有标签
        $wxCateModel = M('wx_category');
        $tmp_data = array();
        $cateData = $wxCateModel->where(array('status' => 1))->select();
        foreach ($cateData as $val) {
            $tmp_data[] = $val['id'];
        }
        $data['tag'] = implode(',', $tmp_data); // 默认所有订阅标签
        // 存储
        $record = $wxinfoModel->where(array('work_id' => $work_id))->find();
        if ($record) {
            $status = $wxinfoModel->where(array('work_id' => $work_id))->save($data);
        } else {
            $status = $wxinfoModel->add($data);
        }
        return $status;
    }

    /**
     * 解密并输出echostr
     *
     * @return
     * @author cong.cheng <2016年6月6日 上午10:47:31>
     */
    public function validate()
    {
        $sVerifyMsgSig = $_GET['msg_signature'];
        $sVerifyTimeStamp = $_GET['timestamp'];
        $sVerifyNonce = $_GET['nonce'];
        $sVerifyEchoStr = $_GET['echostr'];
        // 需要返回的明文
        $sEchoStr = "";
        $errCode = $this->wxcpt->VerifyURL($sVerifyMsgSig, $sVerifyTimeStamp, $sVerifyNonce, $sVerifyEchoStr, $sEchoStr);
        Storage::disk('local')->put('file.txt', implode(',',$_GET));
        if ($errCode == 0) {
            // 验证URL成功，将sEchoStr返回
            echo $sEchoStr;
        } else {
            print("ERR: " . $errCode . "\n\n");
        }
    }

    /**
     * 对用户回复的消息解密
     *
     * @return
     * @author cong.cheng <2016年6月6日 下午3:38:54>
     */
    public function DecryptUserMsg()
    {
        $sReqMsgSig = $_GET['msg_signature'];
        $sReqTimeStamp = $_GET['timestamp'];
        $sReqNonce = $_GET['nonce'];
        // post请求的密文数据
        $sReqData = file_get_contents("php://input");
        /* $sReqData = "<xml><ToUserName><![CDATA[wxeb1891009d678fac]]></ToUserName>
                     <Encrypt><![CDATA[sfGHGELCUsouBO2EO4wRnyfATuvHiM+ZT/eM2IdSkGw7vpzR9cmCcHKucXUPxX+hfFi7h6NpQOzlILdg9HX/0PABAuAcyNmmT3cq2lIBaLjyxZmCkBXk2wiEj67FKIdeQ80cfuIMmw+E3/I+wU6tSIOKwZKTBVrEONR/xC0TOoEMSij01hwi/U51fLsD3s6wJfKYqYdmurVSgIv23BalXpgBlzWrRu3apEcvVaHnvbPtk658QaveVcRUhEUio+2vDW9wyCbn20JjaCUnioSEmvEA/vA+1WMtHIyvFX3lEwmq9xbzvFlouwdybS6ciiPKWcDbtDSSPeDAIb6cirM5hlbv5CWU8Awg9ujB2pyib7zEPeAlV2dnblIMQhyxHyRf1tPhxtkb3/C9dHcVtw8+D9D1OSxX47Gy0N4fC1UlUCI=]]></Encrypt>
                     <AgentID><![CDATA[1]]></AgentID>
                    </xml>";
        */
        $sMsg = "";  // 解析之后的明文
        $errCode = $this->wxcpt->DecryptMsg($sReqMsgSig, $sReqTimeStamp, $sReqNonce, $sReqData, $sMsg);
        if ($errCode == 0) {
            // 获取xml数据
            $xmlData = $this->getXmlData($sMsg);
            // 菜单
            if ($xmlData['msgType'] && $xmlData['event'] == 'view') exit;
            // 初次关注
            if ($xmlData['msgType'] && $xmlData['event'] == 'subscribe') {
                $status = $this->initAuthUser($xmlData['fromUser'], $xmlData['agentId']);
                $data['other'] = true;
                $data['fromUser'] = $xmlData['fromUser'];
                $data['agentId'] = $xmlData['agentId'];
                $data['msg'] = !$status ? '绑定失败，请联系管理员！' : '欢迎关注数睿科技企业微信号，知识分享，每天改变一点点，有用，有料，有货。赶快去单击链接http://t.cn/R5knS9s，查看分享教程吧^-^';
                $this->receiveUser($data);
                die;
            }
            // 自动回复
            $this->receiveUser($xmlData);
            // ...
            // ...
        } else {
            print("ERR: " . $errCode . "\n\n");
            //exit(-1);
        }
    }

    /**
     * 获取xml格式数据
     *
     * @return
     * @author cong.cheng <2016年6月17日 下午2:54:35>
     */
    public function getXmlData($xmlData)
    {
        $data = array();
        if (!$xmlData) return $data;
        // 解密成功，sMsg即为xml格式的明文
        // TODO: 对明文的处理
        // For example:
        $xml = new \DOMDocument();
        $xml->loadXML($xmlData);
        if ($xml->getElementsByTagName('Content')->item(0)->nodeValue) { // 手动发送
            $data['content'] = $xml->getElementsByTagName('Content')->item(0)->nodeValue;
        } else { // 来自分享
            $data['title'] = $xml->getElementsByTagName('Title')->item(0)->nodeValue;
            $data['url'] = $xml->getElementsByTagName('Url')->item(0)->nodeValue;
            $data['description'] = $xml->getElementsByTagName('Description')->item(0)->nodeValue;
            $data['picUrl'] = $xml->getElementsByTagName('PicUrl')->item(0)->nodeValue;
        }
        $data['msgType'] = $xml->getElementsByTagName('MsgType')->item(0)->nodeValue;
        $data['msgType'] && $data['event'] = $xml->getElementsByTagName('Event')->item(0)->nodeValue;
        $data['agentId'] = $xml->getElementsByTagName('AgentID')->item(0)->nodeValue;
        $data['fromUser'] = $xml->getElementsByTagName('FromUserName')->item(0)->nodeValue;
        return $data;
    }

    /**
     * 企业回复用户消息的加密
     *
     * @return
     * @author cong.cheng <2016年6月6日 下午3:51:00>
     */
    public function receiveUser($data)
    {
        // $sReqTimeStamp = HttpUtils.ParseUrl("timestamp");
        $sReqTimeStamp = $_GET['timestamp'];
        // $sReqNonce = HttpUtils.ParseUrl("nonce");
        $sReqNonce = $_GET['nonce'];
        $toUser = $data['fromUser'];
        $agentId = $data['agentId'];
        // 验证链接是否正确
        $res = $this->validateUrl($data);
        // 需要发送的明文
        $msg = !$data['other'] ? $res['msg'] : $data['msg'];
        $sRespData = "<xml>
                      <ToUserName><![CDATA[" . $toUser . "]]></ToUserName>
                      <FromUserName><![CDATA[" . $this->corpId . "]]></FromUserName>
                      <CreateTime>" . time() . "</CreateTime>
                      <MsgType><![CDATA[text]]></MsgType>
                      <Content><![CDATA[" . $msg . "]]></Content>
                      <MsgId>1234567890123456</MsgId>
                      <AgentID>" . $agentId . "</AgentID>
                      </xml>";
        $sEncryptMsg = ""; //xml格式的密文
        $errCode = $this->wxcpt->EncryptMsg($sRespData, $sReqTimeStamp, $sReqNonce, $sEncryptMsg);
        if ($errCode == 0) {
            // TODO:
            // 加密成功，企业需要将加密之后的sEncryptMsg返回
            // HttpUtils.SetResponce($sEncryptMsg);  //回复加密之后的密文
            echo $sEncryptMsg;
            die;
        } else {
            print("ERR: " . $errCode . "\n\n");
            // exit(-1);
        }
    }

    /**
     * 群发消息
     *
     * @return
     * @author cong.cheng <2016年6月7日 下午2:53:55>
     */
    public function sendAll($agentId)
    {
        // 获取access_token
        $access_token = $this->getAccessToken();
        //  发送消息
        $postUrl = "https://qyapi.weixin.qq.com/cgi-bin/message/send?access_token=" . $access_token;
        $wxArticleModel = M('wx_article');
        $wxinfoModle = M('wx_info');
        // 按标签群发推送消息
        $userdata = $wxinfoModle->where(array('status' => 1, 'agentId' => $agentId))->select();
        $tags = $users = array();
        foreach ($userdata as $key => $val) {
            !in_array($tags, $val['tag']) && $tags[] = $val['tag'];
            $users[$val['tag']][$key] = $val['work_id'];
        }
        // 循环群发
        $aids = array();
        foreach ($users as $k => $val) {
            sort($val);
            $param = array('agentId' => $agentId, 'wxArticleModel' => $wxArticleModel, 'people' => $val, 'tag' => $k, 'limit' => 8, 'work_id' => $val['work_id']);
            $postCon = $this->getPostCon($param);
            if (!$postCon['aids']) continue;
            $curlPost = $postCon['curlPost'];
            $aids = array_merge($aids, $postCon['aids']);
            $ch = curl_init();//初始化curl
            curl_setopt($ch, CURLOPT_URL, $postUrl);//抓取指定网页
            curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
            curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
            curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
            $data = curl_exec($ch);//运行curl
            curl_close($ch);
            $data = json_decode($data, true);
        }
        if ($data['errmsg'] == 'ok') {
            // 去掉重复的
            $aids = array_unique($aids);
            // 更新文章状态为已发送
            $status = $wxArticleModel->where(array('id' => array('IN', $aids)))->save(array('status' => 3));
            if (!$status) echo "update fail!";
        }
        echo $data['errmsg'];
    }

    /**
     * 验证文章链接并绑定
     * @param string $url
     * @return string
     * @author cong.cheng <2016年6月1日 上午11:07:51>
     */
    private function validateUrl($data)
    {
        $fromUser = $data['fromUser'];
        $res = array('status' => 0, 'msg' => '', 'data' => '');
        if (strpos($data['url'], 'weixin')) { // 来自微信的文章去掉srcid，使苹果端可以返回
            $data['url'] = preg_replace('/&srcid=.*/', '', $data['url']);
        }
        if (!isset($data['content'])) {  // 来自微信分享
            $article = @file_get_contents($data['url']);
            if (!$article) {
                $res['msg'] = "链接无法访问！";
                return $res;
            }
            $img = $this->getImgUrl($article);
            $wxArticleModel = M('wx_article');
            $record = $wxArticleModel->where(array('status' => 1, 'a_href' => $data['url']))->find();
            if ($record) {
                $res['msg'] = "此文章已被分享过！";
                return $res;
            }
            // 统计类别
            $cateModel = M('wx_category');
            $cate_data['c_name'] = '其他';
            $cate_data['work_id'] = $data['fromUser'];
            $cate_data['status'] = 1;
            $cate_data['addtime'] = time();
            $record = $cateModel->where(array('status' => 1, 'c_name' => '其他'))->find();
            !$record && $cateModel->add($cate_data);
            // 记录到数据库
            $insert_data['work_id'] = $data['fromUser'];
            $insert_data['a_href'] = $data['url'];
            $insert_data['title'] = $data['title'];
            $insert_data['cate_name'] = '其他';
            $insert_data['img_url'] = $img[1];
            $insert_data['status'] = 1;
            $insert_data['addtime'] = time();
            $status = $wxArticleModel->add($insert_data);
            if (!$status) {
                $res['msg'] = "系统错误，稍后再试！";
                return $res;
            }
            $res['status'] = 1;
            $res['data'] = array('title' => $data['title'], 'img' => $img[1], 'url' => $data['url']);
            $res['msg'] = "分享成功，感谢您的分享，可前往<a href='bbs.addcn.com/Home/Wxmenu/myArticle'>我的文章</a>中添加标签！";
            return $res;

        }// 来自手动发送链接
        $urlData = $data['content'];
        if (!$urlData) {
            $res['msg'] = "分享格式如:www.baidu.com 文章类别 或者直接在文章右上角点击分享到企业号！";
            return $res;
        }
        if (!$fromUser) {
            $res['msg'] = '系统出错了，请联稍后再试！';
            return $res;
        }
        $urls = explode(' ', $urlData);
        $url = $urls[0];
        if (!$urls[1]) {
            $res['msg'] = '链接和文章类别以空格区分！正确实例：www.baidu.com 小说';
            return $res;
        }
        $status = preg_match('/(http|https)/', $url);
        !$status && $url = 'http://' . $url;
        $article = @file_get_contents($url);
        if (!$article) {
            $res['msg'] = "链接无法访问！";
            return $res;
        }
        preg_match('/<title>(.*)<\/title>/', $article, $title);
//         preg_match('/<img.*src=\"(.*[jpg|png|gif|jpeg])\".*>/', $article, $img);
        $img = $this->getImgUrl($article);

        // 统计类别
        $cateModel = M('wx_category');
        $cate_data['c_name'] = $urls[1];
        $cate_data['work_id'] = $fromUser;
        $cate_data['status'] = 1;
        $cate_data['addtime'] = time();
        $record = $cateModel->where(array('status' => 1, 'c_name' => $urls[1]))->find();
        !$record && $cateModel->add($cate_data);
        // 文章
        $wxArticleModel = M('wx_article');
        $record = $wxArticleModel->where(array('status' => 1, 'a_href' => $data['url']))->find();
        if ($record) {
            $res['msg'] = "此文章已被分享过！";
            return $res;
        }
        // 记录到数据库
        $insert_data['work_id'] = $fromUser;
        $insert_data['a_href'] = $url;
        $insert_data['title'] = $title[1];
        $insert_data['cate_name'] = $urls[1];
        $insert_data['img_url'] = $img[1];
        $insert_data['status'] = 1;
        $insert_data['addtime'] = time();
        $status = $wxArticleModel->add($insert_data);
        $res['status'] = 1;
        $res['data'] = array('title' => $title[1], 'img' => $img[1], 'url' => $url);
        $res['msg'] = "分享成功，感谢您的分享！";
        return $res;
    }

    /**
     * 获取封面图片
     *
     * @return
     * @author cong.cheng <2016年6月17日 下午7:47:04>
     */
    public function getImgUrl($article)
    {
        // 先匹配分享图片
        preg_match('/msg_cdn_url\s?=\s?\"(.*)\"\;/', $article, $img);
        $imgInfo = @getimagesize($img[1]);
        if (!$imgInfo) {
            preg_match('/(http[s]{0,1}:\/\/mmbiz.qpic.cn\/mmbiz\/\w+\/[0-9]{1})/', $article, $img);
            // 获取最后一个h1标签后面的图片，作为封面（匹配规则符合：http://huoding.com/2016/10/26/548）
            if (!$img[1]) {
                $pos = strrpos($article, '</h1>');
                if ($pos !== FALSE) {
                    $tmp_content = substr($article, $pos + 5);
                    preg_match('/<img.*src=\"(.*[jpg|png|gif|jpeg])\".*>/', $tmp_content, $img);
                }
            }
        }
        if (isset($img[1]) && $img[1]) { // 保存图片
            $file_path = 'Uploads/Picture/wx';
            $file_name = 10000 * microtime(true) . '.jpg';
            $save_path = $file_path . '/' . $file_name;
            !is_dir($save_path) && mkdir($file_path, 0777, true);
            $img_con = @file_get_contents($img[1]);
            file_put_contents($save_path, $img_con);
            // 图片类
            $image = new \Think\Image();
            $image->open($save_path);
            // 居中裁剪
            $save_path = $file_path . '/' . (10000 * microtime(true)) . '_380x380.jpg';
            $image->thumb(380, 380, \Think\Image::IMAGE_THUMB_CENTER)->save($save_path);
            $img[1] = $save_path;
        }
        return $img;
    }

    /**
     * 获取access_token
     *
     * @return
     * @author cong.cheng <2016年6月7日 下午3:57:09>
     */
    public function getAccessToken()
    {
        // 获取ACCESS_TOKEN
        $tokenUrl = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=" . $this->corpId . "&corpsecret=" . $this->Secret;
        $tokenData = @file_get_contents($tokenUrl);
        $toke = json_decode($tokenData, true);
        return $toke['access_token'];
    }

    /**
     * 根据code获取成员信息
     *
     * @return
     * @author cong.cheng <2016年6月7日 下午4:00:31>
     */
    public function getUserInfo($code = '')
    {
        if (!$code) return array();
        $access_token = $this->getAccessToken();
        $url = "https://qyapi.weixin.qq.com/cgi-bin/user/getuserinfo?access_token=" . $access_token . "&code=" . $code;
        $userInfo = @file_get_contents($url);
        return json_decode($userInfo, true);
    }

    /**
     * 验证成功后自动关注
     * @param number $uid
     * @return
     * @author cong.cheng <2016年6月7日 下午4:34:20>
     */
    public function authSuccess($userId = 0, $data = array('status' => 0, 'msg' => '关注失败！'))
    {
        if ($data['status'] == 0) {
            echo $data['msg'];
            die;
        }
        if (!$userId) $this->error('参数异常，请联系管理员！');
        $access_token = $this->getAccessToken();
        $url = "https://qyapi.weixin.qq.com/cgi-bin/user/authsucc?access_token=" . $access_token . "&userid=" . $userId;
        $res = file_get_contents($url);
        $result = json_decode($res, true);
        if ($result['errcode'] == 0) {
            echo "关注成功！";
            die;
        }
        echo "关注失败，请联系管理员！";
        die;
    }

    /**
     * 绑定工号
     *
     * @return
     * @author cong.cheng <2016年6月17日 上午11:42:01>
     */
    public function bindInfo($userInfo = '')
    {
        if (!$userInfo) return false;
        $wxInfoModel = M('wx_info');
        $map['work_id'] = $userInfo['UserId'];
        $map['status'] = 1;
        $record = $wxInfoModel->where($map)->find();
        if ($record) return true;
        // 初次绑定存储
        $insert_data['work_id'] = $userInfo['UserId'];
        $insert_data['status'] = 1;
        $insert_data['open_id'] = $this->openidOrUserid();
        $insert_data['addtime'] = time();
        $status = $wxInfoModel->add($insert_data);
        if (!$status) {
            $data = array('status' => 0, 'msg' => "微信和OA账号绑定失败，请联系OA系统管理员！");
        } else {
            $data = array('status' => 1, 'msg' => "微信和OA账号绑定成功，可以发布文章了！");
        }
        $this->authSuccess($userInfo['UserId'], $data);
        die;
    }

    /**
     * openid和userid相互转换
     *
     * @return
     * @author cong.cheng <2016年6月17日 上午11:48:21>
     */
    public function openidOrUserid()
    {
        return 'aaaaa';
    }

    /**
     * 获取群发消息的内容格式
     *
     * @return
     * @author cong.cheng <2016年6月22日 下午5:26:28>
     */
    public function getPostCon($data)
    {
        $cateModel = M('wx_category');
        $touser = !is_array($data['people']) ? $data['people'] : implode('|', $data['people']);
        $curlPost = '{
                       "touser": "' . $touser . '",
                       "toparty": " PartyID1 | PartyID2 ",
                       "totag": " TagID1 | TagID2 ",
                       "msgtype": "news",
                       "agentid": ' . $data['agentId'] . ',
                       "news": {
                           "articles":[';
        // 文章分类
        $tag = explode(',', $data['tag']);
        $cate = $cateModel->field('c_name')->where(array('id' => array('IN', $tag)))->select();
        $cateName = array();
        $map['status'] = 1;
        foreach ($cate as $val) {
            $cateName[] = $val['c_name'];
        }
        $cateName && $map['cate_name'] = array('IN', $cateName);
        $limit = !$data['limit'] ? 5 : $data['limit'];
        // 推送前一天
        $map['addtime'] = array('between', array(strtotime(date('Y-m-d') . '-1 day'), strtotime(date('Y-m-d'))));
        $articles = $data['wxArticleModel']->where($map)->order(' addtime asc')->limit($limit)->select();
        // 如果第一张是无图，放到最后
        foreach ($articles as $key => $val) {
            if ($val['img_url']) break;
            array_push($articles, $val);
            unset($articles[$key]);
        }
        $aids = array();
        if ($articles) {
            $userModel = M('user');
            foreach ($articles as $val) {
                $user = $userModel->field('username')->where(array('work_id' => $val['work_id']))->find();
                $picurl = !$val['img_url'] ? "https://www.591.com.tw/images/index/house/nophoto97x70.gif" : "http://bbs.addcn.com/" . $val['img_url'];
                // 记录点击数据
                $val['a_href'] = sprintf($this->_art_url, $data['work_id'], $val['id'], urlencode($val['a_href']));
                $val['title'] = msubstr($val['title'], 0, 30, 'utf-8', false);
                $curlPost .= '{
                                   "title": "' . $val['title'] . ' (' . $user['username'] . ')",
                                   "description": "' . $val['cate_name'] . '",
                                   "url": "' . $val['a_href'] . '",
                                   "picurl": "' . $picurl . '"
                               },';
                $aids[] = $val['id'];
            }
            $curlPost .= '  ] } }';
        }
        return array('curlPost' => $curlPost, 'aids' => $aids);
    }
}

?>