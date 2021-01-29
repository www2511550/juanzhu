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
    public function articleList(Request $request)
    {
        $cid = intval($request->get('cid'));
        $data = ['msg' => '', 'code' => 1, 'url' => '', 'data' => []];
        $objDb = DB::connection('baiduMysql')->table('post')->where('log_Status', 0);
        $cid && $objDb->where('log_CateID', $cid);
        $paginate = $objDb->paginate(10);
        foreach ($paginate as $value) {
            $data['data']['itemList'][] = [
                'id' => $value->log_ID,
                'firstImg' => $value->log_Cover ?: 'http://juanzhuzhu.com/no-images.jpg',
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
        $data = ['msg' => '', 'code' => 1, 'url' => '', 'data' => []];
        $id = intval($request->get('id'));
        if (!$id) {
            $data['code'] = 0;
            $data['msg'] = '文章不存在';
            return $data;
        }
        $record = DB::connection('baiduMysql')->table('post')->where('log_ID', $id)->first();
        if ($record) {
            $data['data'] = [
                'id' => $id,
                'title' => $record->log_Title,
                'publish_date' => date('Y-m-d H:i', $record->log_PostTime),
                'content' => $record->log_Content,
                'keywords' => ' ',
                'description' => $record->log_Intro,
                'content_arr' => $record->log_Content_Arr ? json_decode($record->log_Content_Arr, true) : [],
            ];
        }
        return $data;
    }

    /**
     * 获取分类数据
     */
    public function categoryList()
    {
        $data = ['msg' => 'ok', 'code' => 1, 'url' => '', 'data' => []];
        $cateData = DB::connection('baiduMysql')->table('category')->orderBy('cate_Order', 'desc')->get();

        foreach ($cateData as $value) {
            $data['data']['categoryList'][] = [
                'id' => $value->cate_ID,
                'model_name' => $value->cate_Alias,
                'title' => $value->cate_Name,
                'content' => '',
            ];
        }

        return $data;
    }

    /**
     * 站点信息配置
     */
    public function siteInfo()
    {
        return ['msg' => 'ok', 'code' => 1, 'url' => '', 'data' => [
            'siteName'=>'品牌优惠资讯','indexTitle'=>'一手品牌优惠资讯发布平台',
            'keywords'=>'品牌优惠,品牌特惠,品牌优惠券,淘宝天猫内部优惠券',
            'description' => '',
        ]];
    }

}