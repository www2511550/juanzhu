<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2017/9/21
 * Time: 下午9:25
 */
namespace App\Admin;

use App\Model\Category;
use App\Model\Banner;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class BannerController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();

        $this->checkAdminLogin();
    }

    /**
     * app banner
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function appBanner()
    {
        // 1、banner列表数据
        $data['data'] = Banner::where('status', 1)->paginate(5);

        // 2、编辑内容
        $data['cate'][0] = 'app首页';

        return view('admin.index.appBanner', $data);
    }

    /**
     * 添加banner
     */
    public function addBanner(Request $request)
    {
        $pid = $request->get('pid', 0);
        $title = $request->get('title');
        $to_url = $request->get('to_url');
        $note = $request->get('note');
        $sort = $request->get('sort', 0);
        $pic = $request->get('pic');
        $cid = $request->get('cid', 0);
        $upload_url = $_FILES['pic']['tmp_name'];

        if ($upload_url) {
            $toPath = 'upload/banner/';
            !file_exists($toPath) && mkdir($toPath, 777, true);
            $imgUrl = $toPath . time() . '_756x252.jpg';
            $image = Image::make($upload_url)->resize(756, 352)->save($imgUrl);

            if (!$image) exit('fail...');
        } else {
            $imgUrl = $pic;
        }

        $insertData['title'] = $title;
        $insertData['to_url'] = $to_url;
        $insertData['note'] = $note;
        $insertData['sort'] = $sort;
        $insertData['img_url'] = $imgUrl;
        $insertData['cid'] = $cid;
        $pic  && $insertData['created_at'] = $insertData['updated_at'] = date('Y-m-d H:i:s');

        $status = $pic ? Banner::where('id', $pid)->update($insertData) : Banner::insert($insertData);

        if ('false' === $status) return $this->error('网络异常，稍后再试！');

        return $this->success('添加成功！');
    }

    /**
     * 删除banner
     * @param Request $request
     */
    public function delBanner(Request $request)
    {
        $data = ['status'=>1, 'msg'=>''];
        $pid = $request->get('pid');
        $banner = Banner::find($pid);
        if( !$banner->id ) {
            $data['status'] = 0;
            $data['msg'] = 'banner不存在！';
            return response()->json($data);
        }
        $banner->status = 0;
        $banner->save();
        return response()->json($data);
    }

}