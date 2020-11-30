<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 17/7/2
 * Time: 下午8:02
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * 与模型关联的数据表。
     * @var string
     */
    protected $table = 'order';

    /**
     * 指定是否模型应该被戳记时间。
     *
     * @var bool
     */
    public $timestamps = true;










}