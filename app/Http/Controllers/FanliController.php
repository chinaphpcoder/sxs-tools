<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Libraries\Classes\TransferCode;
use App\Libraries\Classes\HttpClient;


class FanliController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function index(Request $request) {
        try{
            $db = DB::connection('mysql_main');
            $datas = array();
            do {
                $sql = "select id,user_id,u_id,order_id,order_time,tracking_code,tracking_id,action_time,real_pay_fee,time_limit,isback,backstatus,register_time from `vault_campaign_fanliwang` order by id desc limit 200 ";
                $rows = $db->select($sql);
                if( count($rows) <= 0 )
                {
                    continue;
                }
                $count = 0;
                $user_ids = array();
                foreach ($rows as $keys => $values) {
                    foreach ($values as $key => $value) {
                        $datas[$count][$key] = $value;
                        if( $key == 'user_id') {
                            $user_ids[] = $value;
                        }
                    }
                    $count++;
                }
                $user_ids = array_unique($user_ids);
                $user_ids = implode(",",$user_ids);
                $sql = "select * from `vault_user` where id in ( {$user_ids} )";
                $rows = $db->select($sql);
                $users = array();
                foreach ($rows as $key => $value) {
                    $users[$value['id']]['real_name'] = $value['real_name'];
                }
                foreach ($datas as $key => $value) {
                    $datas[$key]['real_name'] = $users[$value['user_id']]['real_name'];
                }

            }while (0) ;
        } catch(Exception $e) {
            echo $e->getMessage();

        } finally {
            var_dump($datas);
            return view('fanli', compact('datas'));
        }
        
    }

}
