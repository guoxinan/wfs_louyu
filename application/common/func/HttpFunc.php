<?php

namespace app\common\func;

class HttpFunc
{

    public static function curlGet($url, $header = [])
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        if (!empty($header)) {
            curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        }
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    public static function curlPost($url, $data = [], $header = [])
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_POST, 1);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        if (!empty($header)) {
            curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
}

?>