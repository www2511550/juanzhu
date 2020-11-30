<?php
/**
 * 微信公众号签到
 * Created by PhpStorm.
 * User: 10574
 * Date: 2018/3/23
 * Time: 8:58
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Wxsign extends Model
{
    /**
     * 与模型关联的数据表。
     * @var string
     */
    protected $table = 'wx_sign';

    /**
     * 指定是否模型应该被戳记时间。
     *
     * @var bool
     */
    public $timestamps = false;

    


}