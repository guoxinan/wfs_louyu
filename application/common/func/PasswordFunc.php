<?php

namespace app\common\func;

class PasswordFunc
{

    //加密
    public static function encrypt($password, $salt = 'vfengs')
    {
        $passwordMd5 = md5($password);
        $passwordStr = $passwordMd5 . $salt;
        $result = md5($passwordStr);
        return $result;
    }

    //检查
    public static function check($password, $encryptStr, $salt = 'vfengs')
    {
        $passwordEncryptStr = self::encrypt($password, $salt);
        if ($passwordEncryptStr == $encryptStr) {
            return true;
        }
        return false;
    }

    //解密
    public static function decrypt($encryptStr, $salt = 'vfengs')
    {
    }

    //获取随机数 random shuffle
    function getRandomStr($length = 6, $type = 'all')
    {
        switch ($type) {
            case 'all':
                $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
                break;
            case 'string':
                $str = 'abcdefghijklmnopqrstuvwxyz';
                break;
            case 'number':
                $str = '0123456789';
                break;
            default:
                $str = 'abcdefghijklmnopqrstuvwxyz';
        }
        $result = mb_substr(str_shuffle(str_repeat($str, $length)), 0, $length);
        return $result;
    }

    //用户密码加密
    function userPasswordEncry($password, $salt = 'vfengs')
    {
        $passwordMd5 = md5($password);
        $passwordStr = $passwordMd5 . $salt;
        $result = md5($passwordStr);
        return $result;
    }

}

?>