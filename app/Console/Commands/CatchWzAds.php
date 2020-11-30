<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2018/4/21
 * Time: 下午3:49
 */
namespace App\Console\Commands;

use App\Service\CatchAdsService;
use Illuminate\Console\Command;


class CatchWzAds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'catch:wzAds';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '抓取网赚博客广告';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $catchAdsService = new CatchAdsService();

//        $catchAdsService->zicaitou_com();
//        sleep(0.5);
//        $catchAdsService->fububu_com();
//        sleep(0.5);
//        $catchAdsService->liuyingqiang_com();

        echo date('Y-m-d H:i:s') . $this->description . '\n';
    }
}