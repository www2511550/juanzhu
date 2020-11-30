<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2017/10/12
 * Time: 下午9:18
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * 与模型关联的数据表。
     * @var string
     */
    protected $table = 'comment';

    /**
     * 指定是否模型应该被戳记时间。
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 格式化评论
     * @param $comment
     * @param $type 2-子评论
     */
    public function formatComment($comment, $type = 1)
    {
        $data = [];

        $data['name'] = $comment->username;
        $data['content'] = $comment->content;
        if (1 == $type) {
            $data['id'] = $comment->id;
            $data['position'] = $comment->id . '楼';
            $strCover = User::where('id', $comment->user_id)->value('cover');
            $data['cover'] = $strCover ?: '';
            $data['content'] = $comment->content;
            $data['date'] = date('m-d H:i', strtotime($comment->created_at));
        }

        return $data;
    }

    /**
     * 格式化后台评论列表
     * @param $comment
     */
    public function formatAdminCommentList($comment)
    {
        $data = [];

        $data['id'] = $comment->id;
        $data['username'] = $comment->username;
        $data['content'] = $comment->content;
        $data['addtime'] = $comment->created_at;

        return $data;
    }
}