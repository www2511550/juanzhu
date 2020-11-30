<?php
/**
 * Created by Chengcong.
 * Date: 2017/5/25 14:45
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    /**
     * 与模型关联的数据表。
     * @var string
     */
    protected $table = 'banner';

    /**
     * 指定是否模型应该被戳记时间。
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * 格式化banner数据
     */
    public function formatBanner($vo, $type = '')
    {
        $data = [];
        if ($vo->img_url && $vo->to_url) {
            $data['title'] = $vo->title;
            $data['img_url'] = ('app' == $type ? 'http://juanzhuzhu.com/' : '/') . $vo->img_url;
            $data['toUrl'] = $vo->to_url;
        }

        return $data;
    }
}