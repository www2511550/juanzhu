<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2017/10/15
 * Time: 下午6:15
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    /**
     * 与模型关联的数据表。
     * @var string
     */
    protected $table = 'friend';

    /**
     * 指定是否模型应该被戳记时间。
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * 格式化邀请好友数据
     * @param $friend
     * @return array
     */
    public function formatQQList($friend)
    {
        $data = [];

        $newUserInfo = User::find($friend->new_user_id);
        $data['time'] = date('Y.m.d', strtotime($friend->created_at));
        $data['cover'] = $newUserInfo->cover ?: __ROOT__ . '/images/no_center.png';
        $data['username'] = $newUserInfo->username;
        $data['status'] = 1 == $friend->status ? '邀请成功' : '待确认';

        return $data;
    }

    /**
     * 格式化后台邀请好友列表
     * @param $friend
     */
    public function formatAdminFriendList($friend)
    {
        $data = [];

        $new_user = User::find($friend->new_user_id);
        $data['id'] = $friend->id;
        $data['new_user'] = $new_user->username;
        $data['user'] = User::where('id', $friend->user_id)->value('username');
        $data['status'] = 1 == $friend->status ? '邀请成功' : '待注册';
        $data['intStatus'] = $friend->status;
        $data['yaoqing_time'] = date('Y-m-d H:i', strtotime($friend->created_at));
        $data['register_type'] = 'QQ';
        $data['register_time'] = 1 == $friend->status ? date('Y-m-d H:i', strtotime($friend->updated_at)) : '未注册';

        return $data;
    }
    /**
     * 格式化后台邀请好友明细
     * @param $friend
     */
    public function formatAdminFriendDetail($friend)
    {
        $data = [];

        $new_user = User::find($friend->new_user_id);
        $data['id'] = $friend->id;
        $data['new_user'] = $new_user->username;
        $data['user'] = User::where('id', $friend->user_id)->value('username');
        $data['status'] = 1 == $friend->status ? '邀请成功' : '待注册';
        $data['intStatus'] = $friend->status;
        $data['yaoqing_time'] = date('Y-m-d H:i', strtotime($friend->created_at));
        $data['register_type'] = 'QQ';
        $data['register_time'] = 1 == $friend->status ? date('Y-m-d H:i', strtotime($friend->updated_at)) : '未注册';

        return $data;
    }
    /**
     * 格式化邀请用户列表
     * @param $friend
     * @return array
     */
    public function formatAdminUser($friend)
    {
        $data = [];
        $user = User::find($friend->user_id);

        $data['num'] = $friend->total;
        $data['id'] = $user->id;
        $data['username'] = $user->username;
        $data['register_type'] = 'QQ';
        $data['reward'] = $user->reward;
        $data['time'] = date('Y-m-d H:i', strtotime($user->created_at));

        return $data;
    }
}
