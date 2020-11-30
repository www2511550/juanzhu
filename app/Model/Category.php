<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 17/4/29
 * Time: 下午10:52
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * 与模型关联的数据表。
     * @var string
     */
    protected $table = 'category';

    /**
     * 指定是否模型应该被戳记时间。
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 格式化商品分类
     */
    public function formatCateData( $val ){
        $arrReturn = [];
        if( $val ) {
            $arrReturn['cid'] = $val->cid;
            $arrReturn['c_name'] = $val->c_name;
            $arrReturn['total'] = Coupon::where('Quan_time', '>=', date('Y-m-d'))->where('Cid', $val->cid)->count();
        }
        return $arrReturn;
    }

    /**
     * 获取分类
     * @param int $type
     * @return array
     */
    public static function getArrCate($type = 0)
    {
        $data = [];
        $cateData = Category::where('status', 1)->get();
        if (count($cateData)) {
            foreach ($cateData as $key => $cate) {
                $data[$key]['title'] = $cate->c_name;
                $data[$key]['cid'] = $cate->cid;
                $data[$key]['img_url'] = 1 == $type ? $cate->icon_url : '';
            }
        }
        array_unshift($data, ['title'=>'全部', 'cid'=>0, 'img_url'=>'']);

        return $data;
    }

    /**
     * 格式化首页分类
     * @param $cate
     */
    public function formatIndexCate($cate)
    {
        $data = [];
        if ($cate) {
            $data['cid'] = $cate->cid;
            $data['name'] = $cate->c_name;
            $data['img'] = 'http://juanzhuzhu.com/images/cate_' . $cate->cid . '.png';
        }

        return $data;
    }
}