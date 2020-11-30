<?php
/**
 * Created by Chengcong.
 * Date: 2017/5/23 12:56
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
        $base_url = 'http://m.ibantang.com/zhekou/getZhekouListByCate';
        $params['pagesize'] = 20;
        $params['cate'] = 47;
        $params['sort'] = 0;
        $params['channel'] = 35;

        echo date('Y-m-d H:i:s').'start_'.$this->description.'\n';
        for ( $i=$minPage; $i<=$maxPage; $i++){
            try{
                $params['page'] = $i;
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