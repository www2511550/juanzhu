<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2018/5/15
 * Time: 下午10:35
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{

    /**
     * 与模型关联的数据表。
     * @var string
     */
    protected $table = 'url';

    /**
     * 指定是否模型应该被戳记时间。
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 微博跳转淘宝app链接
     * @param $url
     * @return string
     * author chengcong
     */
    public static function wbToTb($url)
    {
        return 'sinaweibo://browser/close?scheme=taobao:' . substr($url, strpos($url, '/'));
    }

}