<?php
/**
 * 百度收录-链接主动提交
 * User: chengcong
 * Date: 2018/7/15
 * Time: 下午8:51
 */
namespace App\Console\Commands;

use App\Model\Dapei;
use Illuminate\Console\Command;

class DapeiPostBaidu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dapei:postBaidu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'dapei post baidu';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $this->add();

        $this->update();
        
//        $data = Dapei::select('id', 'is_send_baidu')->get();
//        $urls[] = 'http://2dapei.com.cn';
//        foreach ($data as $vo) {
//            $urls[] = 'http://2dapei.com.cn/detail/' . $vo->id . '.html';
//        }
//        $api = 'http://data.zz.baidu.com/update?site=2dapei.com.cn&token=9DhmfM4Vt2kSYfrl'; // 更新
////        $api = 'http://data.zz.baidu.com/urls?site=2dapei.com.cn&token=9DhmfM4Vt2kSYfrl'; // 提交
//        $ch = curl_init();
//        $options = array(
//            CURLOPT_URL => $api,
//            CURLOPT_POST => true,
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_POSTFIELDS => implode("\n", $urls),
//            CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
//        );
//        curl_setopt_array($ch, $options);
//        $result = curl_exec($ch);
//        pre($result);
    }

    /**
     * 新增url
     */
    public function add()
    {
        $data = Dapei::select('id', 'is_send_baidu')->where('created_at','>', date('Y-m-d 00:00:00'))->get();
        $urls[] = 'http://2dapei.com.cn';
        foreach ($data as $vo) {
            $urls[] = 'http://2dapei.com.cn/detail/' . $vo->id . '.html';
        }

        $api = 'http://data.zz.baidu.com/urls?site=2dapei.com.cn&token=9DhmfM4Vt2kSYfrl'; // 提交
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
        pre($result);
    }

    /**
     * url更新
     */
    public function update()
    {
        $data = Dapei::select('id', 'is_send_baidu')->where('created_at','<', date('Y-m-d 00:00:00'))->get();
        $urls[] = 'http://2dapei.com.cn';
        foreach ($data as $vo) {
            $urls[] = 'http://2dapei.com.cn/detail/' . $vo->id . '.html';
        }
        $api = 'http://data.zz.baidu.com/update?site=2dapei.com.cn&token=9DhmfM4Vt2kSYfrl'; // 更新
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
        pre($result);
    }

}