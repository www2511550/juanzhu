<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2017/9/24
 * Time: 下午10:07
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    /**
     * 与模型关联的数据表。
     * @var string
     */
    protected $table = 'news';

    /**
     * 指定是否模型应该被戳记时间。
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * 格式化优券列表数据
     * @param $news
     */
    public function formatNewsList($news)
    {
        $data = [];
        $data['id'] = (string)$news->id;
        $data['title'] = $news->title;
        $data['intro'] = $news->intro;
        $data['cover'] = $news->cover;
        $data['is_top'] = (string)$news->is_top;
        $data['comment_num'] = (string)$news->comment_num;
        $data['browse_num'] = (string)$news->browse_num;
        $data['url'] = $news->getNewsUrl($news->id);
//        $data['url'] = 'http://localhost4:8888/api/newsDetail?news_id=' . $news->id;
        $data['time'] = strtotime($news->updated_at) ? date('m-d H:i', strtotime($news->updated_at)) : date('m-d H:i', strtotime($news->created_at));

        return $data;
    }

    /**
     * 获取优券快报地址
     * @param $news
     */
    public function getNewsUrl($id)
    {
        return $id ? __ROOT__ . '/api/news/detail?news_id=' . $id : '';
    }

}