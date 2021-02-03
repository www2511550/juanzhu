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
use Illuminate\Support\Facades\Cache;
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

        $objDb = DB::table('bd_brand')->where('status', 1);
        $cid && $objDb->where('cid', $cid);
        $paginate = $objDb->paginate(10);
        foreach ($paginate as $value) {
            $data['data']['itemList'][] = [
                'id' => $value->id,
                'firstImg' => $value->cover ?: 'http://juanzhuzhu.com/no-images.jpg',
                'title' => $value->title,
                'intro' => $value->intro,
                'publish_date' => $value->created_at,
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

        $record = DB::table('bd_brand')->find($id);
        if ($record) {
            $data['data'] = [
                'id' => $id,
                'title' => $record->title,
                'publish_date' => $record->created_at,
                'content' => '',
                'keywords' => ' ',
                'description' => $record->intro,
                'content_arr' => $record->content_arr ? json_decode($record->content_arr, true) : [],
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

        $cateData = DB::table('bd_category')->where('status', 1)->orderBy('sort', 'desc')->get();
        foreach ($cateData as $value) {
            $data['data']['categoryList'][] = [
                'id' => $value->cid,
                'model_name' => $value->model_name,
                'title' => $value->title,
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
            'siteName' => '品牌优惠资讯', 'indexTitle' => '一手品牌优惠资讯发布平台',
            'keywords' => '品牌优惠,品牌特惠,品牌优惠券,淘宝天猫内部优惠券',
            'description' => '',
        ]];
    }

}