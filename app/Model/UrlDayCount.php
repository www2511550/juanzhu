<?php
/**
 *
 * User: chengcong
 * Date: 2018/6/4
 * Time: 下午8:15
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UrlDayCount extends Model
{
    /**
     * 与模型关联的数据表。
     * @var string
     */
    protected $table = 'url_day_count';

    /**
     * 指定是否模型应该被戳记时间。
     *
     * @var bool
     */
    public $timestamps = false;


}
