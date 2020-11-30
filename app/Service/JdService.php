<?php
/**
 * jd-sdk接口
 * http://jos.jd.com/api/detail.htm?apiName=jingdong.service.promotion.content.getcode&id=1877
 * User: chengcong
 * Date: 2018/4/21
 * Time: 下午10:47
 */
namespace App\Service;

require app_path('../vendor/jd-sdk/JdSdk.php');

class JdService
{

    public function __construct()
    {
        $this->appKey = 'A0484F084BED5752F2705260B8B3D1C6';
        $this->appSecret = '03306412541e42b88e52642ffe49373f';
        $this->accessToken = 'a7d7782e-ec50-46dd-9c9c-0a1d4e129bf0'; // refresh_token：f7f8cbe5-b324-4cf0-8d57-c3c51894d6e2
        $this->serverUrl = 'https://api.jd.com/routerjson';
    }

    /**
     * 内容推广获取转链接口
     * http://jos.jd.com/api/detail.htm?apiName=jingdong.service.promotion.content.getcode&id=1877
     */
    public function content()
    {
        $c = new \JdClient();
        $c->appKey = $this->appKey;
        $c->appSecret = $this->appSecret;
        $c->accessToken = $this->accessToken;
        $c->serverUrl = $this->serverUrl;

        $req = new \ServicePromotionContentGetcodeRequest();
        $req->setReleaseType("1");
        $req->setTypeId("8");
        $req->setSortName("inGoodsCount30Days");
        $req->setSort("desc");
        $req->setPageSize('20');
        $req->setPageIndex('1');
        $req->setUnionId('1000016252');
        $req->setSubUnionId("572750081");
        $req->setWebId("572750081");
//        $req->setExt1( "jingdong" );
//        $req->setProtocol( 123 );
        $req->setPositionId('926797376');
        $resp = $c->execute($req, $this->accessToken);
        if ($resp->result) {
            $result = json_decode($resp->result);
            $data = $result->data;
        }

        return $data ?: [];
    }

    /**
     * 京东爆款
     */
    public function hotGoods()
    {
        $c = new \JdClient();
        $c->appKey = $this->appKey;
        $c->appSecret = $this->appSecret;
        $c->accessToken = $this->accessToken;
        $c->serverUrl = $this->serverUrl;

        $req = new \UnionThemeGoodsServiceQueryExplosiveGoodsRequest();

        $req->setFrom(1);
        $req->setPageSize(20);
//        $req->setCid3(123);

        $resp = $c->execute($req, $c->accessToken);
        pree($resp);
    }











    /**
     * 获取accesstoken
     */
    public function getAccessToken()
    {
        $response_type = "code";
        $grant_type = "authorization_code";
        $client_id = $this->c->appKey;
        $client_secret = $this->c->appSecret;
        $redirect_uri = "http://www.juanzhuzhu.com";
        $state = "jdunion";
        $codeurl = 'https://oauth.jd.com/oauth/authorize';
        $tokenurl = "https://oauth.jd.com/oauth/token?";
        $code = $_GET["code"];
        if ($code != "") {
            $fields = [
                "grant_type" => urlencode($grant_type),
                "client_id" => urlencode($client_id),
                "redirect_uri" => urlencode($redirect_uri),
                "code" => urlencode($code),
                "state" => urlencode($state),
                "client_secret" => urlencode($client_secret)
            ];

            $fields_string = "";
            foreach ($fields as $key => $value) {
                $fields_string .= $key . '=' . $value . '&';
            }
            rtrim($fields_string, '&');

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $tokenurl . $fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($ch);
            curl_close($ch);

            echo "Response：<br />" . mb_convert_encoding($result, "UTF-8", "GBK");

        } else {
            header("Location: " . $codeurl . "?response_type=" . $response_type . "&client_id=" . $client_id . "&redirect_uri=" . $redirect_uri . "&state=" . $state);
        }
    }

}