<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2017/9/24
 * Time: 下午3:53
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    /**
     * 与模型关联的数据表。
     * @var string
     */
    protected $table = 'config';

    /**
     * 指定是否模型应该被戳记时间。
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * 配置设置
     */
    public static function set($name = '', $value = '')
    {
        $data = ['name' => $name, 'value' => $value];
        $objConfig = Config::where('name', $name);
        $record = $objConfig->first();
        !$record && $data['created_at'] = date('Y-m-d H:i:s');

        return $record ? $objConfig->update($data) : $objConfig->insert($data);
    }

    /**
     * 获取配置
     * @return array
     */
    public static function get($name = '')
    {
        $value = Config::where('name', $name)->value('value');
        if ('pid' == $name && !$value) {
            $value = 'mm_47800736_21362628_72092261';
        }
        return $value;
    }

}