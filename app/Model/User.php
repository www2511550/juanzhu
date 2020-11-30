<?php
/**
 * Created by Chengcong.
 * Date: 2017/4/13 17:58
 */
namespace App\Model;

use Illuminate\Http\Request;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use Searchable;
    /**
     * 与模型关联的数据表。
     * @var string
     */
    protected $table = 'user';
    /**
     * 指定是否模型应该被戳记时间。
     *
     * @var bool
     */
    public $timestamps = false;
    /**
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'posts_index';
    }

    /**
     * 注册类型
     */
    public static function arrRegisterType()
    {
        return [1 => '手机号', 2 => '微信', 3 => 'QQ', 4 => '微博', 5 => '淘宝'];
    }

    /**
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();
        return $array;
    }

    /**
     * 密码md5加密
     * @param $type 1-前台用户，2-后台用户
     */
    public static function md5Pwd($pwd, $type=1)
    {
        return md5(md5((2 == $type ? 'youquan_admin_' : 'youquan') . $pwd));
    }

    /**
     * 添加新用户
     * @param $tel
     * @param $pwd
     * @param int $user_role
     * @return mixed
     */
    public static function addOneUser($tel, $pwd, $user_role = 1, $type = 1, $openid = '', $username = '')
    {
        $insertData['username'] = $username ?: 'yq' . rand(100, 999) . rand(100, 999) . rand(1, 9);
        $insertData['pwd'] = User::md5Pwd($pwd);
        $insertData['tel'] = $tel;
        $insertData['cover'] = '';
        $insertData['user_role'] = $user_role; // 1、普通用户，2-代理
        $insertData['type'] = $type;
        $insertData['openid'] = $openid;
        $insertData['mobile_id'] = '';
        $insertData['created_at'] = date('Y-m-d H:i:s');

        return User::insertGetId($insertData);
    }

    /**
     * 格式化用户列表数据
     * @param $user
     */
    public function formatUserList($user)
    {
        $data = [];

        $data['id'] = $user->id;
        $data['username'] = $user->username;
        $data['tel'] = $user->tel;
        $data['type'] = $user->type;
        $data['user_role'] = 2 == $user->type ? '代理' : '普通会员';
        $data['pid'] = $user->pid;
        $data['time'] = $user->created_at;
        $data['status'] = $user->status;

        return $data;
    }

}