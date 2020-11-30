<?php
/**
 * 站点提交
 * User: chengcong
 * Date: 2018/5/1
 * Time: 下午12:46
 */
namespace App\Console\Commands;

use App\Logic\IndexLogic;
use App\Model\Article;
use App\Model\Category;
use App\Model\Wangzhuan;
use Illuminate\Console\Command;

class PostBaidu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'post:baidu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'post site to baidu';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->blog_juanzhuzhu();

        $this->juanzhuzhu();
    }

    /**
     * http://juanzhuzhu.com 站点提交
     */
    public function juanzhuzhu()
    {
        $baseUrl = 'http://www.juanzhuzhu.com';
        $site = 'www.juanzhuzhu.com';
        $token = 'VcLLI20SxcsfTq8v';
        // 首页和分类
        $arrUrl = ['http://www.juanzhuzhu.com'];
        $arrCate = Category::where('status', 1)->get();
        foreach($arrCate as $cate){
            $arrUrl[] = $baseUrl.'/?cid='.$cate->id;
        }
        $this->submit($arrUrl, $token, $site);

        // 详细页
        \App\Model\Coupon::select('id')->where('Quan_time', '>=', date('Y-m-d H:i:s'))->chunkById(100, function ($data) use ($baseUrl, $site, $token) {
            foreach ($data as $vo) {
                $urls[] = $baseUrl . '/home/index/detail/' . $vo->id . '.html';
            }
            $this->submit($urls, $token, $site);
        });

        // 开箱文
        $this->submit([$baseUrl.'/article'], $token, $site);
        Article::select('id')->chunkById(100, function ($data) use ($baseUrl, $site, $token) {
            foreach ($data as $vo) {
                $urls[] = $baseUrl . '/article/detail/' . $vo->id .'.html';
            }
            $this->submit($urls, $token, $site);
        });

        $indexLogic = new IndexLogic();
        $search = $indexLogic->searchList(['kw' => '夏季 女装', 'page'=>1]);
        if ($search['ids']){
            foreach ($search['ids'] as $id){
                $arrUrl[] = $baseUrl . '/article/detail/' . $id .'.html';
            }
            $this->submit($arrUrl, $token, $site);

            $total_page = ceil($search['total']/24);
            !$total_page && $total_page = 3;
            for ($i=2; $i++; $i<=$total_page){
                $search = $indexLogic->searchList(['kw' => '夏季 女装', 'page'=>$i]);
                foreach ($search['ids'] as $id){
                    $arrUrls[] = $baseUrl . '/article/detail/' . $id .'.html';
                }
                $this->submit($arrUrl, $token, $site);
            }
        }

    }

    /**
     * http://blog.juanzhuzhu.com 站点提交
     */
    public function blog_juanzhuzhu(){
        $baseUrl = 'http://blog.juanzhuzhu.com';
        $site = 'blog.juanzhuzhu.com';
        $token = 'VcLLI20SxcsfTq8v';
        // 首页
        $arrUrl = ['http://blog.juanzhuzhu.com'];
        // 首页分页
        $page_total = ceil(Wangzhuan::count()/12)+1;
        while ($page_total-- > 1){
            $arrUrl[] = $baseUrl . '?page='.$page_total;
        }
        $this->submit($arrUrl, $token, $site);

        // 详细页
        Wangzhuan::select('id')->chunkById(100, function ($data) use ($baseUrl, $site, $token) {
            foreach ($data as $vo) {
                $urls[] = $baseUrl . '/detail/'.$vo->id.'.html';
            }
            $this->submit($urls, $token, $site);
        });
    }

    /**
     * @param $urls   []
     * @param $token
     * @param $site   www.juanzhuzhu.com
     */
    public function submit($urls, $token, $site)
    {
        $api = 'http://data.zz.baidu.com/urls?site='.$site.'&token='.$token;
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
        echo $result;
    }

}