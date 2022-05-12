<?php

namespace Ashin33\QnApi;

use Ashin33\QnApi\Exceptions\SignException;

class QnApi
{
    public $instId = '';
    public $secret = '';
    public $qnPublicKey = '';
    public $merchantPrivateKey = '';

    public function __construct($instId, $secret, $qnPublicKey, $merchantPrivateKey)
    {
        $this->instId = $instId;
        $this->secret = $secret;
        $this->qnPublicKey = file_get_contents($qnPublicKey);
        $this->merchantPrivateKey = file_get_contents($merchantPrivateKey);
    }

    private function aes($aesKey, $string, $encrypt = true)
    {
        if ($encrypt) {
            return openssl_encrypt($string, 'AES-128-ECB', $aesKey, 0, '');
        } else {
            return openssl_decrypt($string, 'AES-128-ECB', $aesKey, 0, '');
        }

    }

    private function rsa($string, $encrypt = true)
    {
        if ($encrypt) {
            $priKey = openssl_pkey_get_private($this->merchantPrivateKey);
            openssl_private_encrypt($string, $encrypted, $priKey);
            return base64_encode($encrypted);
        } else {
            $pub_key = openssl_pkey_get_public($this->qnPublicKey);
            openssl_public_decrypt(base64_decode($string), $decrypted, $pub_key);
            return $decrypted;
        }

    }

    public function encrypt($postdata)
    {
        $req['req_time'] = Date('YmdHis');
        $req['inst_id'] = $this->instId;
        $req['aes_key'] = $this->getRandStr(16);
        $req['req_no'] = $this->uuid();
        $req['data'] = $this->aes($req['aes_key'], json_encode($postdata));
        $req['aes_key'] = $this->rsa($req['aes_key']);

        $req['sign'] = $this->createSign($req, $this->secret);
        return $req;
    }

    /**
     * @throws SignException
     */
    public function decrypt($response)
    {
        $res = $response;
        if (!$this->verifySign($res['sign'], $response, $this->secret)) {
            throw new SignException("验签失败", 400);
        }
        $res['aes_key'] = $this->rsa($response['aes_key'], false);
        $res['data'] = $this->aes($res['aes_key'], $res['data'], false);
        return $res;
    }

    /**
     * @param $url
     * @param $data
     * @param array $extra
     * @return false|mixed
     * @throws SignException
     */
    public function request($url, $data, $extra = [])
    {
        //加密,加密参数
        $data = $this->encrypt($data);
        if (empty($extra)) {
            //发送请求
            $response = $this->send($url, $data);
        } else {
            foreach ($extra as $k => $v) {
                $data["extra[" . $k . "]"] = $v;
            }
            $response = $this->send($url, $data, true);
        }

        if (!empty($response)) {
            $res = json_decode($response, true);
            if ((isset($res['code']) && $res['code'] == 200)) {
                $res = $this->decrypt($res);
            }
            return $res;

        }
        return false;
    }

    private function uuid()
    {
        $chars = md5(uniqid(mt_rand(), true));
        return substr($chars, 0, 8) . '-'
            . substr($chars, 8, 4) . '-'
            . substr($chars, 12, 4) . '-'
            . substr($chars, 16, 4) . '-'
            . substr($chars, 20, 12);
    }

    private function getRandStr($length)
    {
        //字符组合
        $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $len = strlen($str) - 1;
        $randomStr = '';
        for ($i = 0; $i < $length; $i++) {
            $num = mt_rand(0, $len);
            $randomStr .= $str[$num];
        }
        return $randomStr;
    }

    /*
     * 签名串排列
     * */
    private function convertJson($data)
    {
        $str = "";
        foreach ($data as $k => $v) {
            if ((string)$k != "sign") {
                if (is_array($v)) {
                    if (empty($str)) {
                        if (is_numeric($k)) {
                            $str .= self::convertJson($v);
                        } else {
                            $str .= $k . '=' . self::convertJson($v);
                        }
                    } else {
                        if (is_numeric($k)) {
                            $str .= '&' . self::convertJson($v);
                        } else {
                            $str .= '&' . $k . '=' . self::convertJson($v);
                        }
                    }
                } else {
                    if (empty($str)) {
                        $str .= $k . '=' . $v;
                    } else {
                        $str .= '&' . $k . '=' . $v;
                    }
                }
            }
        }
        return $str;
    }

    /*
     * 二维数组签名排序
     * */
    private function dgkSort($data)
    {
        ksort($data);
        //如果由下一级  对下一集使用排序  返回
        foreach ($data as $k => $v) {
            if (is_array($v)) {
                $v = self::dgkSort($v);
            }
            $data[$k] = $v;
        }
        return $data;
    }

    /*
     * 生成签名
     * */
    private function createSign($data, $key)
    {
        $data = self::dgkSort($data);
        $str = self::convertJson($data);
        return md5($str . md5($key));
    }

    /*
     * 验证签名
     * */
    private function verifySign($sign, $data, $key)
    {
        $data = self::dgksort($data);
        $str = self::convertJson($data);
        $result = md5($str . md5($key));
        return $sign === $result;
    }

    public function send($url, $data = [], $hasExtra = false)
    {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);     // 请求地址
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // 变量存储
        if ($hasExtra) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:multipart/form-data', 'accept:application/json']); // 请求头
        } else {
            curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json', 'accept:application/json']); // 请求头
        }
        curl_setopt($curl, CURLOPT_POST, true); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));   // 请求体
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);          // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);          // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 60); // 设置响应超时
        curl_setopt($curl, CURLOPT_TIMEOUT, 60); // 设置传输超时
        curl_setopt($curl, CURLINFO_HEADER_OUT, true); // 请求头信息

        $response = curl_exec($curl); // 执行操作

        curl_close($curl); // 关闭CURL会话
        return $response;

    }
}
