<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2017/11/14
 * Time: 下午10:08
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TbOrder extends Model
{
    /**
     * 与模型关联的数据表。
     * @var string
     */
    protected $table = 'tborder';

    /**
     * 指定是否模型应该被戳记时间。
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 格式化订单列表
     * @param $order
     */
    public function formatOrderList($order)
    {
        $data = [];
        if($order->id){
            $arrStatus = [1=>'有效订单', 2=>'失效订单', 3=>'已提现'];
            $data['g_time'] = $order->g_time;
            $data['order_num'] = $order->order_num;
            $data['title'] = $order->title;
            $data['price'] = $order->now_price;
            $data['status'] = $arrStatus[$order->status];
            $data['intStatus'] = $order->status;
            $user =  User::find($order->user_id);
            $data['username'] = $user->username;
            $data['uid'] = $user->id;
            $data['money'] = $order->money;
            $data['reward'] = $order->reward;
            $data['rate'] = $order->money <= 0 ? 0.00.'%' : (round($order->reward/$order->now_price,4)*100).'%';
        }

        return $data;
    }

}