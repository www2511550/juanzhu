<?php
/**
 * 穿衣搭配逻辑层处理
 * User: chengcong
 * Date: 2018/8/15
 * Time: 下午10:48
 */
namespace App\Logic;

use Cache;

class DapeiLogic
{

    /**
     * 详情页内容
     * @param $content
     * @return array
     */
    public function getContent($dapei)
    {
        $content = $dapei->content;
        $arrContent = json_decode(trim($content));
        if (!$arrContent){
            $content = trim(substr($content, 2, -2));
            $arrContent = explode('", "', $content);
        }

        if ($dapei->cate_name == '7dapei'){
            $arrData = array_chunk($arrContent, 3);
            foreach ($arrData as $arr){
                $arrUrl = explode('&', $arr[2]);
                $goods_id = 0;
                foreach ($arrUrl as $v){
                    if (strpos($v, 'id=') !== false){
                        $goods_id = substr($v, 3);
                        break;
                    }
                }
                $tmp['dapei'][] = [
                    'intro' => $arr[0],
                    'cover' => $arr[1],
                    'href' => $arr[2],
                    'goods_id' => $goods_id
                ];
            }
            $arrContent = $tmp;
        }else{
            foreach ($arrContent as $key => $val) {
                $val = (array)$val;
                if (!$val['quan_id'] && !$val['to_url']) { // 检测券id是否存在
//                if (!$val['shop_type']) {
//                    $result = Cache::remember('detail:'.$val['goods_id'], 30*24*60,function () use($val){
//                        return $this->searchByHaodanku($val['intro']);
//                    });
//                    $val['shop_type'] = $result['shoptype'] ?: 'b';
//                }
                    $val['to_url'] = ($val['shop_type'] == 'b' ? 'https://detail.tmall.com/item.htm?id=' : 'https://item.taobao.com/item.htm?id=') . $val['goods_id'];
                }
                $arrContent[$key] = $val;
            }
        }
        
        return $arrContent;
    }

    public function searchByHaodanku($word)
    {
        $result = http('http://v2.api.haodanku.com/supersearch', [
            'apikey' => 'juanzhuzhu',
            'keyword' => urlencode(urlencode($word)),
        ]);
        return isset($result['data']) ? $result['data'] : [];
    }
}