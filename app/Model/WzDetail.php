<?php
/**
 * Created by PhpStorm.
 * User: 10574
 * Date: 2018/4/20
 * Time: 13:20
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WzDetail extends Model
{

    /**
     * 与模型关联的数据表。
     * @var string
     */
    protected $table = 'wz_detail';

    /**
     * 指定是否模型应该被戳记时间。
     *
     * @var bool
     */
    public $timestamps = false;

}