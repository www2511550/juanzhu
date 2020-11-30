<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2017/9/24
 * Time: 下午9:02
 */
namespace App\Admin;

use App\Model\Comment;
use App\Model\News;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class NewsController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();

        $this->checkAdminLogin();
    }

    /**
     * 优券头条列表
     */
    public function index()
    {
        $data = News::where('status', 1)->orderBy('id', 'desc')->paginate(6);

        return view('admin.news.index')->withData($data);
    }

    /**
     * 添加优券头条
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addNews(Request $request)
    {

        if ('GET' == $request->method()) {

            return view('admin.news.addNews');
        } else {
            $news_id = $request->get('news_id');
            $title = $request->title ?: '';
            $intro = $request->intro ?: '';
            $content = $request->get('content') ?: '';
            $is_top = intval($request->is_top) ?: 0;
            $upload_url = $_FILES['cover']['tmp_name'];
            $cover = $request->cover ?: '';
            if (!$title || !$content) {
                return $this->error('标题或内容不能为空！');
            }
            if(!$news_id && !$upload_url && !$cover ) return $this->error('封面图不能为空！');

            // 图片上传
            $imgUrl = $cover;
            if($upload_url){
                $toPath = '/upload/news/'.date('Ymd').'/';
                !file_exists($toPath) && mkdir($toPath, 0777, true);
                $imgUrl = $toPath . time() . '_350x350.jpg';
                $image = Image::make($upload_url)->resize(350, 350)->save($imgUrl);
                if(!$image) return $this->error('封面图上传失败，稍后再试！');

            }

            $insertData = [
                'title' => $title,
                'intro' => $intro,
                'cover' => $imgUrl ?: '',
                'content' => $content,
                'is_top' => $is_top,
            ];
            $news_id && $insertData['created_at'] = date('Y-m-d H:i:s');
            $status = $news_id ? News::where('id', $news_id)->update($insertData) : News::insert($insertData);

            return false === $status ? $this->error('添加失败，稍后再试！') : $this->success('添加成功！');
        }

    }

    /**
     * 删除优券头条
     * @param Request $request
     */
    public function delNews(Request $request)
    {
        $news = News::find(intval($request->get('id')));
        if (!$news->id) {
            return response()->json(['status' => 0, 'info' => '已删除或下架！']);
        }

        $news->status = 0;
        if (false === $news->save()) {
            return response()->json(['status' => 0, 'info' => '网络异常！']);
        }
        return response()->json(['status' => 1, 'info' => '操作成功！']);
    }
    /**
     * 修改优券头条
     * @param Request $request
     */
    public function editNews(Request $request)
    {
        $id = intval($request->get('id'));

        $data = News::find($id);
        if(!$data->id) return $this->error('头条不存在！');

        return view('admin.news.eidtNews')->withData($data);
    }

    /**
     * 评论列表
     */
    public function commentList(Request $request)
    {
        if('POST' == $request->method()){
            $arrIds = $request->get('id');
            if(count($arrIds) > 0){
                foreach ($arrIds as $id){
                    Comment::where('id', $id)->update([
                        'status' => 2,
                    ]);
                }
            }
            return $this->success('删除成功！');
        }else{
            $data = ['data'=>[], 'page'=>''];
            $allComment = Comment::where('status', 1)->orderBy('id', 'desc')->paginate(10);
            if(count($allComment) > 0){
                foreach ($allComment as $comment){
                    $data['data'][] = $comment->formatAdminCommentList($comment);
                }
            }
            $data['page'] = $allComment->render();

            return view('admin.news.commentList', $data);
        }
    }

    /**
     * 删除评论
     * @param Request $request
     */
    public function delComment(Request $request)
    {
        $id = $request->get('id');

        $comment = Comment::find($id);
        if ($comment->id) {
            $comment->status = 2;
            if (false === $comment->save()) {
                return response()->json(['status' => 0, 'info' => '网络异常，稍后再试！']);
            }
        }

        return response()->json(['status' => 1, 'info' => '删除成功！']);
    }

}
