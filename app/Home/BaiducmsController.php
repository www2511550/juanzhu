<?php
/**
 * Created by cc.
 * User: chengcong
 * Date: 2021/1/28
 * Time: 5:03 PM
 * 百度小程序接口专用
 */
namespace App\Home;

use Illuminate\Support\Facades\DB;

class BaiducmsController extends BaseController
{

    /**
     * 文章列表数据
     */
    public function articleList()
    {
        $data = ['msg'=>'', 'code'=>1, 'url'=>''];
        $paginate = DB::connection('baiduMysql')->table('post')->paginate(10);
        foreach ($paginate as $value){
            $data['data']['itemList'][] = [
                'id' => $value->log_ID,
                'firstImg' => 'https://bd.juanzhuzhu.com/zb_users/upload/2021/01/202101211611237111679670.png',
                'title' => $value->log_Title,
                'publish_date' => date('Y-m-d'),
            ];
        }
        return $data;
    }

}