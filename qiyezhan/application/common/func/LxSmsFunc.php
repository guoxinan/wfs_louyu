<?php


namespace app\common\func;

class LxSmsFunc
{
    private static $accName = '18538128666';
    private static $accPwd = 'vfengs2019+';
    private static $dataType = 'json';
    private static $signature = '【平氏伟业】';
    private static $url = 'https://www.lx598.com/sdk/send';
    private static function sendSms($mobile, $content)
    {
        if (is_array($mobile)) {
            $mobileArr = array_chunk($mobile, 5000);
            $mobile = implode(',', $mobileArr[0]);
        }
        if (is_array($content)) {
            $content = implode(',', $content);
        }
        $content = $content . static::$signature;
        $accPwd = strtoupper(md5(static::$accPwd));
        $opt = [
            'accName' => static::$accName,
            'dataType' => static::$dataType,
            'accPwd' => $accPwd,
            'aimcodes' => $mobile,
            'content' => $content,
        ];
        $resultCode = HttpFunc::curlPost(static::$url, $opt);
        $result = json_decode($resultCode, true);
        return $result;
    }
    //验证码
    public static function sendCode($mobile, $content)
    {
        return static::sendSms($mobile, $content);
    }
    //+++
    public static function sendMessage($mobile, $content)
    {
        return static::sendSms($mobile, $content);
    }


}