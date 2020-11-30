<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 17/5/18
 * Time: 下午11:10
 */
namespace App\Console\Commands;

use App\Logic\CouponLogic;
use Illuminate\Console\Command;
class CatchHuiMiao extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coupon:huimiao {min} {max}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'catch huimiao coupon';

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
        // 接口必备参数
        $base_url = 'http://m.huim.com/ajax/getmiaoquan';

        echo date('Y-m-d H:i:s').'start_'.$this->description.'\n';
        // 按页数循环获取接口数据
        for ( $i=$minPage; $i<=$maxPage; $i++){
            try{
                $params['p'] = $i;
                $arrData = http($base_url, $params);
                $data = json_decode($arrData, true);
                if( $data['data']){
                    $couponLogic->dealHuiMiaoData($data['data']);
                }
            }catch (\Exception $e){
                print $e->getMessage();
                continue;
            }
        }

        echo  date('Y-m-d H:i:s').$this->description.'\n';
    }


}