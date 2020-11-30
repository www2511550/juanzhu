<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 17/6/27
 * Time: 下午10:17
 */
namespace App\Console\Commands;

use App\Model\ClickDetail;
use App\Model\User;
use Illuminate\Console\Command;
use DB;
class CountScoreDetail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'count:score_detail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'count score detail';

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
        $data = [];
        $clickData = ClickDetail::get();
        if ($clickData->toArray()) {
            // 积分明细统计
            foreach ($clickData as $vo) {
                $data[$vo->user_id][$vo->gid]++;
            }
            // 插入积分详细表
            foreach ($data as $user_id => $value){
                foreach ($value as $gid => $score){
                    $insertData['user_id'] = $user_id;
                    $insertData['score'] = $score;
                    $insertData['gid'] = $gid;
                    $insertData['status'] = 1;
                    $insertData['note'] = '分享返积分(商品编号:G'.$gid.')';
                    $insertData['created_at'] = $insertData['updated_at'] = date('Y-m-d H:i:s');
                    // 商品id
                    $record = DB::table('score_detail')->where('user_id', $user_id)->where('gid', $gid)->first();
                    if($record){
                        DB::table('score_detail')->where('user_id', $user_id)->where('gid', $gid)->update(['score'=>$score, 'updated_at'=>date('Y-m-d H:i:s')]);
                    }else{
                        DB::table('score_detail')->insert($insertData);
                    }
                }
            }
            // 更新会员积分
            $scoreData = DB::table('score_detail')->selectRaw('SUM(score) as total, user_id')->groupBy('user_id')->get();
            if($scoreData->toArray()){
                foreach ($scoreData as $vo){
                    User::where('id', $vo->user_id)->update(['score'=>$vo->total]);
                }
            }
        }
        echo  date('Y-m-d H:i:s').$this->description.'\n';
    }


}