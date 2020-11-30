<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 17/7/2
 * Time: 下午8:35
 */
namespace App\Console\Commands;

use App\Logic\TaobaoLogic;
use Illuminate\Console\Command;
use DB;
class ScoreShop extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'catch:score_shop';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'catch score shop data';

    /**
     * Create a new command instance.
     *
     * @param  DripEmailer $drip
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
        $taobaoLogic = new TaobaoLogic();
        $arrFavoritesId = ['7624047'];
        foreach ($arrFavoritesId as $fid){
            for ($page = 1; $page<3; $page++){
                $data = $taobaoLogic->selectGoods($page, 100, $fid);
                foreach ($data as $val){
                    $record = DB::table('score_shop')->where('gid', $val['gid'])->first();
                    if($record) continue;
                    $insertData['title'] = $val['title'];
                    $insertData['url'] = $val['url'];
                    $insertData['score'] = ($val['price']+3)*10;
                    $insertData['gid'] = $val['gid'];
                    $insertData['pic_url'] = $val['pic_url'];
                    $insertData['type'] = $val['type'];
                    $insertData['sale_num'] = $val['sale_num'];
                    $insertData['start_time'] = $val['start_time'];
                    $insertData['end_time'] = $val['end_time'];
                    $insertData['created_at'] = $insertData['updated_at'] = date('Y-m-d H:i:s');
                    DB::table('score_shop')->insert($insertData);
                }
            }
        }

        echo  date('Y-m-d H:i:s').$this->description.'\n';
    }

}