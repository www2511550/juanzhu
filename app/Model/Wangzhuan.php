<?php
/**
 * Created by PhpStorm.
 * User: 10574
 * Date: 2018/4/20
 * Time: 13:11
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Wangzhuan extends Model
{

    /**
     * 与模型关联的数据表。
     * @var string
     */
    protected $table = 'wangzhuan';

    /**
     * 指定是否模型应该被戳记时间。
     *
     * @var bool
     */
    public $timestamps = false;

}