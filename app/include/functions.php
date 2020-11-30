<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 17/4/27
 * Time: 下午9:54
 * 公用函数
 */

/**
 * 打印函数
 */
function pre($data){
    echo "<pre>".print_r($data, true)."</pre>";
}
function pree($data){
    echo "<pre>".print_r($data, true)."</pre>";die;
}

/**
 * 获取api token
 */
function getApiToken($uid)
{
    return md5(md5($uid . 'juanzhuzhu'));
}

/**
 * 获取用户id
 * @return mixed
 */
function getUserId(){
    return $_COOKIE['uid'];
}
/**
php检测当前浏览器是否为微信浏览器
 */
function is_wx_browser(){
    return strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger') ? 1 : 0;
}
/**
 * @name: is_mobile
 * @description:  判断客户端是否为手机移动设备
 * @param:
 * @return: boolean
 **/
function is_mobile() {
    $useragent=isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    $useragent_commentsblock=preg_match('|\(.*?\)|',$useragent,$matches)>0?$matches[0]:'';
    $mobile_os_list=array('Google Wireless Transcoder','Windows CE','WindowsCE','Symbian','Android','armv6l','armv5','Mobile','CentOS','mowser','AvantGo','Opera Mobi','J2ME/MIDP','Smartphone','Go.Web','Palm','iPAQ');
    $mobile_token_list=array('Profile/MIDP','Configuration/CLDC-','160×160','176×220','240×240','240×320','320×240','UP.Browser','UP.Link','SymbianOS','PalmOS','PocketPC','SonyEricsson','Nokia','BlackBerry','Vodafone','BenQ','Novarra-Vision','Iris','NetFront','HTC_','Xda_','SAMSUNG-SGH','Wapaka','DoCoMo','iPhone','iPod');

    $found_mobile=CheckSubstrs($mobile_os_list,$useragent_commentsblock) ||
        CheckSubstrs($mobile_token_list,$useragent);

    if ($found_mobile ){
        return true;
    }else{
        return false;
    }
}
function CheckSubstrs($substrs,$text){
    foreach($substrs as $substr)
        if(false!==strpos($text,$substr)){
            return true;
        }
    return false;
}
/**
 * 发送HTTP请求方法
 * @param  string $url    请求URL
 * @param  array  $params 请求参数
 * @param  string $method 请求方法GET/POST
 * @return array  $data   响应数据
 */
function http($url, $params, $method = 'GET', $header = array(), $multi = false){
    $opts = array(
        CURLOPT_TIMEOUT        => 60,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_HTTPHEADER     => $header
    );
    /* 根据请求类型设置特定参数 */
    switch(strtoupper($method)){
        case 'GET':
            $opts[CURLOPT_URL] = $url . '?' . http_build_query($params);
            break;
        case 'POST':
            //判断是否传输文件
            $params = $multi ? $params : http_build_query($params);
            $opts[CURLOPT_URL] = $url;
            $opts[CURLOPT_POST] = 1;
            $opts[CURLOPT_POSTFIELDS] = $params;
            break;
        default:
            throw new \Exception('不支持的请求方式！');
    }
    /* 初始化并执行curl请求 */
    $ch = curl_init();
    curl_setopt_array($ch, $opts);
    $data  = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    if($error) throw new \Exception('请求发生错误：' . $error);
    return  $data;
}

/**
 * curl 请求
 * @param $url
 * @param $strPost
 * @param string $method
 * @return mixed
 * @throws Exception
 */
function httpCurl($url, $data, $method = 'POST')
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $info = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) throw new \Exception('请求发生错误：' . $error);

    return json_decode($info, true);
}