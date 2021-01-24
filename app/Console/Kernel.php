<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Coupon::class,
        \App\Console\Commands\CatchHuiMiao::class,
        \App\Console\Commands\CountScoreDetail::class,
        \App\Console\Commands\ScoreShop::class,
        \App\Console\Commands\CatchIbantang::class,
        \App\Console\Commands\SendWeiBo::class,
        \App\Console\Commands\CatchWzAds::class,
        \App\Console\Commands\PostBaidu::class,
        \App\Console\Commands\ArticleContent::class,
        \App\Console\Commands\DapeiMake::class,
        \App\Console\Commands\DapeiSendBaidu::class,
        \App\Console\Commands\DapeiPostBaidu::class,
        \App\Console\Commands\DapeiBaiduYuanChuang::class,
//        \App\Console\Commands\CatchHaodanku::class,
        \App\Console\Commands\CatchWzArticle::class,
        \App\Console\Commands\CatchSalerData::class,
        \App\Console\Commands\BlogFree::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $filePath = 'storage/logs/crontab-'.date('Y-m-d').'.txt';

        // 微博优惠券发送，12分钟一次
        //$schedule->command('weibo:send')->everyThirtyMinutes()->withoutOverlapping()->appendOutputTo($filePath);

        // 会员积分
        $schedule->command('blog:free')->everyMinute()->between('6:00','20:00')->withoutOverlapping()->appendOutputTo($filePath);

        // 执行allweb接口
        $schedule->command('coupon:allweb 1 40')->hourly()->withoutOverlapping()->appendOutputTo($filePath);
        $schedule->command('coupon:allweb 41 80')->hourly()->withoutOverlapping()->appendOutputTo($filePath);
        $schedule->command('coupon:allweb 81 120')->hourly()->withoutOverlapping()->appendOutputTo($filePath);
        $schedule->command('coupon:allweb 121 160')->hourly()->withoutOverlapping()->appendOutputTo($filePath);
        // 抓取惠喵api接口数据
        //$schedule->command('coupon:huimiao 1 60')->hourly()->withoutOverlapping()->appendOutputTo($filePath);
        //$schedule->command('coupon:huimiao 61 120')->hourly()->withoutOverlapping()->appendOutputTo($filePath);
        //$schedule->command('coupon:huimiao 121 180')->hourly()->withoutOverlapping()->appendOutputTo($filePath);

        // 积分商城
        $schedule->command('catch:score_shop')->twiceDaily(7, 23)->withoutOverlapping()->appendOutputTo($filePath);

        // 抓取省钱快报数据
        $schedule->command('coupon:ibantang 1 7')->twiceDaily(6, 12)->withoutOverlapping()->appendOutputTo($filePath);
        $schedule->command('coupon:ibantang 8 16')->twiceDaily(10, 15)->withoutOverlapping()->appendOutputTo($filePath);

        $schedule->command('coupon:ibantang 8 16')->dailyAt('6:00')->withoutOverlapping()->appendOutputTo($filePath);


        // 站点提交
        $schedule->command('post:baidu')->dailyAt('5:00')->withoutOverlapping()->appendOutputTo($filePath);

        // 7dapei.com 每天十点抓取
         $schedule->command('article:content')->hourly()->withoutOverlapping()->appendOutputTo($filePath);
        // $schedule->command('catch:wzAds')->dailyAt('10:00')->withoutOverlapping()->appendOutputTo($filePath);

        // 穿衣搭配
        $schedule->command('dapei:sendBaidu')->dailyAt('1:00')->withoutOverlapping()->appendOutputTo($filePath);
        $schedule->command('dapei:make')->dailyAt('9:35')->withoutOverlapping()->appendOutputTo($filePath);
        $schedule->command('dapei:postBaidu')->dailyAt('7:00')->withoutOverlapping()->appendOutputTo($filePath);

        // 微博定时发送
        $schedule->command('weibo:send')->cron('*/25 7-23,1 * * *')->withoutOverlapping()->appendOutputTo($filePath);

        // 每天7：40抓去淘客网站商家信息
        $schedule->command('catch:salerData')->dailyAt('7:40')->withoutOverlapping()->appendOutputTo($filePath);

    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
