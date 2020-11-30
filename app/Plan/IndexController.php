<?php
/**
 * 植物识别
 * User: chengcong
 * Date: 2018/4/25
 * Time: 下午8:43
 */
namespace App\Plan;

use App\Service\BaiduService;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    /**
     * 首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('plan.index.index');
    }

    /**
     * 图片上传
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadPic(Request $request)
    {
        $data = ['status' => 0, 'info' => '', 'data' => []];
        $type = $request->get('type');
        $imgUrl = $_FILES['file']['tmp_name'];
        if (!$imgUrl) {
            $data['info'] = '请上传图片！';
            return response()->json($data);
        }

        if ($imgUrl) {
            $baiduService = new BaiduService($imgUrl);
            if ($baiduService->checkImg()) {
                $result = $baiduService->commom();
                if ($result) {
                    $data['status'] = 1;
                    $data['data']['name'] = $result['name'];
                }
            }
            if ($data['status'] != 1) $data['info'] = '上传失败，请重新尝试！';
        }
        return response()->json($data);
    }

}