<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2018/1/16
 * Time: 下午9:50
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Wxinfo extends Model
{

    /**
     * 与模型关联的数据表。
     * @var string
     */
    protected $table = 'wx_info';

    /**
     * 指定是否模型应该被戳记时间。
     *
     * @var bool
     */
    public $timestamps = true;

}