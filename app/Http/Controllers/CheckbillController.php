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


class CheckbillController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function index(Request $request) {
        try{
            $date = $request->input('date');
            $date = trim($date);
            $status = valid_date($date);
            if($status == false) {
                $time = time();
                $date = date("Y-m-d",$time - 24*3600);
            }

            if( $date < '2017-07-09' ) {
                $date = '2017-07-09';
            }

            $dates = array();
            for( $i = strtotime('2017-07-09 00:00:00') ;$i <= time()-24*3600;$i = $i + 3600*24 ) {
                $dates[] = date("Y-m-d",$i);
            }

            $db = DB::connection('mysql_main');
            $datas = array();
            //流水对账文件
            do {
                $sql = "select * from `vault_xinwang_bill_log` where date = '{$date}' ";
                $rows = $db->select($sql);
                if( count($rows) <= 0 )
                {
                    continue;
                }
                $count = 0;
                $rule_ids = array();
                $user_ids = array();
                foreach ($rows as $key => $value) {
                    $datas[$count]['date'] = $value->date;
                    $datas[$count]['download_status'] = $value->download_status;
                    $datas[$count]['confirm_status'] = $value->confirm_status;
                    $datas[$count]['overall_bill_status'] = $value->overall_bill_status;
                    $datas[$count]['recharge_bill_status'] = $value->recharge_bill_status;
                    $datas[$count]['withdraw_bill_status'] = $value->withdraw_bill_status;
                    $datas[$count]['commission_bill_status'] = $value->commission_bill_status;
                    $datas[$count]['backroll_bill_status'] = $value->backroll_bill_status;
                    $datas[$count]['transaction_bill_status'] = $value->transaction_bill_status;
                    $datas[$count]['confirm_time'] = $value->confirm_time;
                    $datas[$count]['last_time'] = $value->last_time;
                    $count++;
                }
            } while (0);

            //业务对账
            $accounts = array();
            do{
                $sql = "select * from `vault_account_bill_log` where date = '{$date}' ";
                $rows = $db->select($sql);
                if( count($rows) <= 0 )
                {
                    continue;
                }
                $count = 0;
                $rule_ids = array();
                $user_ids = array();
                foreach ($rows as $key => $value) {
                    $accounts[$count]['date'] = $value->date;
                    $accounts[$count]['general_balance_sxs'] = $value->general_balance_sxs;
                    $accounts[$count]['general_balance_xw'] = $value->general_balance_xw;
                    $accounts[$count]['income_balance_sxs'] = $value->income_balance_sxs;
                    $accounts[$count]['income_balance_xw'] = $value->income_balance_xw;
                    $accounts[$count]['marketing_balance_sxs'] = $value->marketing_balance_sxs;
                    $accounts[$count]['marketing_balance_xw'] = $value->marketing_balance_xw;
                    $accounts[$count]['compensatory_balance_sxs'] = $value->compensatory_balance_sxs;
                    $accounts[$count]['compensatory_balance_xw'] = $value->compensatory_balance_xw;
                    $accounts[$count]['dividend_balance_sxs'] = $value->dividend_balance_sxs;
                    $accounts[$count]['dividend_balance_xw'] = $value->dividend_balance_xw;
                    $accounts[$count]['lender_balance_sxs'] = $value->lender_balance_sxs;
                    $accounts[$count]['loaner_balance_sxs'] = $value->loaner_balance_sxs;
                    $accounts[$count]['user_balance_xw'] = $value->user_balance_xw;
                    $accounts[$count]['difference'] = $value->difference;                  
                    $accounts[$count]['status'] = $value->status;
                    $accounts[$count]['log'] = $value->log;
                    $accounts[$count]['last_time'] = $value->last_time;
                    $count++;
                }
            } while (0);

        } catch(Exception $e) {
            echo $e->getMessage();

        } finally {
            //var_dump($allv);
            return view('checkbill', compact('dates','date','datas','accounts'));
        }
        
    }
}
