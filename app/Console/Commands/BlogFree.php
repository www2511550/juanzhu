<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class BlogFree extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:free';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update blog free info';

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
     * 更新博客免单信息
     * @return mixed
     */
    public function handle()
    {
        $url = 'http://dwz.2xb.cn/ljsjcj?page=1&pageSize=50';
        $data = json_decode(file_get_contents($url), true);
        $freeInfo = $data['data'] ?: [];
        $strBase = '<p style="text-align: left"><img class="ue-image" src="https://bd.juanzhuzhu.com/zb_users/upload/2021/01/202101211611237111679670.png" title="免单logo.png" alt="免单logo.png"/></p>
                <p><b style="color: palevioletred">'.date('m月d日').'0元免单活动已更新！！！</b>';
        $str = $strBase.'<br/><b>没抢到的小伙伴建议加微信：juanzhujike</b></p>';
        $strBaidu = $strBase.'</p>';  // 百度小程序禁止有诱导加人
        foreach ($freeInfo as $key=>$item) {
            $num = ++$key;
            $strBaidu .= ('<p>'.$num.'、'.$item['text'].'</p>');
            $str .= ('<p><a href="'.$item['url'].'" target="_blank">'.$num.'、'.$item['text'].$item['tkl'].'</a></p>');
        }

        // 百度小程序嵌套页面用口令
        DB::connection('baiduMysql')->table('post')->where('log_ID', 1)->update(['log_Content'=>$strBaidu, 'log_PostTime'=>time()]);
        // freeblog
        DB::connection('freeMysql')->table('post')->where('log_ID', 1)->update(['log_Content'=>$str, 'log_PostTime'=>time()]);
        echo date('Y-m-d H:i:s') . '_success_' . $this->description;
    }
}
