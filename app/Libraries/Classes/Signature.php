<?php

namespace App\Libraries\Classes;

use Illuminate\Support\Facades\Config;


class Signature
{
    private static $instance;

    /**
     * 将JAVA公钥转成PHPPEM（私钥）
     */
    protected static function convertPrivateKey($der = '') {
        $pem = chunk_split($der, 64, "\n");
        $pem = "-----BEGIN PRIVATE KEY-----\n" . $pem . "-----END PRIVATE KEY-----\n";
        return $pem;
    }

    /**
     * 将JAVA的DER转成Open SSL的PEM（公钥）
     */
    protected static function convertPublicKey($der){
        $pem = chunk_split($der, 64, "\n");
        $pem = "-----BEGIN PUBLIC KEY-----\n" . $pem . "-----END PUBLIC KEY-----\n";
        return $pem;
    }

    /**
     * 对请求的数据进行排序
     * @param string|array $data 请求数据，JSON模式或者数组模式
     */
    public static function data_sort($data){
        //$data = str_replace('\"', '"', $data);

        if (!is_array($data)) {
            $data = json_decode($data, true);
        }
        ksort($data);
        return json_encode($data);
    }

    /**
     * 加密
     * @param string $data 要加密的数据
     */
    public static function encode($data){

        $privateKey =  Config::get('xinwang.privateKey');
        $key = openssl_pkey_get_private(self::convertPrivateKey($privateKey));
        openssl_sign(self::data_sort($data), $sign, $key, 'sha1WithRSAEncryption');
        $sign = base64_encode($sign);
        return $sign;
    }

    /**
     * 验证
     * @param string $data 请求的参数
     * @param string $sign 校验值
     * @return boolean 校验成功或者失败
     */
    public static function verify($data, $sign){
        $sign = base64_decode($sign);
        $lmpublicKey =  Config::get('xinwang.lmpublicKey');
        $key = openssl_pkey_get_public(self::convertPublicKey($lmpublicKey));
        $result = openssl_verify($data, $sign, $key, 'sha1WithRSAEncryption') === 1;
        return $result;
    }
}