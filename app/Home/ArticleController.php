<?php
/**
 * 文章
 * User: chengcong
 * Date: 2018/5/8
 * Time: 下午9:25
 */
namespace App\Home;

use App\Logic\IndexLogic;
use App\Model\Article;
use App\Model\Coupon;
use Illuminate\Http\Request;
use Cache;

class ArticleController extends BaseController
{

    /**
     * 首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, IndexLogic $indexLogic)
    {
        // $data['data'] = Article::orderBy('id', 'desc')->paginate(20);
        $search = $indexLogic->searchList(
            [
                'kw' => '夏季 女装',
                'page'=>$request->get('page')
            ]);
        $data['total_page'] = ceil($search['total']/24);
        if ($search['ids']){
            Cache::forget('idxArticle');
            $data['data'] = Cache::remember('idxArticle', 3, function () use($search){
                return  Coupon::whereIn('id', $search['ids'])->get();
            });
        }

        $data['topArticle'] = Cache::remember('topArticle', 30, function (){
            return  Article::select('id', 'title','cover')->take(3)->orderByRaw('rand()')->get();
        });

        $data['hotArticle'] = Cache::remember('indexHotArticle', 30, function (){
            return  Article::select('id', 'title','cover')->take(5)->orderByRaw('rand()')->get();
        });

        return view('home.article.index', $data);
    }

    /**
     * 文章详情
     * @param Request $request
     * @return mixed
     */
    public function detail(Request $request)
    {
        $id = $request->route('id');
        $data['detail'] = Article::find($id);
        if (!$data['detail']){
            $coupon = Coupon::find($id);
            $coupon->title = $coupon->Title;
            $coupon->created_at = $coupon->updated_at;
            $coupon->daodu = $coupon->Introduce;
            $coupon->intro = $coupon->Title.'。'.$coupon->Introduce;
            $coupon->cover = $coupon->Pic;
            $coupon->toUrl = $coupon->getQuanUrl($coupon);
            $data['detail'] = $coupon;
        }

        // 热文
        $data['hotArticle'] = Cache::remember('hotArticle1_'.$id, 30, function () use($id){
           return  Article::select('id', 'title','cover')->where('id','!=', $id)->take(5)->orderByRaw('rand()')->get();
        });

        $data['seo']['title'] = $data['detail']->title ?: ($data['detail']->Title ?: '');

        return view('home.article.detail', $data);
    }


    public function append(){

    }
}