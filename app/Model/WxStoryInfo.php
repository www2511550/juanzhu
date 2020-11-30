<?php
/**
 * 品质小说-用户信息模型
 * Created by PhpStorm.
 * User: 10574
 * Date: 2018/3/25
 * Time: 14:21
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WxStoryInfo extends Model
{

    /**
     * 与模型关联的数据表。
     * @var string
     */
    protected $table = 'wx_story_info';

    /**
     * 指定是否模型应该被戳记时间。
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * 加密openid
     * author chengcong
     */
    public static function md5openid($openid)
    {
        return md5(md5($openid));
    }

}