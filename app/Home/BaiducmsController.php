<?php
/**
 * Created by cc.
 * User: chengcong
 * Date: 2021/1/28
 * Time: 5:03 PM
 * 百度小程序接口专用
 */
namespace App\Home;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BaiducmsController extends BaseController
{

    /**
     * 文章列表数据
     */
    public function articleList()
    {
        $data = ['msg' => '', 'code' => 1, 'url' => '', 'data'=>[]];
        $paginate = DB::connection('baiduMysql')->table('post')->where('log_Status', 0)->paginate(10);
        foreach ($paginate as $value) {
            preg_match('<img.*src=["](.*?)["].*?>',$value->log_Content,$match);
            $data['data']['itemList'][] = [
                'id' => $value->log_ID,
                'firstImg' => $match[1] ?: 'http://juanzhuzhu.com/no-images.jpg',
                'title' => $value->log_Title,
                'publish_date' => date('Y-m-d H:i', $value->log_PostTime),
            ];
        }
        $data['data']['total'] = $paginate->total();
        $data['data']['page'] = $paginate->currentPage();
        return $data;
    }

    /**
     * 文章详情
     */
    public function articleDetail(Request $request)
    {
        $data = ['msg' => '', 'code' => 1, 'url' => '', 'data'=>[]];
        $id = intval($request->get('id'));
        if (!$id){
            $data['code'] = 0;
            $data['msg'] = '文章不存在';
            return $data;
        }
        $record = DB::connection('baiduMysql')->table('post')->where('log_ID', $id)->first();
        if ($record){
            $data['data'] = [
                'id' => $id,
                'title' => $record->log_Title,
                'publish_date' => date('Y-m-d H:i', $record->log_PostTime),
                'content' => $record->log_Content,
                'keywords' => '',
                'description' => $record->log_Intro
            ];
        }
        return $data;
    }

}