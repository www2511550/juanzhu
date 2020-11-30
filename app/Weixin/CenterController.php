<?php
/**
 * 个人中心
 * Created by PhpStorm.
 * User: xixi
 * Date: 2018/3/20
 * Time: 下午11:14
 */
namespace App\Weixin;

use Illuminate\Http\Request;
use App\Model\Wxinfo;

class CenterController
{

    /**
     * 个人红包明细
     */
    public function detail(Request $request)
    {
        $openid_md5 = $request->get('mid');
        $wxinfo = Wxinfo::where('openid_md5', $openid_md5)->first();

        return view('weixin.index.detail', ['info' => $wxinfo]);
    }


}