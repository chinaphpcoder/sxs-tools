<?php
function phone_hide($phone) {
    $phone = trim($phone);
    if( strlen($phone) != 11 ) return '';
    return substr_replace($phone,'****',3,4);
}
function id_hide($id) {
    $id = trim($id);
    if( !(strlen($id) == 18 || strlen($id) == 15) ) return '';
    return substr_replace($id,'******',8,6);
}

function valid_date($date)
{
    //匹配日期格式
    if (preg_match ("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date, $parts))
    {
        //检测是否为日期,checkdate为月日年
        if(checkdate($parts[2],$parts[3],$parts[1]))
            return true;
        else
            return false;
    }
    else
        return false;
}

function filter($data ){
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            $refer = filter($value);
        }else{
            $refer = $value;
        }

        if (empty($refer)) {
            unset($data[$key]);
        }else{
            $data[$key] = $refer;
        }
    }

    return $data;
}

function gen_rand_string($length){
   $str = null;
   $strPol = "0123456789abcdefghijklmnopqrstuvwxyz";
   $max = strlen($strPol)-1;

   for($i=0;$i<$length;$i++){
    $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
   }

   return $str;
}
function gen_rand_number($length){
   $str = null;
   $strPol = "1234567890";
   $max = strlen($strPol)-1;

   for($i=0;$i<$length;$i++){
    $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
   }

   return $str;
}