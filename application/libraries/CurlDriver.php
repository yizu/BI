<?php

/**
 * Project:     JoyBI CURL 驱动类
 * File:        CurlDriver.php
 *
 * <pre>
 * 描述：类
 * </pre>
 *
 * @package application
 * @author 李杨 <768216362@qq.com>
 * @copyright 2016 JoyBI , Inc.
 */


class CurlDriver
{

    /**
     * 创建一个curl会话
     * @return null
     */
    private function _create()
    {
        $ch = null;
        if (!function_exists('curl_init')) {
            return false;
        }
        $ch = curl_init();
        if (!is_resource($ch)) {
            return false;
        }
        return $ch;
    }
    /**
     * 使用curl发送请求
     * @return string
     */
    public function send($host, $url , $port , $method, $data)
    {
        $purl = parse_url($host . $url);
        if (!empty($data) && is_array($data)) {
            $data = http_build_query($data);
        }
        $ch = $this->_create();
        if (isset($purl['scheme']) && $purl['scheme'] == 'https') {
            //检查证书中是否设置域名，并且是否与提供的主机名匹配 
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            //降低验证标准，以保证正常访问
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
            //说明不进行SSL证书认证
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        }
        
        //设置超时时间
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        switch (strtolower($method)) {
        case 'post':
            curl_setopt($ch, CURLOPT_URL, $host . ":" . $port . $url);
            //获取的信息以文件流的形式返回，而不是直接输出
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");//设置为客户端支持gzip压缩
            $result = curl_exec($ch);
            break;
        case 'get':
            if (!empty($data)) {
                curl_setopt($ch, CURLOPT_URL, $host . ":" . $port. $url. "?" . $data); 
            } else {
                curl_setopt($ch, CURLOPT_URL, $host . ":" . $port. $url);
            }
            //获取的信息以文件流的形式返回，而不是直接输出
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");//设置为客户端支持gzip压缩
            $result = curl_exec($ch);
            break;
        default:
            break;
        }
        curl_close($ch);
        
        return $result;
    }
}

/* End of file HttpHandle.php */
