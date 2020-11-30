<?php
/**
 * 优惠券快报分类
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2017/9/26
 * Time: 下午9:09
 */
namespace App\Api;

use App\Model\Collect;
use App\Model\Comment;
use App\Model\News;
use Illuminate\Http\Request;

class NewsController extends BaseController
{

    /**
     * 优惠券快报列表页
     */
    public function lists(Request $request)
    {
        $data = ['status' => 1, 'info' => '', 'data'=>[]];
        $page = intval($request->page) ?: 1;

        $newsData = News::where('status', 1)->orderBy('is_top', 'desc')->orderBy('updated_at', 'desc')->orderBy('id', 'desc')
            ->paginate(10);
        if(count($newsData) > 0){
            foreach ($newsData as $news){
                $data['data'][] = $news->formatNewsList($news);
            }
        }

        $data['totalRecord'] = $newsData->total();
        $data['page'] = $page;

        return response()->json($data);
    }


    /**
     * 优券头条详细页
     */
    public function detail(Request $request)
    {
        $news_id = $request->news_id;
        $news = News::find($news_id);
        if (!$news->id) exit('news is not exist!');
        // 更新浏览数
        News::where('id', $news_id)->increment('browse_num');

        return view('newsDetail')->withNews($news);
    }

    /**
     * 快报收藏
     */
    public function collect(Request $request)
    {
        $user_id = intval($request->get('user_id'));
        $news_id = intval($request->get('news_id'));

        if($user_id <= 0 ){
            return response()->json(['status'=>0, 'info'=>'登陆后在收藏！']);
        }
        if ($news_id<=0 || !News::where('status',1)->where('id', $news_id)->first()){
            return response()->json(['status'=>0, 'info'=>'文章不存或已被删除！']);
        }

        // 添加或取消收藏
        $collect = Collect::where('user_id', $user_id)->where('news_id', $news_id)->first();
        if($collect->id){
            $collect->status = 2 == $collect->status ? 1 : 2;
            $collect->save();
            $data['info'] = 1 == $collect->status ? '收藏成功！' : '取消成功！';
        }else{
            $status = Collect::insert([
                'user_id' => $user_id,
                'news_id' => $news_id,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            if(false === $status){
                return response()->json(['status'=>0, 'info'=>'网络繁忙，稍后再试！']);
            }
            $data['info'] = '收藏成功！';
        }
        $data['status'] = 1;

        return response()->json($data);
    }

    /**
     * 评论
     * @param Request $request
     */
    public function comment(Request $request)
    {
        // 基本参数
        $user_id = intval($request->get('user_id'));
        $news_id = intval($request->get('news_id'));
        $username = $request->get('username');
        $content = $request->get('content');
        $pid = intval($request->get('pid'));

        if ($user_id <= 0) {
            return response()->json(['status' => 0, 'info' => '登陆后才能评论！']);
        }
        if ($news_id <= 0 || !$username || !$content) {
            return response()->json(['status' => 0, 'info' => '参数异常！']);
        }
        if (strlen($content) < 5) {
            return response()->json(['status' => 0, 'info' => '字数不能小于5！']);
        }

        // 添加评论
        $status = Comment::insert([
            'user_id' => $user_id,
            'news_id' => $news_id,
            'username' => $username,
            'content' => $content,
            'status' => 1,
            'pid' => $pid,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        if (false === $status) {
            return response()->json(['status' => 0, 'info' => '网络异常，稍后再试！']);
        }else{
            // 更新评论数
            News::where('id', $news_id)->increment('comment_num');
        }

        return response()->json(['status' => 1, 'info' => 'success！']);
    }

    /**
     * 获取收藏状态和评论数
     * author chengcong
     */
    public function getCollectAndComment(Request $request)
    {
        $data = ['status' => 1, 'info' => 'success!'];
        $news_id = intval($request->get('news_id'));
        $user_id = intval($request->get('user_id'));

        $collect = Collect::where('user_id', $user_id)->where('news_id', $news_id)->first();
        $data['data'] = [
            'is_collect' => 1 == intval($collect->status) ? 1 : 0,
            'comment_num' => intval(News::where('id', $news_id)->value('comment_num'))
        ];

        return $data;
    }

    /**
     * 获取评论列表
     * @param Request $request
     */
    public function commentList(Request $request)
    {
        $data = ['status' => 1, 'info' => '', 'data' => []];
        $news_id = intval($request->get('news_id'));
        $page = intval($request->get('page')) ?: 1;
        $limit = 10;

        // 获取评论
        $comment = Comment::where('news_id', $news_id)->where('status', 1)->where('pid', 0)->orderBy('id', 'desc')->paginate($limit);
        if (count($comment) > 0) {
            foreach ($comment as $vo) {
                $info = $vo->formatComment($vo);
                // 获取子评论
                $childComment = Comment::where('pid', $vo->id)->orderBy('id', 'asc')->get();
                if (count($childComment) > 0) {
                    foreach ($childComment as $child) {
                        $info['child'][] = $vo->formatComment($child, 2);
                    }
                }
                $data['data'][] = $info;
            }
        }
        $data['totalRecord'] = $comment->total();
        $data['totalPage'] = ceil($data['totalRecord'] / $limit);
        $data['page'] = $page;

        return response()->json($data);

    }

}