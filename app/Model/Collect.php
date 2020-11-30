<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2017/10/12
 * Time: 下午9:07
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Collect extends Model
{
    /**
     * 与模型关联的数据表。
     * @var string
     */
    protected $table = 'collect';

    /**
     * 指定是否模型应该被戳记时间。
     *
     * @var bool
     */
    public $timestamps = true;

}