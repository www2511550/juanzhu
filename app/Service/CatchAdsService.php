<?php
/**
 * 抓取网赚博客广告
 * User: chengcong
 * Date: 2018/4/21
 * Time: 上午11:43
 */
namespace App\Service;
use App\Model\Wangzhuan;
use App\Model\WzAds;
use App\Model\WzDetail;
use QL\QueryList;
use Cache;
use Storage;

class CatchAdsService
{
    /**
     * http://www.zicaitou.com/ 紫菜头广告页面抓取
     */
    public function zicaitou_com()
    {
//        Cache::forget('zicaitou_com');
        $data = Cache::remember('zicaitou_com', 30, function (){
            $url = 'http://www.zicaitou.com';
            return QueryList::Query($url, [
                'title' => ['.topic-content>.post-title>h2>a', 'text'],
                'href' => ['.topic-content>.post-title>h2>a', 'href'],
                // 右侧
                'r_title' => ['dl.recent-posts>dt>div>a>img', 'title'],
                'r_href' => ['dl.recent-posts>dt>div>a', 'href'],
            ])->getData();
        });

        if ($data){
            foreach ($data as $val){
                if (false === strpos($val['title'], '[广告]')) continue;
                $insert = [
                    'cate_name' => '紫菜头',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                $record = WzAds::where('href', $val['href'])->first();
                if (!$record->id){
                    WzAds::insert(array_merge($insert, ['title' => $val['title'],'href' => $val['href']]));
                }
                // 右侧广告
                $r_record = WzAds::where('href', $val['r_href'])->first();
                if (!$r_record->id){
                    WzAds::insert(array_merge($insert, ['title' => $val['r_title'],'href' => $val['r_href']]));
                }
            }
        }
        // pree($data);
    }

    /**
     * http://www.fububu.com/ 不不博客广告页面抓取
     */
    public function fububu_com()
    {
//        Cache::forget('fububu_com');
        $data = Cache::remember('fububu_com', 30, function (){
            $url = 'http://www.fububu.com/zb_system/function/c_html_js.asp?act=batch&view=spn2238%3D2238%2Cspn2237%3D2237%2Cspn2236%3D2236%2Cspn2235%3D2235%2Cspn2234%3D2234%2Cspn2233%3D2233%2Cspn2232%3D2232%2Cspn2231%3D2231%2Cspn2230%3D2230%2Cspn2229%3D2229%2Cspn2228%3D2228%2Cspn2227%3D2227%2Cspn2226%3D2226%2Cspn2225%3D2225%2Cspn2224%3D2224%2C&inculde=mod_function118%3Dfunction118%2Cmod_function92%3Dfunction92%2Cmod_function128%3Dfunction128%2Cmod_function80%3Dfunction80%2Cmod_function127%3Dfunction127%2Cmod_function119%3Dfunction119%2Cmod_function130%3Dfunction130%2Cmod_function120%3Dfunction120%2Cmod_function121%3Dfunction121%2C&count=&_=1524294387211';
            return QueryList::Query($url, [
                'title' => ['a', 'text'],
                'href' => ['a', 'href'],
            ])->getData();
        });

        if ($data){
            foreach ($data as $key => $val){
                $strHref = substr($val['href'], 4, -4);
                $insert = [
                    'title' => '广告——'.$key,
                    'cate_name' => '不不博客',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                $record = WzAds::where('href', $strHref)->first();
                if (!$record->id){
                    WzAds::insert(array_merge($insert, ['href' => $strHref]));
                }
            }
        }
        // pree($data);
    }

    /**
     * http://www.liuyingqiang.com/ 起点博客广告抓取
     */
    public function liuyingqiang_com()
    {
//        Cache::forget('liuyingqiang_com');
        $data = Cache::remember('liuyingqiang_com', 30, function (){
            $url = 'http://www.liuyingqiang.com/';
            return QueryList::Query($url, [
                'title' => ['.reed>h2>a', 'text'],
                'href' => ['.reed>h2>a', 'href'],
                'span' => ['.reed>h2>span', 'text'],
            ])->getData();
        });

        if ($data){
            foreach ($data as $val){
                if ($val['span'] != '置顶') continue;
                $insert = [
                    'title' => $val['title'],
                    'href' => $val['href'],
                    'cate_name' => '起点博客',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                $record = WzAds::where('href', $val['href'])->first();
                if (!$record->id){
                    WzAds::insert($insert);
                }
            }
        }
        // pree($data);
    }


    /**
     * 686网赚_博客内容抓取
     */
    public function wz686_com_content($page=1)
    {
        $page = $page ?: 1;
        $url = 'http://www.686wz.com/wzxm/' . (1 == $page ? '' : 'index_' . $page . '.html');
        $data = Cache::remember('wz686_com_content_'.$page, 30, function () use($url) {
            return QueryList::Query($url, [
                'title' => ['.lists>li>a', 'text'],
                'href' => ['.lists>li>a', 'href'],
            ])->getData();
        });

        if ($data) {
            foreach ($data as $val) {
                $record = Wangzhuan::where('title', $val['title'])->where('href', $val['href'])->first();
                if (!$record->id) {
                    // 获取内容链接的内容详情
                    $arr_content_info = $this->getDetailByUrl($val['href']);
                    $intro = $arr_content_info['intro'] ?: '';
                    $cover = '';//$this->saveCoverToLocal($val['cover']);

                    $insertId = Wangzhuan::insertGetId(
                        [
                            'title' => $val['title'],
                            'href' => $val['href'],
                            'status' => 2,
                            'cover' => $cover ?: '',
                            'intro' => $intro ?: '',
                            'browse_num' => $val['browse_num'] ? (int)$val['browse_num']: rand(20, 100),
                            'created_at' => $val['time'] ?: date('Y-m-d H:i')
                        ]
                    );
                    if ($insertId > 0) {
                        WzDetail::insert(['wz_id'=>$insertId,'content' => $arr_content_info['content']]);
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
        $data = [];
        if ($url) {
            sleep(0.5);
            $content = QueryList::Query($url, [
                'detail' => ['.context', 'html'],
                'first' => ['.context>p:eq(0)', 'text'],
            ])->getData();
            $data = [
                'content' => $content[0]['detail'],
                'intro' => $content[0]['first'] ? mb_substr($content[0]['first'], 0, 100, 'utf8') : '',
            ];
        }
        return $data;
    }

    public function saveCoverToLocal($url)
    {
        if ($url){
            $file_name = time().rand(1000,9999).'.jpg';
            $cover_url = '/blog/cover/'.$file_name;
            Storage::disk('blog')->put('/cover/'.$file_name, file_get_contents($url));
        }
        return $cover_url ?: '';
    }

}