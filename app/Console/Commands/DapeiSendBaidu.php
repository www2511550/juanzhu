<?php
/**
 * 百度收录-百家号
 * User: chengcong
 * Date: 2018/7/15
 * Time: 下午8:51
 */
namespace App\Console\Commands;

use App\Jobs\TestQueue;
use App\Model\Dapei;
use App\Model\Wangzhuan;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;


class DapeiSendBaidu extends Command
{
    use DispatchesJobs;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dapei:sendBaidu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'dapei send baidu';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
//        $jobs = (new TestQueue('hhahah'))->delay(5);
//        $this->dispatch($jobs);
//        die('aaa');


        $data = Dapei::select('id', 'is_send_baidu')->where('is_send_baidu', 0)->orderByRaw('rand()')->take(10)->get();
        if ($data->toArray()) {
            $total = 0;
            foreach ($data as $vo) {
                $urls[] = 'http://2dapei.com.cn/detail/' . $vo->id . '.html';
                // 提交百度
                $result = $this->toBaidu($urls);
                if ($result['success_realtime'] > 0) {
                    $vo->is_send_baidu = 1;
                    if (false !== $vo->save()) $total++;
                }
            }
            echo 'success-' . $total . '-record';
        } else {
            echo 'no-data'; 
        }
    }

    /**
     * 提交百度收录
     * @param $urls
     * @return mixed
     * @author cc 2018/9/11 9:34
     */
    public function toBaidu($urls)
    {
        $api = 'http://data.zz.baidu.com/urls?appid=1596378598439271&token=VGfLOKaInGbdgjDv&type=realtime';
        $ch = curl_init();
        $options = array(
            CURLOPT_URL => $api,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => implode("\n", $urls),
            CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        return json_decode($result, true);
    }
}