<?php
namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Libraries\Classes\TransferCode;
use App\Libraries\Classes\HttpClient;
use App\Libraries\Classes\Signature;

/**
 * 新网连接
 */
class XinwangController extends Controller{

    /**
     * 新网首页
     */
    public function index() {
        return view('xinwang.index');
    }

    /**
     * 网关接口测试
     */
    public function gateway(Request $request) {
        try{
            $sn = $request->input('sn');
            if($sn == null) {
                $sn = "PERSONAL_REGISTER_EXPAND"; //个人绑卡注册
            }
            $gateway = config("xinwang.gateway");

            $sns = [];
            foreach ($gateway as $key => $value) {
                $sns[] = ['serviceName' => $key, 'name' => $value['name']];
            }

            $prams = $gateway[$sn];
            $name = $prams['name'];
            unset($prams['name']);

            if (isset($prams['requestNo'])) {
                $prams['requestNo'][0] = date("YmdHis").time().mt_rand(1,100);
            }

            // var_dump($prams);exit;
        } catch(Exception $e) {
            return $e->getMessage();
        } finally {
            return view('xinwang.gateway', ['sns' => $sns, 'prams' => $prams, 'sn' => $sn, 'name' => $name]);
        }
    }

    /**
     * 预处理
     */
    public function gateway_prepare(Request $request) {
        if (!$request->isMethod('post')) {
            return "参数错误";
        }
        try{
            //对POST数据进行处理
            $arrtmp = $_POST;
            $serviceName = $arrtmp['serviceName'];
            unset($arrtmp['_token']);
            unset($arrtmp['serviceName']);
            $arrtmp['timestamp'] = date("YmdHis"); 
            $arrtmp = filter($arrtmp);


            //获取sign值
            $reqData = Signature::data_sort($arrtmp);;
            $sign = Signature::encode($arrtmp);

            $url = config("xinwang.url") . "/gateway";

            $platformNo = config("xinwang.platformNo");

            $keySerial = config("xinwang.keySerial");

        } catch(Exception $e) {
            return $e->getMessage();
        } finally {
            return view('xinwang.gateway_prepare', [
                'serviceName' => $serviceName,
                'reqData' => $reqData,
                'sign' => $sign,
                'url' => $url,
                'keySerial' => $keySerial,
                'platformNo' => $platformNo
            ]);
        }
    }

    public function jump(Request $request) {
        try{
            //对POST数据进行处理

            $datas = $_POST;

            if( $datas != null ) {
                $respData = @$datas['respData'];
                $sign = @$datas['sign'];

                //验证sign值
                $status = Signature::verify($respData,$sign);
                //$status = true;

                if($status == true) {
                    $datas['验签状态'] = '验证通过';
                } else {
                    $datas['验签状态'] = '验证失败';
                }
            }
        } catch(Exception $e) {
            return $e->getMessage();
        } finally {
            return view('xinwang.jump', [
                'datas' => $datas
            ]);
        }
    }
    /**
     * 网关接口测试
     */
    public function direct(Request $request) {
        try{
            $sn = $request->input('sn');
            if($sn == null) {
                $sn = "CHANGE_USER_BANKCARD"; //个人绑卡注册
            }
            $gateway = config("xinwang.direct");

            $sns = [];
            foreach ($gateway as $key => $value) {

                $sns[] = ['serviceName' => $key, 'name' => $value['name']];
            }

            $prams = $gateway[$sn];
            $name = $prams['name'];
            unset($prams['name']);
            //echo json_encode($prams['bizDetails[0][requestNo]']);
            if (isset($prams['batchNo'])) {
              $prams['batchNo'][0] = date("YmdHis").mt_rand(1,100);
                
            }
            if (isset($prams['bizDetails[0][requestNo]'])) {
              $prams['bizDetails[0][requestNo]'][0] = date("YmdHis").time().mt_rand(1,100);
                
            }

            if (isset($prams['requestNo'])) {
                if($sn != 'QUERY_TRANSACTION'){
                    $prams['requestNo'][0] = date("YmdHis").time().mt_rand(1,100);
                }
                
            }

            // var_dump($prams);exit;
        } catch(Exception $e) {
            return $e->getMessage();
        } finally {
            return view('xinwang.direct', ['sns' => $sns, 'prams' => $prams, 'sn' => $sn, 'name' => $name]);
        }
    }
    public function direct_prepare(Request $request) {
        if (!$request->isMethod('post')) {
            return "参数错误";
        }
        try{
            //对POST数据进行处理
            $arrtmp = $_POST;
            //var_dump(file_get_contents("php://input"));exit;
            //var_dump($_POST);
            //echo json_encode($arrtmp);
            $serviceName = $arrtmp['serviceName'];
            unset($arrtmp['_token']);
            unset($arrtmp['serviceName']);
            $arrtmp['timestamp'] = date("YmdHis"); 
            $arrtmp = filter($arrtmp);

            //获取sign值
            $reqData = Signature::data_sort($arrtmp);;
            $sign = Signature::encode($arrtmp);

            $url = config("xinwang.url") . "/gateway";

            $platformNo = config("xinwang.platformNo");

            $keySerial = config("xinwang.keySerial");

        } catch(Exception $e) {
            return $e->getMessage();
        } finally {
            return view('xinwang.direct_prepare', [
                'serviceName' => $serviceName,
                'reqData' => $reqData,
                'sign' => $sign,
                'url' => $url,
                'keySerial' => $keySerial,
                'platformNo' => $platformNo
            ]);
        }
    }

    function direct_server(Request $request) {
        try{
            $data = $_POST['data'];
            $url = config("xinwang.url") . "/service";
            $rs = HttpClient::senddataheader($url,$data,'POST');
            $header = $rs['header'];
            $rs = $rs['body'];

            $rows = json_decode($rs,true);
            $sign = $this->getSign($header);
            if($sign != null){
                $rows['sign'] = $sign;
                $status = Signature::verify($rs,$sign);
                if($status == true) {
                    $rows['验签状态'] = '验证通过';
                } else {
                    $rows['验签状态'] = '验证失败';
                }
            }            
            $rows['原始信息'] = $rs;
            //var_dump($rows);
            //exit;
            echo '<div class="form-group">
                    <div>
                        <h3>新网存管系统直连接口返回数据</h3>
                    </div>
                </div>';
            if($rows == null) {
                echo $rs;
            } else {
                echo '<div class="form-group">';
                echo '<table class="table table-bordered table-responsive">';
                echo    "<thead>
                            <tr>
                                <th>参数名</th>
                                <th>内容</th>
                            </tr>
                        </thead>";
                foreach ($rows as $key => $value) {
                    if(is_array($value)) {
                        $value = json_encode($value);
                    }
                    echo "<tr>
                            <td>{$key}</td>
                            <td>{$value}</td>
                          </tr>";
                }
                echo "</tbody></table></div>";
            }
        } catch(Exception $e) {
            echo $e->getMessage();
        }                
    }

    private function getSign($header){
        $header = explode("\n", $header);
        $header = array_filter($header, function($value){
            if (substr($value, 0, 4) == 'sign') {
                return true;
            }else{
                return false;
            }
        });
        if($header == null ) {
            return null;
        }
        $header = array_values($header);
        return substr($header[0], 6);
    }

    //对账文件下载
    public function download (Request $request) {
      try{
        $sn = $request->input('sn');
        if($sn == null) {
          $sn = "DOWNLOAD_CHECKFILE"; //对账文件下载
        }
        $gateway = config("xinwang.download");

        $sns = [];
        foreach ($gateway as $key => $value) {

          $sns[] = ['serviceName' => $key, 'name' => $value['name']];
        }

        $prams = $gateway[$sn];
        $name = $prams['name'];
        unset($prams['name']);

        if (isset($prams['fileDate'])) {
          $prams['fileDate'][0] = date("Ymd",time()-24*3600);
        }

        // var_dump($prams);exit;
      } catch(Exception $e) {
        return $e->getMessage();
      } finally {
        return view('xinwang.download', ['sns' => $sns, 'prams' => $prams, 'sn' => $sn, 'name' => $name]);
      }
    }

    public function download_prepare (Request $request) {
      if (!$request->isMethod('post')) {
        return "参数错误";
      }
      try{
        //对POST数据进行处理
        $arrtmp = $_POST;
        $serviceName = $arrtmp['serviceName'];
        unset($arrtmp['_token']);
        unset($arrtmp['serviceName']);
        $arrtmp['timestamp'] = date("YmdHis");
        $arrtmp = array_filter($arrtmp, function($value){
          if ($value === '') {
            return false;
          }else{
            return true;
          }
        });

        //获取sign值
        $reqData = Signature::data_sort($arrtmp);;
        $sign = Signature::encode($arrtmp);

        $url = config("xinwang.url") . "/download";

        $platformNo = config("xinwang.platformNo");

        $keySerial = config("xinwang.keySerial");

      } catch(Exception $e) {
        return $e->getMessage();
      } finally {
        return view('xinwang.download_prepare', [
          'serviceName' => $serviceName,
          'reqData' => $reqData,
          'sign' => $sign,
          'url' => $url,
          'keySerial' => $keySerial,
          'platformNo' => $platformNo,
          'download_time' => $arrtmp['fileDate'],
        ]);
      }
    }

  public function download_server(Request $request) {
    try{
      $data = $_POST['data'];
      $download_time = $_POST['download_time'];
      $url = config("xinwang.url") . "/download";
      $rs = HttpClient::senddataheader($url,$data,'POST');
      $header = $rs['header'];
      $rs = $rs['body'];
      $rows = json_decode($rs,true);
      $sign = $this->getSign($header);
      if($sign != null){
        $rows['sign'] = $sign;
        $status = Signature::verify($rs,$sign);
        if($status == true) {
          $rows['验签状态'] = '验证通过';
        } else {
          $rows['验签状态'] = '验证失败';
        }
      }
      //把文件写进zip
      $download_url = dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/download';
      if (!is_dir($download_url)) {
        mkdir($download_url, 0777);
      }

      //zip文件名
      $file_name = $download_url.'/'.$download_time;
      $file_address = file_put_contents($file_name .".zip", $rs);

      //解压文件
      $zip = \Comodojo\Zip\Zip::open($file_name .".zip");
      $rs = $zip->extract($file_name);
      //查询出文件名

      if (is_dir($file_name)) {
        if ($dh = opendir($file_name)) {
          while ($file = readdir($dh)) {
              if ($file== '.' || $file=='..') {
                continue;
              }
              $names = explode("_", $file);
              $file_names = explode(".", $names[2]);
              $file_type = $file_names[0];
              $rows[$file_type] = $file;
          }
          closedir($dh);
        }
      }

      echo '<div class="form-group">
                    <div>
                        <h3>新网存管系统对账下载接口返回数据</h3>
                    </div>
                </div>';
      if($rows == null) {
        echo $rs;
      } else {
        echo '<div class="form-group">';
        echo '<table class="table table-bordered table-responsive">';
        echo    "<thead>
                            <tr>
                                <th>参数名</th>
                                <th>内容</th>
                            </tr>
                        </thead>";
        foreach ($rows as $key => $value) {
          $lenth = explode('.', $value);
          echo "<tr>
                            <td>{$key}</td>
                            <td><a target='_blank'  href='".route('readFile', ['file_names'=>substr($value,0,strlen($lenth[0]))])."'>{$value}</a></td>
                          </tr>";
        }
        echo "</tbody></table></div>";
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function readFile () {
    $dir_name = explode('_', $_GET['file_names']);
    $download_url = dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/download';
    $content = file_get_contents($download_url.'/'.$dir_name[0].'/'.$_GET['file_names'].'.txt');
    echo $content;
  }
  /**
     * 网关接口测试
     */
    public function recharge(Request $request) {
        try{
            $sn = $request->input('sn');
            if($sn == null) {
                $sn = "RECHARGE"; //个人绑卡注册
            }
            $gateway = config("xinwang.recharge");

            $sns = [];
            foreach ($gateway as $key => $value) {

                $sns[] = ['serviceName' => $key, 'name' => $value['name']];
            }

            $prams = $gateway[$sn];
            $name = $prams['name'];
            unset($prams['name']);
            //echo json_encode($prams['bizDetails[0][requestNo]']);
            if (isset($prams['transactionTime'])) {
              $prams['transactionTime'][0] = date("YmdHis");
                
            }

            if (isset($prams['requestNo'])) {
                $prams['requestNo'][0] = date("ymd").time().mt_rand(1,100);    
            }

            // var_dump($prams);exit;
        } catch(Exception $e) {
            return $e->getMessage();
        } finally {
            return view('xinwang.recharge', ['sns' => $sns, 'prams' => $prams, 'sn' => $sn, 'name' => $name]);
        }
    }
    public function recharge_prepare(Request $request) {
        if (!$request->isMethod('post')) {
            return "参数错误";
        }
        try{
            //对POST数据进行处理
            $arrtmp = $_POST;
            //var_dump(file_get_contents("php://input"));exit;
            //var_dump($_POST);
            //echo json_encode($arrtmp);
            $sort_arr = [];
            $serviceName = $arrtmp['serviceName'];
            unset($arrtmp['_token']);
            unset($arrtmp['serviceName']); 

            //获取sign值
            $respData = json_encode($arrtmp);
            // $sign = Signature::encode($arrtmp);

            $platformNo = config("xinwang.platformNo");

            $appkey = config("xinwang.mock_callback.appkey");

            $timestamp = time();

            $nonce = gen_rand_string(10);

            $sort_arr['serviceName'] = $serviceName;
            $sort_arr['respData'] = $respData;
            $sort_arr['platformNo'] = $platformNo;
            $sort_arr['appkey'] = $appkey;
            $sort_arr['timestamp'] = $timestamp;
            $sort_arr['nonce'] = $nonce;

            $appsecret = config("xinwang.mock_callback.appsecret");

            ksort($sort_arr,SORT_STRING);
            $str = '';
            foreach ($sort_arr as $key => $value) {
                $str .= '&'.$key.'='.$value ;
            }
            $str = trim($str,'&');
            $str = $appsecret.$str.$appsecret;
            $sign = sha1($str);

            $url = config("xinwang.mock_callback.url");

        } catch(Exception $e) {
            return $e->getMessage();
        } finally {
            return view('xinwang.recharge_prepare', [
                'platformNo' => $platformNo,
                'serviceName' => $serviceName,
                'respData' => $respData,
                'appkey' => $appkey,
                'timestamp' => $timestamp,
                'nonce' => $nonce,
                'sign' => $sign,
                'url' => $url,
            ]);
        }
    }

    function recharge_server(Request $request) {
        try{
            $data = $_POST['data'];
            $url = config("xinwang.mock_callback.url");
            $rs = HttpClient::senddataheader($url,$data,'POST');
            $header = $rs['header'];
            $rs = $rs['body'];

            $rows = json_decode($rs,true);    
            $rows['原始信息'] = $rs;
            //var_dump($rows);
            //exit;
            echo '<div class="form-group">
                    <div>
                        <h3>模拟回调-返回数据</h3>
                    </div>
                </div>';
            if($rows == null) {
                echo $rs;
            } else {
                echo '<div class="form-group">';
                echo '<table class="table table-bordered table-responsive">';
                echo    "<thead>
                            <tr>
                                <th>参数名</th>
                                <th>内容</th>
                            </tr>
                        </thead>";
                foreach ($rows as $key => $value) {
                    if(is_array($value)) {
                        $value = json_encode($value);
                    }
                    echo "<tr>
                            <td>{$key}</td>
                            <td>{$value}</td>
                          </tr>";
                }
                echo "</tbody></table></div>";
            }
        } catch(Exception $e) {
            echo $e->getMessage();
        }                
    }
}
