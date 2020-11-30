<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 17/6/25
 * Time: 下午10:36
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ClickDetail extends Model
{
    /**
     * 与模型关联的数据表。
     * @var string
     */
    protected $table = 'click_detail';

    /**
     * 指定是否模型应该被戳记时间。
     *
     * @var bool
     */
    public $timestamps = true;

}