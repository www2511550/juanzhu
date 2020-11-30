<?php
/**
 * 97866.com 小程序
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2018/4/6
 * Time: 下午9:08
 */

namespace App\Home;

use App\Logic\GoodsLogic;


class GoodsController extends BaseController
{

    /**
     * 新增商品
     */
    public function add(GoodsLogic $goodsLogic)
    {

        $this->addByTbkSelect();
//        $goodsLogic->autoAddGoods();

    }

    /**
     * 添加商品通过淘宝客选品库
     *
     */
    public function addByTbkSelect()
    {
        $goodsLogic = new GoodsLogic();
        $goodsLogic->autoAddByTbkSelect();

    }



}