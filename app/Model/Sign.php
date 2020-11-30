<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2017/10/15
 * Time: 下午10:19
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Sign extends Model
{
    /**
     * 与模型关联的数据表。
     * @var string
     */
    protected $table = 'sign';

    /**
     * 指定是否模型应该被戳记时间。
     *
     * @var bool
     */
    public $timestamps = false;




}