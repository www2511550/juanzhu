<?php
/**
 * Created by Chengcong.
 * Date: 2017/4/27 17:58
 */
namespace App\Home;
use App\Model\Wangzhuan;
use App\Model\WzDetail;
use QL\QueryList;

class QueryController extends BaseController
{

    public function index()
    {
        $hj = QueryList::Query(
            'http://sem.ibantang.com/g/getCouponList?sort=0&price=0&catename=nvzhuang&channel=31&page=1&pagesize=20', []);
        $data = $hj->getData(function ($x) {
            return $x['url'];
        });
        print_r($data);
        $this->catchHuimiaoWeb();
    }


    public function getCoupon(){

        $base_url = 'http://www.qingtaoke.com/?r=default/index&s_type=1&sort=1&scroll_id=cXVlcnlUaGVuRmV0Y2g7NTs4MjkzODMyNTM6TGtZcEI5M2FRYjZkdERyUmF3WjFEdzs3MjE2MjYyNTc6a3Nxc0pSSGhTdWFXblVDVEtJLWhTUTs3NjEzNTExOTQ6UXVVTktVbWtTaVNac2RqWk83Y0dVQTs4MDc3MTY5NzA6TC1Xdy1lMy1RQi1LY3I2WERadm9TQTs4MjkzODMyNTQ6TGtZcEI5M2FRYjZkdERyUmF3WjFEdzswOw%3D%3D&cat=0';
        //采集某优惠卷的链接
        for ( $i=1; $i<10; $i++ ) {
            $urls[] = $base_url.'&page='.$i;
        }

        //多线程扩展
        QueryList::run('Multi',[
            'list' => $urls,
            'curl' => [
                'opt' => array(
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_AUTOREFERER => true,
                ),
                //设置线程数
                'maxThread' => 100,
                //设置最大尝试数
                'maxTry' => 3
            ],
            'success' => function($a){
                $this->catchQingTaoKe($a['info']['url']);
                //打印结果，实际操作中这里应该做入数据库操作
            }
        ]);
    }


    public function test()
    {
        for ($i=1; $i++; $i<=12){
            $url = 'http://www.woyaowz.net/page_'.$i.'.html';
            $this->woyaowz_net($url);die('test');
        }
        echo 'finish';

    }


    /**
     * 采集www.woyaowz.net内容
     * author chengcong
     */
    public function woyaowz_net($url)
    {
        if (!$url) return;

        $data = QueryList::Query($url, [
            'title' => ['.list>li>h2>a', 'title'],
            'href' => ['.list>li>h2>a', 'href'],
            'content' => ['.list>li>p', 'text'],
            'cover' => ['.list>li>p>a>img', 'src'],
            'time' => ['li>small>span:eq(0)', 'text'],
        ])->getData();
        if ($data) {
            foreach ($data as $val) {
                $record = Wangzhuan::where('title', $val['title'])->where('href', $val['href'])->first();
                if (!$record->id) {
                    $intro = strip_tags($val['content']);
                    $intro = mb_substr($intro, 0, 50);
                    $insertId = Wangzhuan::insertGetId(
                        [
                            'title' => $val['title'],
                            'href' => $val['href'],
                            'cover' => $val['cover'] ?: '',
                            'intro' => $intro ?: '',
                            'browse_num' => rand(20, 100),
                            'created_at' => date('Y-m-d H:i', strtotime('-1 day'))
                        ]
                    );
                    if ($insertId > 0) {
                        WzDetail::insert(['wz_id'=>$insertId,'content' => $this->getDetailByUrl($val['href'])]);
                    }
                }
            }
        }
    }
    /**
     * 获取内容
     * @param $url
     * @return string
     * author chengcong
     */
    public function getDetailByUrl($url)
    {
        if ($url) {
            sleep(0.5);
            $content = QueryList::Query($url, [
                'detail' => ['.info-zi', 'html'],
            ])->getData();
        }
        return $content[0]['detail'] ?: '';
    }


}