<?php
/**
 * 好单库API
 * User: chengcong
 * Date: 2018/8/12
 * Time: 下午12:04
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CatchHaodanku extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coupon:haodanku';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'catch haodanku coupon';

    /**
     * Create a new command instance.
     *
     * @param  DripEmailer $drip
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->appKey = 'juanzhuzhu';
        $this->api_base = 'http://v2.api.haodanku.com';
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $url = $this->api_base.'/supersearch';

//        $url = $this->api_base.'/itemlist';
        $params = [
            'apikey' => $this->appKey,
            'cid' => '1',
            'back' => '10', // 每页条数
            'min_id' => 1,    // 页码
            'keyword' => urlencode(urlencode('女装')),    // 页码
        ];
        $result = http($url, $params);
        pre($result);die;
    }

}