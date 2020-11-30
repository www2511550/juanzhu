<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2017/10/11
 * Time: 下午9:41
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    /**
     * 与模型关联的数据表。
     * @var string
     */
    protected $table = 'sms';

    /**
     * 指定是否模型应该被戳记时间。
     *
     * @var bool
     */
    public $timestamps = false;


}