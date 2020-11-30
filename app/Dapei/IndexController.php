<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2018/7/9
 * Time: 下午8:24
 */
namespace App\Dapei;

use App\Logic\DapeiLogic;
use App\Model\Dapei;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Cache;

class IndexController{

    public function __construct()
    {
        view()->share('arrCate', ['穿衣搭配', '雪纺', '连衣裙', '长裙', '复古', '短裙']);
        view()->share('arrTag', ['雪纺', '连衣裙', '长裙', '复古', '短裙','面膜', '眼霜','气垫','彩妆套装','防晒喷雾','睫毛膏']);
    }

    /**
     * 首页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $pageSize = 18;
        $keyword = $request->get('keyword');
        if ($cname = $request->route('name')) {
            '穿衣搭配' == $cname && $cname = '7dapei';
            $data = Dapei::where('cate_name', $cname)->orderBy('id', 'desc')->paginate($pageSize);
        } else {
            if ($keyword){
                $data = Dapei::where('title', 'like', '%'.$keyword.'%')->orderBy('id', 'desc')->paginate($pageSize);
            }else{
                if ($_GET['yc']==1){
                    $data = DB::table('dapei_baidu')->orderBy('id', 'desc')->paginate($pageSize);
                }else{
                    $data = Dapei::orderBy('id', 'desc')->paginate($pageSize);
                }
            }
        }

        $rightData = $this->getRightData($cname, $keyword);
        // 点击推荐
        $hot = $rightData['hot'] ?: [];
        // 站长推荐
        $recom = $rightData['recom'] ?: [];

        return view('dapei.index', compact('data', 'hot', 'recom'));
    }

    /**
     * 详细页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Request $request, DapeiLogic $dapeiLogic)
    {
        $id = $request->route('id');
        $data['data'] = Dapei::find($id);
        $data['data']->browse_num += 1;
        $data['data']->save();
        $data['data']->content = $dapeiLogic->getContent($data['data']);

        $data['dapei'] = new Dapei();
        $data['nextPage'] = Dapei::where('id', '>', $id)->orderBy('id', 'asc')->first();
        $data['prePage'] = Dapei::where('id', '<', $id)->orderBy('id', 'desc')->first();
        view()->share('title', $data['data']->title);

        $rightData = $this->getRightData($data['data']->cate_name);
        // 点击推荐
        $data['hot'] = $rightData['hot'] ?: [];
        // 站长推荐
        $data['recom'] = $rightData['recom'] ?: [];

        return view('dapei.detail', $data);
    }

    /**
     * 获取右侧推荐数据
     * @param string $cname
     * @param string $keyword
     * @return array
     */
    public function getRightData($cname = '', $keyword = '')
    {
        // 点击推荐
//        $hot = Cache::remember('index-hot:' . $cname . ':' . $keyword, 60, function () use ($cname, $keyword) {
//            $objDapei = new Dapei();
//            $cname && $objDapei->where('cate_name', $cname);
//            $keyword && $objDapei->where('title', 'like', '%' . $keyword . '%');
//            return $objDapei->orderBy('browse_num', 'desc')->paginate(12);
//        });
        $objDapei = new Dapei();
        $cname && $objDapei->where('cate_name', $cname);
        $keyword && $objDapei->where('title', 'like', '%' . $keyword . '%');
        $hot = $objDapei->orderBy('browse_num', 'desc')->paginate(12);

        // 站长推荐
//        $recom = Cache::remember('index-recom:' . $cname . ':' . $keyword, 60, function () use ($cname, $keyword) {
//            return Dapei::orderByRaw('rand()')->paginate(12);
//        });
        $recom = Dapei::orderByRaw('rand()')->paginate(12);

        return ['hot' => $hot, 'recom' => $recom];
    }
    /**
     * 针对百度原创，去链接
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function yc(Request $request)
    {
        $id = $request->route('id');
        $data['data'] = DB::table('dapei_baidu')->where('id', $id)->first();
        $data['data']->browse_num += 1;
        DB::table('dapei_baidu')->where('id', $id)->increment('browse_num');

        $data['data']->content = json_decode($data['data']->content, true);

        $data['dapei'] = new Dapei();
        $data['nextPage'] = DB::table('dapei_baidu')->where('id','>', $id)->orderBy('id', 'asc')->first();
        $data['prePage'] = DB::table('dapei_baidu')->where('id','<', $id)->orderBy('id', 'desc')->first();
        view()->share('title', $data['data']->title);
        return view('dapei.yuanchuang',$data);
        
    }

    /**
     * 褥羊毛
     */
    public function ym(Request $request)
    {
        $id = (int)$request->route('id');
        $record = DB::table('yangmao')->where('id', $id)->first();
        if (!$record) die('not exsist');

        // 图片iframe处理
        $str = $record->content;
        preg_match_all('/<img(\S*?)[^>]*>.*?|<.*? \/>/',$str,$match);
        if ($match[0]){
            foreach ($match[0] as $k => $preg_str){
                preg_match('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i',$preg_str,$img);
                $str_js = '<script type="text/javascript">showImg("'.$img[2].'");</script>';
                $str = str_replace($preg_str,  $str_js,$str);
            }
            $record->content = $str;
        }

        return view('dapei.yangmao', ['data'=>$record]);
    }
}