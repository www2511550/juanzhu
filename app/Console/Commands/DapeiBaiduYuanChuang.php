<?php
/**
 * 针对百度原创-不带购买链接
 * User: chengcong
 * Date: 2018/7/9
 * Time: 下午8:38
 */
namespace App\Console\Commands;

use App\Logic\IndexLogic;
use Carbon\Carbon;
use Illuminate\Console\Command;
use DB;

class DapeiBaiduYuanChuang extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dapei:yuanchuang';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make dapei article';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $arrCate = ['雪纺','连衣裙','长裙','复古','短裙', '衬衫'];
//        $arrCate = ['面膜', '眼霜','气垫','彩妆套装','防晒喷雾','睫毛膏'];
        $indexLogic = new IndexLogic();
        foreach ($arrCate as $name){
            $search = $indexLogic->searchList(['kw'=>$name, 'page'=>1, 'cid'=>1], 1000);
            if (!$search['ids']) continue;
            $arr = $search['ids'];
            $couponData = [];
            foreach ($arr as $id) {  // 五个一组
                $coupon = \App\Model\Coupon::find($id);

                // 关键词过滤
                if (false !== strpos($coupon->Title, '妈妈') || false !== strpos($coupon->Title, '中老年') | false !== strpos($coupon->Title, '母亲')){
                    continue;
                }

                if ($test = DB::table('dapei_baidu')->where('content', 'like', '%' . $coupon->GoodsID . '%')->first()) {
                    continue;
                }

                $couponData[] = $coupon;
                if (count($couponData) < 8) continue;

                $title = $content = $cover = $intro = '';
                foreach ($couponData as $coupon){
                    !$title && $title .= $coupon->Title;
                    !$intro && $intro .= $coupon->Introduce;
                    if (count(array_filter(explode(',',$cover)))<3){
                        $cover .= $coupon->Pic.',';
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
                if (!DB::table('dapei_baidu')->where('title', $title)->value('id')){
                    DB::table('dapei_baidu')->insert([
                        'title' => $title,
                        'content' => json_encode($content),
                        'cover' => $cover,
                        'intro' => $intro,
                        'cate_name' => $name,
                        'browse_num' => rand(50,100),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
                $couponData = [];
            }
        }
    }
}