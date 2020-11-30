<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2017/10/18
 * Time: 下午10:49
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * 与模型关联的数据表。
     * @var string
     */
    protected $table = 'message';

    /**
     * 指定是否模型应该被戳记时间。
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 格式化消息列表数据
     * @param $msg
     * @return array
     */
    public function formatMsgList($msg){
        $data = [];

        $data['title'] = $msg->title;
        $data['type'] = $msg->type;
        $data['url'] = $msg->url;
        $data['time'] = date('m月d日 H:i', strtotime($msg->created_at));

        return $data;
    }

}