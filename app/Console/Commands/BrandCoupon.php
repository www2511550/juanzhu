<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class BrandCoupon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'brand:coupon';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update brand coupon';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * 更新bd.juanzhuzhu.com(百度小程序博客)品牌优惠券
     * @return mixed
     */
    public function handle()
    {
        $db = DB::connection('baiduMysql');
        $dbData = $db->table('post')->where('log_CateID', 3)->get();

        foreach ($dbData as $record){
            $data = json_decode(file_get_contents('http://onsales.top/dtk.php?act=brandProudct&id='.$record->log_Meta), true);
            $strGoods = '';
            // 按照销量排序
            $arrList = $data['data']['list'] ?: [];
            $arrTmpPrice = array();
            if (!count($arrList)) continue;
            foreach ($arrList as $value) {
                $arrTmpPrice[] = $value['monthSales'];
            }
            array_multisort($arrTmpPrice, SORT_DESC, $arrList);
            foreach ($arrList as $value) {
                // 获取单品优惠券
                $coupon = json_decode(file_get_contents('http://onsales.top/dtk.php?act=goodsCoupon&id='.$value['goodsId']), true);
                $strGoods .= '<p><img class="ue-image" src="' . ($value['marketingMainPic'] ?: $value['mainPic']) . '" title="' . $value['title'] . '"/></p>
            <p>【券后' . $value['actualPrice'] . '元】' . $value['desc'] . '【复制口令：'.$coupon['data']['tpwd'].'】</p>';
            }

//            $strGoods .= '<p><a href="' . $coupon['data']['couponClickUrl'] . '" target="_blank"><img class="ue-image" src="' . ($value['marketingMainPic'] ?: $value['mainPic']) . '" title="' . $value['title'] . '"/></a></p>
//            <p><a href="' . $value['couponLink'] . '" target="_blank">【券后' . $value['actualPrice'] . '元】' . $value['desc'] . '【复制口令：'.$coupon['data']['tpwd'].'】</a></p>';
            $record->log_Content = $strGoods;
            echo $db->table('post')->where('log_ID', $record->log_ID)->update([
                'log_Content' => $record->log_Content,
            ]);
            usleep(500000);
        }

//        // 品牌
//        $url = 'http://onsales.top/dtk.php?act=brandName';
//        $strJson = file_get_contents($url);
//        $data = json_decode($strJson, true);
//        $log_CateID = 3; // 品牌id
//        $hours = -6;
//        foreach ($data['data'] as $value){
//            $log_Title = $value['brandName'].'-'.$value['simpleLabel'];
//            $record = $db->table('post')->where('log_CateID', $log_CateID)->where('log_Title', $log_Title)->first();
////            pre($value);
////            pre($record);die;
//            $logCentent = '<p><img class="ue-image" src="' . $value['brandLogo'] . '" title="'.$value['brandName'].'.png" alt="'.$value['brandName'].'.png"/></p>';
//            $logCentent .= $value['brandDesc'];
//            if ($record){
//                pre($record->log_ID);
//                $db->table('post')->where('log_ID', $record->log_ID)->update([
//                    'log_Content' => $logCentent,
//                    'log_Meta' => $value['brandId'],
//                    'log_AuthorID' => 2,
//                    'log_ViewNums' => rand(1,100)
//                ]);
//            }else{
//                $hours -= 6;
//                $db->table('post')->insert([
//                    'log_CateID' => $log_CateID,
//                    'log_AuthorID' => 2,
//                    'log_Title' => $log_Title,
//                    'log_Intro' => $value['brandDesc'],
//                    'log_Content' => $logCentent,
//                    'log_PostTime' => strtotime(date("Y-m-d H:i:s", strtotime($hours." hours"))),
//                    'log_Meta' => $value['brandId'], // 大淘客品牌id
//                ]);
//            }
//        }

    }
}
