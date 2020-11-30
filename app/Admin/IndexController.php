<?php
/**
 * Created by Chengcong.
 * Date: 2017/5/23 11:09
 */
namespace App\Admin;


use App\Model\HotWord;
use Illuminate\Http\Request;

class IndexController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();

        // 检测是否登录
        $this->checkAdminLogin();
    }

    /**
     * 首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.index.index');
    }

    /**
     * 搜索热词设置
     */
    public function hotWord(Request $request)
    {
        $id = $request->get('id');
        if ('GET' == $request->method()) {
            $hotData = HotWord::where('status', 1)->orderBy('type', 'asc')->orderBy('id', 'desc')->paginate(10);
            $data['data'] = $hotData;
            $data['page'] = $hotData->render();
            $data['hot'] = HotWord::find($id);

            return view('admin.index.hotWord', $data);
        } else {
            $name = $request->get('name');
            $type = $request->get('type');
            !in_array($type, [1,2,3]) && $type = 1;

            if($id){
                $word = HotWord::find($id);
                if($word){
                    $word->name = $name;
                    $word->type = $type;
                    if(false ===$word->save()){
                        return $this->error('网络异常，稍后再试！');
                    };
                }
                return $this->success('修改成功！');
            }else{
                $word = HotWord::where('name', $name)->where('type', $type)->first();
                if($word){
                    return $this->error('热词已存在，请勿重复添加！');
                }
                $status = HotWord::insert([
                    'name'=>$name,
                    'type'=>$type,
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                ]);
                if(false === $status){
                    return $this->error('网络异常，稍后再试！');
                }
                return $this->success('添加成功！');
            }

        }

    }

    /**
     * 删除热词
     * @param Request $request
     */
    public function delHotWord(Request $request)
    {
        $id = $request->get('id');
        $status = HotWord::where('id', $id)->update([
            'status' => 0
        ]);
        if (false === $status) {
            return response()->json(['status' => 0, 'info' => '网络异常！']);
        }
        return response()->json(['status' => 1, 'info' => '操作成功！']);
    }
    /**
     * 网站基本信息
     */
    public function info()
    {
        return view('admin.index.info');
    }

    /**
     * 修改密码
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pass()
    {
        return view('admin.index.pass');
    }

    /**
     * 单页管理
     */
    public function page()
    {
        return view('admin.index.page');
    }

    /**
     * 首页轮播
     */
    public function adv()
    {
        return view('admin.index.adv');
    }

    /**
     * 留言管理
     */
    public function book()
    {
        return view('admin.index.book');
    }

    /**
     * 栏目管理
     */
    public function column()
    {
        return view('admin.index.column');
    }

}