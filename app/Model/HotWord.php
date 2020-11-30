<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2017/11/1
 * Time: 下午10:55
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class HotWord extends Model
{
    /**
     * 与模型关联的数据表。
     * @var string
     */
    protected $table = 'hot_word';

    /**
     * 指定是否模型应该被戳记时间。
     *
     * @var bool
     */
    public $timestamps = true;


}