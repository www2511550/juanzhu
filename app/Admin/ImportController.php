<?php
/**
 *
 * exel表格导入类
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2017/11/14
 * Time: 下午9:40
 */
namespace App\Admin;

use App\Model\TbOrder;
use App\Model\User;
use App\Service\ExcelService;
use Illuminate\Http\Request;

class ImportController extends AdminBaseController
{

    /**
     * 淘宝订单导入
     */
    public function tbInto()
    {
        $fileName = $_FILES['file']['tmp_name'];
        if (!$fileName) {
            return view('admin.import.tbInto');
        } else {

            $excelData = ExcelService::getExcelData($fileName);
            if ( count($excelData)<1 ){
                $this->error('上传文件为空！');
            }

            $update_num = $succ = $error = 0;
            foreach ($excelData as $value) {
                $pid = 'mm_47800736_'.$value['26'].'_'.$value['28'];
                $record = TbOrder::where('order_num', $value[24])->first();

                // 组装数据
                $data['order_num'] = $value[24];
                $data['money'] = $value[13];
                $data['now_price'] = $value[12];
                $data['status'] = !$value[12] ? 2 : 1;
                $data['title'] = $value[2];
                $data['shop'] = $value[5];
                $data['g_time'] = $value[0];
                $user_id = User::where('pid', $pid)->value('id');
                $data['user_id'] = $user_id ?: 0;
                $data['reward'] = $data['money']*0.65;

                // 更新或增加
                if($record->id){
                    $status = TbOrder::where('id', $record->id)->update($data);
                    false === $status ? ++$error : ++$update_num;
                }else{
                    $status = TbOrder::insert($data);
                    false === $status ? ++$error : ++$succ;
                }


            }
            $msg = "成功".$succ."条，失败".$error."条，更新了".$update_num."条！";
            return $this->success($msg);


        }
    }

    /**
     * 淘宝订单列表
     * @param Request $request
     */
    public function tbOrder(Request $request)
    {
        $arrTbOrder = TbOrder::orderBy('g_time', 'desc')->paginate(20);
        if(count($arrTbOrder)>0){
            foreach ($arrTbOrder as $order){
                $data['data'][] = $order->formatOrderList($order);
            }
        }
        $data['page'] = $arrTbOrder->render();

        return view('admin.import.tbOrder', $data);
    }


}