<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;
use AliyunMNS\Client;
use AliyunMNS\Requests\PublishMessageRequest;
use AliyunMNS\Exception\MnsException;

class MnsController extends BaseController
{
    public function push(){
         return view('mns.push');
    }

    public function push_server(Request $request) {
        $message = $request->input('message');

        $appkey = config("mns.appkey");
        $appsecret = config("mns.appsecret");

        if( $appkey == "" ) {
            echo "appkey not config";
            return;
        }

        if( $appsecret == "" ) {
            echo "appsecret not config";
            return;
        }

        $sort_arr['appkey'] = $appkey;
        $sort_arr['timestamp'] = time();
        $sort_arr['nonce'] = gen_rand_string(10);
        $sort_arr['req_data'] = $message;
        $sort_arr['service_name'] = 'WITHDRAW';

        ksort($sort_arr,SORT_STRING);
        $str = '';
        foreach ($sort_arr as $key => $value) {
            $str .= '&'.$key.'='.$value ;
        }
        $str = trim($str,'&');
        $str = $appsecret.$str.$appsecret;
        $sign = sha1($str);

        $sort_arr['sign'] = $sign;
        $message_body = json_encode($sort_arr);
        echo $message_body;
        echo "<br>";
        $status = $this->push_message($message_body);
        if($status === true) {
            echo "消息推送成功";
        } else {
            echo "消息推送失败";
        }
    }
    private function push_message($message){

        try{
            $topicName = config("mns.queue_name");
            $endPoint = config("mns.end_point");
            $accessId = config("mns.access_id");
            $accessKey = config("mns.access_key");

            $client = new Client($endPoint, $accessId, $accessKey);

            $topic = $client->getTopicRef($topicName);

            // 3. send message
            $messageBody = $message;
            // as the messageBody will be automatically encoded
            // the MD5 is calculated for the encoded body
            $bodyMD5 = md5(base64_encode($messageBody));
            $request = new PublishMessageRequest($messageBody);

            $res = $topic->publishMessage($request);
            return true;

        } catch(MnsException $e) {
            Log::error('mns exception',['exception' => $e->getMessage()]);
            return false;
        }
    }
}