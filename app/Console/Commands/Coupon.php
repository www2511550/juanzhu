<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 17/4/30
 * Time: 下午3:20
 */
namespace App\Console\Commands;

use App\Logic\CouponLogic;
use Illuminate\Console\Command;

class Coupon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coupon:allweb {min} {max}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get allweb coupon';

    private $appKey;
    private $api_base;

    /**
     * Create a new command instance.
     *
     * @param  DripEmailer  $drip
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->appKey = '268977f5ba';
        $this->api_base = 'http://api.dataoke.com/index.php';
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // 删除过期优惠券
        \App\Model\Coupon::where('Quan_time', '<=', date('Y-m-d H:i:s'))->delete();

        $couponLogic = new CouponLogic();
        $minPage = $this->argument('min');
        $minPage = intval($minPage) ? $minPage : 0;
        $maxPage = $this->argument('max');
        $maxPage = intval($maxPage) ? $maxPage : 1;
        // 接口必备参数
        $params['r'] = 'Port/index';
        $params['type'] = 'total';
        $params['appkey'] = $this->appKey;
        $params['v'] = 2;

        echo date('Y-m-d H:i:s').'start_'.$this->description.'\n';
//        $taobaoLogic = new Taok();
        // 按页数循环获取接口数据
        for ( $i=$minPage; $i<=$maxPage; $i++){
            try{
                $params['page'] = $i;
                $arrData = http($this->api_base, $params);
                $data = json_decode($arrData, true);
                if( $data['result'] ){
                    $couponLogic->dealDataokeData($data['result']);
//                    $couponLogic->toJuanzhu($data['result']);
                }
            }catch (\Exception $e){
                pre($e->getMessage());
                continue;
            }
        }

        echo  date('Y-m-d H:i:s').$this->description.'\n';
    }
}