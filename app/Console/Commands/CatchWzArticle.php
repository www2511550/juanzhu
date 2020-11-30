<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2018/8/20
 * Time: 下午10:49
 */
namespace App\Console\Commands;

use App\Service\CatchAdsService;
use Illuminate\Console\Command;


class CatchWzArticle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'catch:wzArticle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '抓取网赚博客内容';

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

        for ($i=1; $i<=3; $i++){
            $catchAdsService->wz686_com_content($i);
        }


        echo date('Y-m-d H:i:s') . $this->description . '\n';
    }


}