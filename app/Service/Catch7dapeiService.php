<?php
/**
 * 采集7dapei.com内容
 * User: chengcong
 * Date: 2018/5/6
 * Time: 下午8:40
 */

namespace App\Service;

use QL\QueryList;

class Catch7dapeiService
{

    public function __construct()
    {
        $this->url = 'http://www.7dapei.com';
    }

    /**
     * 采集首页
     * @return mixed
     */
    public function index()
    {
        $data = [];
        $result = QueryList::Query($this->url, [
            'left' => ['.zuo>ul>li>a', 'href'],
            'zhong' => ['.swiper-slide>a', 'href'],
            'right' => ['.you>ul>li>a', 'href'],
        ])->getData();
        if ($result) {
            foreach ($result as $val) {
                // left
                if ($val['left']) {
                    $arrLeft = $this->getDetail($this->url . '/' . $val['left']);
                    $arrLeft && $data = array_merge($data, $arrLeft);
                }

                // zhong
                if ($val['zhong']) {
                    $arrZhong = $this->getDetail($this->url . '/' . $val['zhong']);
                    $arrZhong && $data = array_merge($data, $arrZhong);
                }

                // right
                if ($val['right']) {
                    $arrRight = $this->getDetail($this->url . '/' . $val['right']);
                    $arrRight && $data = array_merge($data, $arrRight);
                }
            }
        }
        return $data;
    }

    /**
     * 获取详细页数据（包括分页）
     * @param $url
     * @return array
     */
    public function getDetail($url)
    {
        $data = [];
        $arrRule = [
            'title' => ['.content>h1', 'text'],
            'daodu' => ['.daodu', 'text'],
            'img' => ['.photo>img', 'src'],
            'buy' => ['.buy>a', 'href'],
            'intro' => ['.photo>p', 'text'],
            'page' => ['.pageNo>a', 'href'],
        ];
        $result = QueryList::Query($url, $arrRule)->getData();
        if ($result) {
            $lastNum = strrpos($url, '/');
            $pageBaseUrl = substr($url, 0, $lastNum);
            foreach ($result as $val) {
                if ($val['title']) {
                    $data[] = $this->formatDetail($val);
                } else {
                    // 根据页码获取
                    $tmp = QueryList::Query($pageBaseUrl . '/' . $val['page'], $arrRule)->getData();
                    if ($tmp[0]) {
                        $data[] = $this->formatDetail($tmp[0]);
                    }
                }
            }
        }
        return $data;
    }

    /**
     * 格式化详细页数据
     * @param $val
     * @return array
     */
    public function formatDetail($val)
    {
        $arrBuy = $this->getGoodsUrl($val['buy']);
        return [
            'title' => $val['title'],
            'daodu' => $val['daodu'],
            'img' => $this->url . '/' . $val['img'],
            'old_url' => $val['buy'],
            'buy' => $arrBuy['buy'],
            'goods_id' => $arrBuy['goods_id'],
            'intro' => $val['intro'],
        ];
    }

    /**
     * 拆分链接参数
     * @param $url
     * @return array
     */
    public function getGoodsUrl($url)
    {
        $arr = explode('?', $url);
        preg_match('/id=(\d{11,13})/',$arr[1], $arrGid);
        return [
            'buy' => $arr[0] . '?id=' . ($arrGid[1] ?: ''),
            'goods_id' => (int)$arrGid[1]
        ];
    }
}