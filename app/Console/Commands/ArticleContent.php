<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2018/5/6
 * Time: 下午10:01
 */

namespace App\Console\Commands;

use App\Model\Article;
use App\Model\Dapei;
use App\Service\Catch7dapeiService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Cache;

class ArticleContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'article:content';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'catch article content';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        // 拆分去搭配网站抓取的数据
        $this->splice7dapeicom();


//        $catch7dapeiService = new Catch7dapeiService();
//        $data = Cache::remember('article1_' . date('Ymd'), 60, function () use ($catch7dapeiService) {
//            return $catch7dapeiService->index();
//        });
//        if ($data) {
//            foreach ($data as $val) {
//                $record = Article::where('title', $val['title'])->first();
//                if (!$record->id) {
//                    Article::insert([
//                        'goods_id' => $val['goods_id'],
//                        'title' => $val['title'],
//                        'daodu' => $val['daodu'],
//                        'cover' => $val['img'],
//                        'buy_url' => $val['buy'],
//                        'intro' => $val['intro'],
//                        'created_at' => date('Y-m-d H:i:s'),
//                    ]);
//                }
//            }
//        }
        echo date('Y-m-d H:i:s') . '_success!';
    }


    // 7dapei数据拆分
    public function splice7dapeicom()
    {
        Dapei::where('cate_name', '7dapei')->where('is_splice', 0)->chunkById(500, function ($data) {
            foreach ($data as $vo) {
                $arrCover = explode(',', $vo->cover);
                $content = $vo->content;
                $arrContent = json_decode($content, true);
                if (!$arrContent){
                    $content = trim(substr($content, 2, -2));
                    $arrContent = explode('", "', $content);
                }
                $title = $vo->title . '（2）';
                // 数据组装
                $update = [
                    'title' => $title,
                    'cover' => implode(',', array_splice($arrCover, 5)),
                    'browse_num' => rand(20, 50),
                    'cate_name' => $vo->cate_name,
                    'is_splice' => 1,
                    'content' => json_encode(array_splice($arrContent, 15)),
                    'intro' => $vo->intro,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
                if ($id = Dapei::where('title', $title)->value('id')) {
                    Dapei::where('id', $id)->update($update);
                } else {
                    if (false !== Dapei::insert($update)) {
                        Dapei::where('id', $vo->id)->update([
                            'content' => json_encode(array_splice($arrContent, 0, 14)),
                            'is_splice' => 1,
                        ]);
                    }
                }
            }
        });
    }
}