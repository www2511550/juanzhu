<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2017/10/15
 * Time: 下午4:39
 */
namespace App\Service;

class QqService
{

    public function __construct()
    {
        $this->appid = '1106464250';
        $this->appkey = 'JpvQXAI5E1IAhRrw';
    }

    /**
     * 获取qq登陆地址
     * @param $redirect_uri
     */
    public function getQqLoginUrl($redirect_uri, $display = 'mobile')
    {
        return 'https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=' . $this->appid
        . '&redirect_uri=' . $redirect_uri
        . '&state=status&display=' . $display;
    }

    /**
     * 获取qq登陆的access_token
     */
    public function getAccessToken($code, $redirect_uri)
    {
        $access_token = '';
        $baseUrl = 'https://graph.qq.com/oauth2.0/token';

        if ($code) {
            $params = [
                'grant_type' => 'authorization_code',
                'client_id' => $this->appid,
                'client_secret' => $this->appkey,
                'code' => $code,
                'redirect_uri' => $redirect_uri,
            ];
            $info = http($baseUrl, $params);
            $arrInfo = explode('&',$info);
            $arrToken = explode('=', $arrInfo[0]);
            $access_token = $arrToken[1] ?: '';
        }

        return $access_token;
    }

    /**
     * 通过access_token获取openid
     * @param $access_token
     */
    public function getOpenid($access_token)
    {
        $openid = '';
        $baseUrl = 'https://graph.qq.com/oauth2.0/me';

        if ($access_token) {
            $info = http($baseUrl, ['access_token' => $access_token]);
            $strInfo = substr(trim($info), 10, -2);
            $arrInfo = explode(',', trim($strInfo));
            $arrOpen = explode(':', $arrInfo[1]);
            $openid = $arrOpen[1] ? substr($arrOpen[1], 1, -2): '';
        }

        return $openid;
    }

}
