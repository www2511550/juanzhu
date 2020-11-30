<?php
/**
 * 97866.com 商品管理
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2018/4/11
 * Time: 下午10:06
 */
namespace App\Logic;

use Cache;

class GoodsLogic
{
    public function __construct()
    {
        $this->appid = 'jam8jjjlp1nga8sswb';
        $this->secret = 'zuw8t4kejleeupygfe4qqnecltinkab3';
        $this->access_token = Cache::remember('accessToken1', 100, function () {
            return $this->getAccessToken();
        });
    }

    /**
     * accesstoken
     */
    public function getAccessToken()
    {
        $result = http(
            'http://wx330ab01f7ec591c2.97866.com/api/mag.token.json',
            ['appid' => $this->appid, 'secret' => $this->secret]
        );
        $arr = json_decode($result, true);
        return $arr['access_token'] ?: '';

    }


    /**
     * 自动批量从选品库添加
     *
     */
    public function autoAddByTbkSelect()
    {
        $taobaoLogic = new TaobaoLogic();
        // 选品库id
        $arrId = ['5'=>'16907182', '9.9'=>'16907187'];

        $request_addGoods = 'http://wx330ab01f7ec591c2.97866.com/api/mag.admin.product.create.json?access_token=' . $this->access_token;
        foreach ($arrId as $selectId){
            $tbData = $taobaoLogic->selectGoods(2, 100, $selectId);
            if ($tbData){
                foreach ($tbData as $val){
                    $info = $taobaoLogic->getGoodsImages($val['gid'], 1);
                    $info['start_time'] = $val['start_time'];
                    $info['end_time'] = $val['end_time'];
                    $goods = $this->formatTbkGoods($info);
                    http(
                        $request_addGoods,
                        $goods,
                        'POST'
                    );
                }
            }
        }

    }

    /**
     * 自动批量添加
     */
    public function autoAddGoods()
    {
        // 批量获取商品
        Cache::forget('11');
        $arrResult = Cache::remember('11', 60, function () {
            $request_url = 'http://v2.api.haodanku.com/itemlist/apikey/juanzhuzhu/nav/4/cid/0/back/10/min_id/1/sort/4';
            $result = http($request_url, []);
            return json_decode($result, true);
        });

        $request_addGoods = 'http://wx330ab01f7ec591c2.97866.com/api/mag.admin.product.create.json?access_token=' . $this->access_token;
        foreach ($arrResult['data'] as $val) {
            $goods_url = 'http://v2.api.haodanku.com/item_detail/apikey/juanzhuzhu/itemid/' . $val['itemid'];
            $goods = http($goods_url, []);
            $arr = json_decode($goods, true);
            $data = $this->formatGoods($arr['data']);
            http(
                $request_addGoods,
                $data,
                'POST'
            );
        }
    }

    /**
     * 格式化商品数据
     * @param $goods
     * @return array
     */
    public function formatGoods($goods)
    {
        return [
            'id' => '53',
            'status' => 'publish',
            'title' => $goods['itemtitle'],
            'content' => $this->getContent($goods),
            'excerpt' => $goods['itemshorttitle'],
            'images' => [
                $goods['itempic'] . '_400x400.jpg',
                'http://img.haodanku.com/' . $goods['itempic_copy'],
            ],
            'video' => $goods['videoid'] ? 'http://cloud.video.taobao.com/play/u/1/p/1/e/6/t/1/'.$goods['videoid'].'.mp4' : '',

            'miaosha_enable' => '1',
            'miaosha_price' => $goods['itemendprice'],
            'miaosha_start_time' => date('Y-m-d H:i:s'),
            'miaosha_end_time' => date('Y-m-d H:i:s', $goods['couponendtime']),

            'groupon_enable' => '1',
            'groupon_price' => $goods['itemendprice'],
            'groupon_member_limit' => '2',
            'groupon_time_limit' => '1000',

            'skus' => [
                'product_no' => '',
                'original_price' => $goods['itemprice'],
                'price' => round($goods['itemendprice']*1.2,1),
                'discount' => round($goods['itemendprice'] / $goods['itemprice'], 2),
                'postage' => '0',
                'stock' => $goods['itemsale'],
                'sales' => '0',
                'manual_sales' => $goods['itemsale'],
                'properties' => [
                    'items' => [
                        [
                            'name' => 's',
                            'image' => $goods['itempic'],
                        ],
                        [
                            'name' => 'c',
                            'image' => $goods['itempic'],
                        ]
                    ]
                ]
            ],
        ];
    }

    /**
     *
     * @param $goods
     * @return array
     */
    public function formatTbkGoods($goods)
    {
        // 图片集合
        $arrImgs[] = $goods['pict_url'] . '_400x400.jpg';
        foreach ((array)$goods['small_images']->string as $img){
            $arrImgs[] = $img . '_400x400.jpg';
        }

        return [
            'id' => '53',
            'status' => 'publish',
            'title' => $goods['title'],
            'content' => $this->getTbkContent($goods),
            'excerpt' => '',
            'images' => $arrImgs,
            'video' => '',

            'miaosha_enable' => '1',
            'miaosha_price' => $goods['zk_final_price'],
            'miaosha_start_time' => date('Y-m-d H:i:s'),
            'miaosha_end_time' => $goods['end_time'],

            'groupon_enable' => '1',
            'groupon_price' => $goods['zk_final_price'],
            'groupon_member_limit' => '2',
            'groupon_time_limit' => '1000',

            'skus' => [
                'product_no' => '',
                'original_price' => $goods['reserve_price'],
                'price' => round($goods['zk_final_price']*1.3,1),
                'discount' => round($goods['zk_final_price'] / $goods['reserve_price'], 2),
                'postage' => '0',
                'stock' => $goods['volume'],
                'sales' => '0',
                'manual_sales' => $goods['volume'],
                'properties' => [
                    'items' => [
                        [
                            'name' => 's',
                            'image' => $goods['itempic'],
                        ],
                        [
                            'name' => 'c',
                            'image' => $goods['itempic'],
                        ]
                    ]
                ]
            ],
        ];
    }

    public function getTbkContent($goods)
    {
        $str = '<p style="text-align: center;padding-top: 15px;padding-bottom:25px;">' . $goods['title'] . '</p>
        <img class="alignnone size-full wp-image-419" src="' . $goods['pict_url'] . '_400x400.jpg" alt="' . $goods['title'] . '" width="790" height="970" />';
        foreach ((array)$goods['small_images']->string as $img) {
            $str .= '<img class="alignnone size-full wp-image-419" src="' . $img . '_400x400.jpg" alt="' . $goods['title'] . '" width="790" height="970" />';
        }
        return $str;
    }

    public function getContent($goods)
    {
        $str = '<p style="text-align: center;padding-top: 15px;padding-bottom:25px;">' . $goods['itemdesc'] . '</p>
        <img class="alignnone size-full wp-image-419" src="http://img.haodanku.com/' . $goods['itempic_copy'] . '" alt="' . $goods['itemshorttitle'] . '" width="790" height="970" />
        <img class="alignnone size-full wp-image-419" src="' . $goods['itempic'] . '" alt="' . $goods['itemshorttitle'] . '" width="790" height="970" />';
        return $str;
    }
}