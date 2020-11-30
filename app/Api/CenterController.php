<?php
/**
 * Created by PhpStorm.
 * User: chengcong
 * Date: 2017/9/28
 * Time: 下午9:33
 */
namespace App\Api;

use App\Model\Message;
use Illuminate\Http\Request;

class CenterController extends BaseController
{
    /**
     * 消息列表
     * @param Request $request
     */
    public function msgList(Request $request)
    {
        $data = ['status'=>1, 'info'=>'', 'data' =>[]];
        $user_id = intval($request->get('user_id'));

        $arrMessage = Message::whereIn('user_id', [0, $user_id])->where('status', 1)->orderBy('created_at', 'desc')->get();
        if(count($arrMessage) > 0){
            foreach ($arrMessage as $message){
                $data['data'][] = $message->formatMsgList($message);
            }
        }

        return response()->json($data);
    }



}