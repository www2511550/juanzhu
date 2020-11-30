<?php
/**
 * 百度sdk
 * http://ai.baidu.com/docs#/ImageClassify-PHP-SDK/top
 * User: chengcong
 * Date: 2018/4/22
 * Time: 下午1:49
 */
namespace App\Service;

require app_path('../vendor/baidu-sdk/AipImageClassify.php');
const APP_ID = '11138306';
const API_KEY = 'cVPTmZTSiHocmZeIPLtw9Mjc';
const SECRET_KEY = 'ZiIVl7IL2O06Ij2VU5Qx7omAwL8sA366';

class BaiduService
{

    public function __construct($imgUrl)
    {
        $this->client = $client = new \AipImageClassify(APP_ID, API_KEY, SECRET_KEY);
        $this->imgContent = file_get_contents($imgUrl);

    }

    public function checkImg()
    {
        return $this->imgContent ? 1 : 0;
    }

    /**
     * 通用物体识别
     * @return array
     */
    public function commom($type = '')
    {
        $arrType = ['food', 'car', 'logo', 'animal', 'plan', 'main'];
        if (in_array($type, $arrType)){
            $result = $this->$type();
        }else{
            // 调用通用物体识别
            $result = $this->client->advancedGeneral($this->imgContent);
        }

        if ($result['result'][0]){
            $data = [
                'score' => $result['result'][0]['score'],
                'name' => $result['result'][0]['name'] ?: $result['result'][0]['keyword'],
                'tag' => $result['result'][0]['root'], // 标签
            ];
        }

        return $data ?: [];
    }

    /**
     * 菜品识别
     * @return array
     */
    public function food()
    {
        // 调用菜品识别
        $this->client->dishDetect($this->imgContent);

        // 如果有可选参数
        $options = array();
        $options["top_num"] = 3;

        // 带参数调用菜品识别
        return $this->client->dishDetect($this->imgContent, $options);
    }

    /**
     * 车辆识别
     * @return array
     */
    public function car()
    {
        // 调用车辆识别
        $this->client->carDetect($this->imgContent);

        // 如果有可选参数
        $options = array();
        $options["top_num"] = 3;

        // 带参数调用车辆识别
        return $this->client->carDetect($this->imgContent, $options);
    }

    /**
     * 商标logo识别
     * @return array
     */
    public function logo()
    {
        // 调用logo商标识别
        $this->client->logoSearch($this->imgContent);

        // 如果有可选参数
        $options = array();
        $options["custom_lib"] = "true";

        // 带参数调用logo商标识别
        return $this->client->logoSearch($this->imgContent, $options);
    }

    /**
     * 动物识别
     * @return array
     */
    public function animal()
    {
        // 调用动物识别
        $this->client->animalDetect($this->imgContent);

        // 如果有可选参数
        $options = array();
        $options["top_num"] = 3;

        // 带参数调用动物识别
        return $this->client->animalDetect($this->imgContent, $options);
    }

    /**
     * 植物识别
     * @return array
     */
    public function plan()
    {
        // 调用植物识别
        return $this->client->plantDetect($this->imgContent);
    }

    /**
     * 图像主体检测
     * @return array
     */
    public function main()
    {
        // 调用图像主体检测
        $this->client->objectDetect($this->imgContent);

        // 如果有可选参数
        $options = array();
        $options["with_face"] = 0;

        // 带参数调用图像主体检测
        return $this->client->objectDetect($this->imgContent, $options);
    }


    public function goods()
    {
        require app_path('../vendor/baidu-sdk/AipImageSearch.php');
        $client = new \AipImageSearch('11139190', 'bQBzMDwdwjslldFGVQRAlVkz', 'wXmX6Ied0dyGhU609tnQliUtmnhXC1Sg');

        $image = file_get_contents('avatar_4.jpg');

        // 如果有可选参数
        $options = array();
//        $options["class_id1"] = 1;
//        $options["class_id2"] = 1;
//        $options["pn"] = "100";
//        $options["rn"] = "250";

        // 带参数调用商品检索—检索
        $data = $client->productSearch($image, $options);

        pree($data);
    }
}