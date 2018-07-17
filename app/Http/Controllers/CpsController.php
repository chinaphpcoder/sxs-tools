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


class CpsController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    function tools(Request $request){ 
        $base_url = $request->input('base_url');
        $base_url = trim($base_url);
        if($base_url == '') {
            $base_url = "https://and.shaxiaoseng.com";
        }
        $base_url = trim($base_url,'/');
        $datas = [];
        $datas['fanli_register'] = $this->genFlwRegisterUrl($base_url);
        $datas['fanli_query'] = $this->getFlwQueryUrl($base_url);
        $datas['chezhu_register'] = $this->genCzwyRegisterUrl($base_url);
        $datas['base_url'] = $base_url;
        return view('cps.tools', compact('datas'));
    }
    function getMillisecond() {
        list($t1, $t2) = explode(' ', microtime());
        return $t2.ceil( ($t1 * 1000) );
    }

    function genCzwyRegisterUrl($base_url) {
      $ts = $this->getMillisecond();
      $udid = gen_rand_string(20);
      $str = "5233b484fd67b470ts={$ts}&udid={$udid}5233b484fd67b470";
      $sign = md5($str);
      $url ="/activity/landing/?invite=null&channel=AJJGAJ&ts={$ts}&udid={$udid}&sign={$sign}";

      return $base_url.$url;
    }
    private function genFlwRegisterUrl($base_url)
    {
        $channel_id = '51fanli';
        $u_id = gen_rand_number(10);
        $tracking_code = gen_rand_string(20);
        $tracking_id = gen_rand_number(10);
        $action_time = time();
        $key = 'e9e24882863da7ad';
        $sign = $this->flwGenSign($u_id,$action_time,$key);
        $url = "/activity/rebate_0612/?invite=null&channel=AJJCBJ&channel_id={$channel_id}&u_id={$u_id}&target_url=&tracking_code={$tracking_code}&tracking_id={$tracking_id}&action_time={$action_time}&sn={$sign}";
        return $base_url.$url;
    }
    private function getFlwQueryUrl($base_url)
    {
        $arr = array();
        $arr['channel_id'] = '51fanli';
        $arr['begin_date'] = date("Y-m-d H:i:s",strtotime("-7 days"));
        $arr['end_date'] = date("Y-m-d H:i:s");
        $arr['orderid'] = '';
        $arr['status'] = '0';
        $key = 'e9e24882863da7ad';
        $sign = $this->flwGenSignQuery($arr,$key);
        $url = "/Api2/Api.php/Campaign/query?channel_id=51fanli&begin_date={$arr['begin_date']}&end_date={$arr['end_date']}&orderid=&status=0&sign={$sign}" ;
        return $base_url.$url;
    }
    private function flwGenSign($u_id,$action_time,$key) {
        if ( $key == null  || $u_id == null || $action_time == null)
        {
            return false;
        }
        $str = "{$u_id}{$key}{$action_time}";
        return md5($str);
    }

    private function getQuerySort($arr) {
        $karr = array();
        $count = 0;
        foreach ($arr as $key => $value) {
            $keyd = ord(substr($key, 0,1)).$count;
            $karr[$keyd] = $key;
            $count++;
        }
        ksort($karr);
        $data = array();
        foreach ($karr as $key => $value) {
            $data[$value] = $arr[$value];
        }
        return $data;
    }

    private function flwGenSignQuery($arr,$shopkey) {
        $stringTmp = '';
        $signs = '';
        $arr = $this->arrayKflsort($arr);
        foreach ($arr as $key => $value) {
                $stringTmp .= '&'.$key.'='.$value ;
        }
        $stringTmp = $shopkey.trim($stringTmp,'&').$shopkey;
        return md5($stringTmp);

    }

    private function arrayKflsort($arr) {
        $karr = array();
        $count = 0;
        foreach ($arr as $key => $value) {
            $keyd = ord(substr($key, 0,1)).$count;
            $karr[$keyd] = $key;
            $count++;
        }
        ksort($karr);
        $data = array();
        foreach ($karr as $key => $value) {
            $data[$value] = $arr[$value];
        }
        return $data;
    }
    function fanliwang_userinfo(Request $request){ 
        try{
            $mobile = $request->input('mobile');
            $db = DB::connection('mysql_main');

            $where = "where mobile = '{$mobile}'";

            //用户信息
            $sql = "SELECT * FROM vault_campaign_fanliwang {$where} limit 1";

            //用户信息
           // $sql = "SELECT * FROM vault_user {$where} order by id desc limit 100";
            $rows = $db->select($sql);
            if( count($rows) <= 0 )
            {
                exit("非返利网渠道注册用户，请联系技术人员！");
            } elseif ( count($rows) > 1 )
            {
                exit("查询出错，请联系技术人员！");
            }

            $value = @$rows[0];
            $isbacks = array();
            $isbacks['-1'] = '非法用户';
            $isbacks['0'] = '未回调';
            $isbacks['1'] = '已回调';
            $isbacks['2'] = '失去资格';



            echo "<table class=\"table table-striped\">";
            echo    "<thead>
                        <tr>
                            <th>用户ID</th>
                            <th>返利网ID</th>
                            <th>位置效果追踪识别码</th>
                            <th>跳转追踪码</th>
                            <th>注册时间</th>
                            <th>投资记录ID</th>
                        </tr>
                    </thead>";
             echo    "<tr class=\"success\">
                         <td>{$value->user_id}</td>
                         <td>{$value->u_id}</td>
                         <td>{$value->tracking_code}</td>
                         <td>{$value->tracking_id}</td>
                         <td>{$value->register_time}</td>
                         <td>{$value->order_id}</td>

                    </tr>";
            echo    "<thead>
                        <tr>
                            <th>投资时间</th>
                            <th>投资金额</th>
                            <th>投资期限天</th>
                            <th>是否回调</th>
                            <th>回调状态</th>
                            <th>回调时间</th>
                        </tr>
                    </thead>";
            $isback = $isbacks["{$value->isback}"];
            $money = intval($value->real_pay_fee / 100) ;
             echo    "<tr class=\"success\">
                         <td>{$value->order_time}</td>
                         <td>{$money}</td>
                         <td>{$value->time_limit}</td>
                         <td>{$isback}</td>
                         <td>{$value->backstatus}</td>
                         <td>{$value->backtime}</td>

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
