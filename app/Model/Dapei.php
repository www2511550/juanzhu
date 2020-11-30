<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2018/7/9
 * Time: 下午8:58
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Dapei extends Model
{
    /**
     * 与模型关联的数据表。
     * @var string
     */
    protected $table = 'dapei';

    /**
     * 指定是否模型应该被戳记时间。
     *
     * @var bool
     */
    public $timestamps = true;

    public function quanUrl($val)
    {
        $quanUrl = '/';
        if ($val['quan_id'] && $val['goods_id']) {
            $pid = Config::get('pid');
            $quanUrl = 'https://uland.taobao.com/coupon/edetail?activityId=' . $val['quan_id'] . '&itemId=' . $val['goods_id'] . '&pid=' . $pid;
        }
        return $quanUrl;
    }


    /**
     * 获取封面图
     * @param $cover
     */
    public function getCover($vo, $type = '')
    {
        $arrCover = array_filter(explode(',', $vo->cover));
        // 7dapei.com网站存储10张，截取三张
        if($vo->cate_name == '7dapei' && count($arrCover) > 3){
            $arrCover = array_splice($arrCover, 0, 3);
        }
        return 'arr' == $type ? $arrCover : $arrCover[0];
    }

}