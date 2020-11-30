<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2018/6/7
 * Time: 下午9:01
 */
namespace App\Money;

use App\Model\Wangzhuan;
use App\Model\WzDetail;
use Illuminate\Http\Request;
use Cache,DB;

class IndexController
{

    /**
     * 首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ( 'yangmao'== $request->route('cate')){
            $obj = DB::table('yangmao');
            if ($kw = $request->get('kw')){
                $obj->where('title', 'like', '%'.$kw.'%');
            }
            $paginate = $obj->orderBy('id', 'desc')->paginate(12);
            foreach ($paginate as $vo){
                $vo->type = 'yangmao';
            }
            $data['data'] = $paginate;
        }else{
            if($kw = $request->get('keyword') || 'xiangmu' == $request->route('cate')){
                'xiangmu' == $request->route('cate') && $kw = '项目';
                $data['data'] = Wangzhuan::where('status', 1)->where('title', 'like', '%'.$kw.'%')->orderBy('id', 'desc')->paginate(20);
            }else{
                $data['data'] = Wangzhuan::where('status', 1)->orderBy('id', 'desc')->paginate(12);
            }
        }

        $data['hot'] = Cache::remember('index_hot', 60,function (){
            return Wangzhuan::where('status', 1)->orderBy('browse_num', 'desc')->take(5)->get();
        });

        $data['recom'] = Cache::remember('index_rem', 60,function (){
            return Wangzhuan::where('status', 1)->orderByRaw('rand()')->take(5)->get();
        });

        return view('money.index', $data);
    }

    /**
     * 详细页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Request $request)
    {
        $id = $request->route('id');
        $detail = WzDetail::where('wz_id', $id)->value('content');
        $info = Wangzhuan::where('status', 1)->find($id);
        if (!$info->id) {
            echo 'error!';
            die;
        }
        $info->content = $detail ?: '';

        $data['info'] = $info;
        view()->share('title', $info->title);

        $data['hot'] = Wangzhuan::where('status', 1)->orderBy('browse_num', 'desc')->take(5)->get();

        $data['recom'] = Wangzhuan::where('status', 1)->orderByRaw('rand()')->take(5)->get();

        $data['nextPage'] = Wangzhuan::where('id','>', $id)->where('status', 1)->orderBy('id', 'asc')->first();
        $data['prePage'] = Wangzhuan::where('id','<', $id)->where('status', 1)->orderBy('id', 'desc')->first();

        return view('money.detail', $data);
    }

    /**
     * 羊毛详情
     * @param Request $request
     */
    public function yangmaoDetail(Request $request)
    {
        $id = $request->route('id');
        $data['info'] = DB::table('yangmao')->find($id);
        view()->share('title', $data['info']->title);

        // 图片iframe处理
        $str = $data['info']->content;
        preg_match_all('/<img(\S*?)[^>]*>.*?|<.*? \/>/',$str,$match);
        if ($match[0]){
            foreach ($match[0] as $k => $preg_str){
                preg_match('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i',$preg_str,$img);
                $str_js = '<script type="text/javascript">showImg("'.$img[2].'");</script>';
                $str = str_replace($preg_str,  $str_js,$str);
            }
            $data['info']->content = $str;
        }


        $data['hot'] = Wangzhuan::where('status', 1)->orderBy('browse_num', 'desc')->take(5)->get();

        $data['recom'] = Wangzhuan::where('status', 1)->orderByRaw('rand()')->take(5)->get();

        $data['nextPage'] = DB::table('yangmao')->where('id','>', $id)->orderBy('id', 'asc')->first();
        $data['prePage'] = DB::table('yangmao')->where('id','<', $id)->orderBy('id', 'desc')->first();
        return view('money.yangmaoDetail', $data);
    }
}