<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CatchSalerData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'catch:salerData';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '抓取好单库，大淘客商家联系方式数据';

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
     *
     * @return mixed
     */
    public function handle()
    {
        for ($i=5; $i> 0;$i--){
            $this->perPage($i);
            sleep(5);
        }

        echo date('Y-m-d H:i:s') . $this->description . '\n';
    }

    /**
     * 单页数据抓取
     */
    public function perPage($page = 1)
    {
        // 好单库商家联系方式数据抓取
        $urlHaodankuIndex = 'https://www.haodanku.com/allitem/new_get_allitem_list?cid=0&sort=1&p=' . $page;
        $urlHaodankuDetail = 'https://www.haodanku.com/Team/seller_info?id=';
        $arrContextOptions = [ // 针对https配置
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ]
        ];
        $strFetch = @file_get_contents($urlHaodankuIndex, false, stream_context_create($arrContextOptions));
        $data = json_decode($strFetch, true);
        if ($data['item_info']) {
            foreach ($data['item_info'] as $value) {
                if (!$value['seller_id']) continue;
                usleep(5000);
                $strFetchDetail = @file_get_contents($urlHaodankuDetail . $value['seller_id'], false, stream_context_create($arrContextOptions));
                $fetchDetail = json_decode($strFetchDetail, true);
                if (isset($fetchDetail['data']) && $fetchDetail['data']) {
                    $strPtId = 'hdk_' . $value['seller_id'];
                    $objDb = DB::table('saler_data');
                    if ($objDb->where('pt_id', $strPtId)->count() > 0) continue;
                    $objDb->insert([
                        'pt_id' => $strPtId,
                        'name' => $fetchDetail['data']['stage_name'],
                        'intro' => $fetchDetail['data']['intro'],
                        'qq' => $fetchDetail['data']['qq'],
                        'head_img' => $fetchDetail['data']['head_img'],
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
        }
        return true;
    }
}
