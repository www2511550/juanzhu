<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2017/8/6
 * Time: 下午9:50
 */
namespace App\Console\Commands;

use App\Logic\CouponLogic;
use Illuminate\Console\Command;
use QL\QueryList;


class CatchIbantang extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coupon:ibantang {min} {max}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'catch ibantang coupon';

    /**
     * Create a new command instance.
     *
     * @param  DripEmailer  $drip
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $couponLogic = new CouponLogic();
        $minPage = $this->argument('min');
        $minPage = intval($minPage) ? $minPage : 1;
        $maxPage = $this->argument('max');
        $maxPage = intval($maxPage) ? $maxPage : 2;

        echo date('Y-m-d H:i:s') . 'start_' . $this->description . '\n';
        // 按页数循环获取接口数据
        if ($maxPage > $minPage) {
            $arrCid = [
                1 => 'nvzhuang', 9 => 'nanzhuang', 5 => 'xiezi', 5 => 'xiangbao', 3 => 'meizhuang',
                3 => 'hufu', 4 => 'shenghuo', 4 => 'jujia', 6 => 'meishi', 10 => 'neiyi', 7 => 'yundong',
                8 => 'shuma', 2 => 'muying', 5 => 'peishi', 11 => 'chengren', 12 => 'chongwu',
            ];
            foreach ($arrCid as $cid => $strName) {
                for ($i = $minPage; $i <= $maxPage; $i++) {
                    $url = 'http://sem.ibantang.com/g/getCouponList?sort=0&price=0&catename=' . $strName . '&channel=31&pagesize=20&page=' . $i;
                    try {
                        $query = QueryList::Query($url, []);
                        $data = json_decode($query->html, true);
                        if ($data['data']) {
                            $couponLogic->dealibantang($data['data'], $cid);
                        }
                    } catch (\Exception $e) {
                        print $e->getMessage();
                        continue;
                    }
                    usleep(1000);
                }
                sleep(10);
            }
        }

        echo date('Y-m-d H:i:s') . $this->description . '\n';
    }
}