<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2018/7/9
 * Time: 下午8:38
 */
namespace App\Console\Commands;

use App\Logic\IndexLogic;
use App\Model\Dapei;
use Carbon\Carbon;
use Illuminate\Console\Command;
use DB;

class DapeiMake extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dapei:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make dapei article';

    public function __construct()
    {
        parent::__construct();
        $this->arrFilter = ['妈妈', '中老年', '母亲', '男', '女童'];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // $arrCate1 = ['内衣','面膜', '眼霜','气垫','彩妆套装','防晒喷雾','睫毛膏', '雪纺','连衣裙','长裙','复古','短裙', '口红', '包包','T恤','太阳伞','情侣','蝴蝶结'];
        $arrCate1 = ['隔离', '睫毛膏', '彩妆盘', '唇膏', '腮红', '香水', '精油', '身体护理', '丰胸', '纤体', '脱毛',
            '面膜', '洁面', '防晒', '爽肤水', '眼霜', '乳液', '面霜', '精华', '卸妆', '眼线', '粉底液', 'BB霜',];
        $this->make($arrCate1);
//
        $arrCate2 = ['夏上新', '大码女装', ' 薄西装', 'ifashion女装', '棉麻连衣裙', '旗袍', '真丝连衣裙', '大码连衣裙', '冰丝冰感', '红人推荐', '私服名媛'
            , '文艺复古', '街头潮流', '原创设计', '通勤丽人', '婚纱礼服', '民族服装', 'T恤', '衬衫', ' 裤子 ', '半身裙', '牛仔裤 ', '蕾丝衫'
            , '雪纺连衣裙', '阔腿裤 ', '时尚套装', '防晒衫', '短裤', '背心吊带', '连衣裙', '雪纺衫', '甜美清新'];
        $this->make($arrCate2);

        // 通过好单库搜索生成文章甜美清新
        $arrSearch = ['内衣', '面膜', '眼霜', '气垫', 'BB霜', '防晒', '爽肤水', '眼霜', '乳液', '面霜', '精华', '卸妆', '眼线', '粉底液',
            '口红', '包包', '情侣', 'T恤', '夏上新', '雪纺连衣裙', '阔腿裤', '时尚套装', '防晒衫', '短裤', '背心吊带', '连衣裙', '雪纺衫', '甜美清新'];
        $this->haodankuSearch($arrSearch);

    }

    public function make($arrCate)
    {
        $indexLogic = new IndexLogic();
        $arrFilter = $this->arrFilter;
        foreach ($arrCate as $name) {
            $search = $indexLogic->searchList(['kw'=>$name, 'page'=>1], 1000);
//            $search = $indexLogic->searchList(['kw' => $name, 'page' => 1, 'cid' => 1], 1000);
            if (!$search['ids']) continue;
            $arr = $search['ids'];
            $couponData = [];
            foreach ($arr as $id) {  // 五个一组
                $coupon = \App\Model\Coupon::find($id);

                if ($test = Dapei::where('content', 'like', '%' . $coupon->GoodsID . '%')->first()) {
                    continue;
                }
                // 关键词过滤
                $is_continue = 0;
                foreach ($arrFilter as $filter) {
                    if (false !== strpos($coupon->Title, $filter)) {
                        $is_continue = 1;
                        break;
                    }
                }
                if ($is_continue) continue;


                $couponData[] = $coupon;
                if (count($couponData) < 5) continue;

                $title = $content = $cover = $intro = '';
                foreach ($couponData as $coupon) {
                    !$title && $title .= $coupon->Title;
                    !$intro && $intro .= $coupon->Introduce;
                    if (count(array_filter(explode(',', $cover))) < 3) {
                        $cover .= $coupon->Pic . ',';
                    }
                    $content[] = [
                        'price' => $coupon->Price,
                        'quan_price' => $coupon->Quan_price,
                        'intro' => $coupon->Introduce,
                        'goods_id' => $coupon->GoodsID,
                        'quan_id' => $coupon->Quan_id,
                        'cover' => $coupon->Pic,
                    ];
                }
                // 存储
                if (!Dapei::where('title', $title)->value('id')) {
                    Dapei::insert([
                        'title' => $title,
                        'content' => json_encode($content),
                        'cover' => $cover,
                        'intro' => $intro,
                        'cate_name' => $name,
                        'browse_num' => rand(50, 100),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
                $couponData = [];
            }
        }
    }

    // 好单裤
    public function haodankuSearch($arrSearch)
    {
        foreach ($arrSearch as $name){
            $url = 'http://v2.api.haodanku.com/supersearch';
            $params = [
                'apikey' => 'juanzhuzhu',
                'cid' => '1',
                'back' => '1000', // 每页条数
                'min_id' => 1,    // 页码
                'keyword' => urlencode(urlencode($name)),    // 页码
            ];
            $result = http($url, $params);
            $result = json_decode($result, true);
            if ($result['data']){
                $arrFilter = $this->arrFilter;
                foreach ($result['data'] as $val){

                    if ($test = Dapei::where('content', 'like', '%' . $val['itemid'] . '%')->first()) {
                        continue;
                    }
                    // 关键词过滤
                    $is_continue = 0;
                    foreach ($arrFilter as $filter) {
                        if (false !== strpos($val['itemtitle'], $filter)) {
                            $is_continue = 1;
                            break;
                        }
                    }
                    if ($is_continue) continue;


                    $couponData[] = $val;
                    if (count($couponData) < 5) continue;

                    $title = $cover = $intro = '';
                    $content = [];
                    foreach ($couponData as $coupon) {
                        !$title && $title .= $coupon['itemtitle'];
                        !$intro && $intro .= $coupon['itemdesc'];
                        if (count(array_filter(explode(',', $cover))) < 3) {
                            $cover .= $coupon['itempic'] . ',';
                        }
                        $content[] = [
                            'price' => $coupon['itemprice'],
                            'quan_price' => $coupon['itemendprice'],
                            'intro' => $coupon['itemdesc'],
                            'goods_id' => $coupon['itemid'],
                            'quan_id' => $coupon['activityid'],
                            'cover' => $coupon['itempic'],
                            'shop_type' => $coupon['shoptype'],
                        ];
                    }
                    // 存储
                    if (!Dapei::where('title', $title)->value('id')) {
                        Dapei::insert([
                            'title' => $title,
                            'content' => json_encode($content),
                            'cover' => $cover,
                            'intro' => $intro,
                            'cate_name' => $name,
                            'browse_num' => rand(50, 100),
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    }
                    $couponData = [];
                }
            }
        }
    }
}