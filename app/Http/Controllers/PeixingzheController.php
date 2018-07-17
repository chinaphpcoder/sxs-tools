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


class PeixingzheController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    function info(Request $request){ 
        try{
            $order_id = $request->input('orderid');
            $db = DB::connection('mysql_main');

            $where = "where o.order_id = '{$order_id}'";

            //用户信息
            $sql = "SELECT o.order_id,o.start_time,o.status,o.reg_status,o.user_id,u.real_name,u.idcard_no,u.mobile,u.ca_customer_id,u.creat_time,u.ca_status FROM vault_order_peixingzhe as o left join vault_user as u on o.user_id = u.id  {$where} limit 1";

            //用户信息
           // $sql = "SELECT * FROM vault_user {$where} order by id desc limit 100";
            $rows = $db->select($sql);
            if( count($rows) <= 0 )
            {
                exit("陪行者订单不存在，请联系技术人员！");
            } elseif ( count($rows) > 1 )
            {
                exit("查询出错，请联系技术人员！");
            }

            $value = @$rows[0];

            $regs = array();
            $regs[1] = '已注册';
            $regs[2] = '未注册';

            $status = array();
            $status[1] = '有效';
            $status[2] = '失效';

            $castatus = array();
            $castatus[0] = '未开通';
            $castatus[1] = '处理中';
            $castatus[2] = '开通成功';
            $castatus[3] = '开通失败';
            if($value->user_id == 0) {
                $value->user_id = null;
            }
            if( $value->ca_status == null) {
                $cas = null;
            } else {
                $cas = $castatus[$value->ca_status];
            }

            echo "<table class=\"table table-striped\">";
            echo    "<thead>
                        <tr>
                            <th>订单号</th>
                            <th>订单时间</th>
                            <th>订单状态</th>
                            <th>是否已注册</th>
                            <th>用户id</th>
                        </tr>
                    </thead>";
             echo    "<tr class=\"success\">
                         <td>{$value->order_id}</td>
                         <td>{$value->start_time}</td>
                         <td>{$status[$value->status]}</td>
                         <td>{$regs[$value->reg_status]}</td>
                         <td>{$value->user_id}</td>

                    </tr>";
            echo    "<thead>
                        <tr>
                            <th>用户姓名</th>
                            <th>手机号</th>
                            <th>身份证号</th>
                            <th>注册时间</th>
                            <th>CA状态</th>
                        </tr>
                    </thead>";
            $id = id_hide($value->idcard_no);
             echo    "<tr class=\"success\">
                         <td>{$value->real_name}</td>
                         <td>{$value->mobile}</td>
                         <td>{$id}</td>
                         <td>{$value->creat_time}</td>
                         <td>{$cas}</td>

                    </tr>";
            echo "</tbody></table>";

        } catch(Exception $e) {
            exit( $e->getMessage());

        }
    }

    function fanliwang_investinfo(Request $request){ 
        try{
            $start_time = $request->input('start_time');
            $end_time = $request->input('end_time');
            $db = DB::connection('mysql_main');

            $where = "where f.user_id = u.id and f.order_time >= '{$start_time}' and f.order_time <= '{$end_time}'";

            //用户信息
            $sql = "SELECT u.real_name,f.time_limit,f.isback,f.u_id,f.order_id,f.order_time,f.real_pay_fee,f.mobile,u.creat_time FROM vault_campaign_fanliwang f,vault_user u  {$where} order by f.id asc";

            //用户信息
           // $sql = "SELECT * FROM vault_user {$where} order by id desc limit 100";
            $rows = $db->select($sql);
            if( count($rows) <= 0 )
            {
                exit("指定时间内投资数据为空！");
            } 

            $isbacks = array();
            $isbacks['-1'] = '非法用户';
            $isbacks['0'] = '未回调';
            $isbacks['1'] = '已回调';
            $isbacks['2'] = '失去资格';

            echo "<table class=\"table table-striped\">";
            echo    "<thead>
                        <tr>
                            <th>姓名</th>
                            <th>用户手机号</th>
                            <th>返利网结算ID</th>
                            <th>订单号</th>
                            <th>首投时间</th>
                            <th>首投金额</th>
                            <th>首投期数</th>
                            <th>回调状态</th>                          
                            <th>新用户注册时间</th>
                        </tr>
                    </thead>";
            foreach ($rows as $key => $value) {
                $isback = $isbacks["{$value->isback}"];
                $money = intval($value->real_pay_fee / 100) ;
                $term = intval(round($value->time_limit / 30));
                $calss = "";
                if($value->isback == 1)
                {
                    $class = "success";
                }
                 echo    "<tr class=\"{$class}\">
                            <td>{$value->real_name}</td>
                            <td>{$value->mobile}</td>
                            <td>{$value->u_id}</td>
                            <td>{$value->order_id}</td>
                             <td>{$value->order_time}</td>
                             <td>{$money}</td> 
                             <td>{$term}</td>
                             <td>{$isback}</td>                            
                             <td>{$value->creat_time}</td>

                        </tr>";
            }

            echo "</tbody></table>";

        } catch(Exception $e) {
            exit( $e->getMessage());

        }
    }

}
