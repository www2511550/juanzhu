<?php
/**
 * 网赚广告
 * User: chengcong
 * Date: 2018/4/21
 * Time: 下午12:39
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WzAds extends Model
{

    /**
     * 与模型关联的数据表。
     * @var string
     */
    protected $table = 'wz_ads';

    /**
     * 指定是否模型应该被戳记时间。
     *
     * @var bool
     */
    public $timestamps = true;

}