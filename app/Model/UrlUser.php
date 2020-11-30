<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2018/5/17
 * Time: 下午9:17
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UrlUser extends Model
{

    /**
     * 与模型关联的数据表。
     * @var string
     */
    protected $table = 'url_user';

    /**
     * 指定是否模型应该被戳记时间。
     *
     * @var bool
     */
    public $timestamps = true;



}