<?php

namespace App\Jobs;

use App\Logic\WeiboLogic;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use DB;

class NewsQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $weiboLogic = new WeiboLogic();
        // 微博内容
        $news = DB::table('wb_news')->where('is_send', 0)->orderBy('created_at', 'asc')->orderBy('id', 'desc')->first();
        if ($news->id) {
            $content = '【'.$news->title.'】#娱乐八卦#'.trim($news->intro);
            // 抓取图片存到本地
            $img = '';//$this->getImgByUrl($news->cover);
            $to_url = $news->url;

            return $weiboLogic->sendWeiboNews($content, $img, $to_url, $news->id);
        }
        return 'no-news';
    }

    /**
     * 通过url获取图片到本地
     * @param $url
     */
    public function getImgByUrl($url, $img_name = '1.jpg')
    {
        // 新浪微博图片
        0 !== strpos($url, 'http') && $url = 'http:' . $url;
        $url = 'http://s.img.mix.sina.com.cn/auto/resize?img=' . $url . '&size=300_200';

        $imgContent = @file_get_contents($url);
        file_put_contents($img_name, $imgContent);
        return $img_name;
    }
}
