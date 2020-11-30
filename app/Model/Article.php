<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2018/5/6
 * Time: 下午10:04
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /**
     * 与模型关联的数据表。
     * @var string
     */
    protected $table = 'article';

    /**
     * 指定是否模型应该被戳记时间。
     *
     * @var bool
     */
    public $timestamps = false;

}