<?php

namespace app\common\func;

class UploadFunc
{
    //上传文件
    public static function run()
    {
        $file = request()->file('file');
        $type = request()->param('type', 'default');
        $config = self::getConfig($type);
        $dir = $config['dir'] ? $config['dir'] : 'default';
        $movepath = './' . $dir;
        $info = $file->move($movepath);
        if ($info) {
            $code = 0;
            $message = '上传成功';
            $saveName = $info->getSaveName();
            $filepath = '/' . $dir . $saveName;
        } else {
            $code = 1;
            $filepath = '';
            $message = $file->getError();
        }
        $result = [
            'code' => $code,
            'message' => $message,
            'filepath' => $filepath
        ];
        return $result;
    }

    public static function getConfig($type = '')
    {
        switch ($type) {
            case 'adv':
                $dirname = 'uploads/adv/';
                break;
            case 'article':
                $dirname = 'uploads/article/';
                break;
            case 'shop':
                $dirname = 'uploads/shop/';
                break;
            case 'company':
                $dirname = 'uploads/company/';
                break;
            case 'product':
                $dirname = 'uploads/product/';
                break;
            case 'order':
                $dirname = 'uploads/order/';
                break;
            case 'news':
                $dirname = 'uploads/news/';
                break;
            default:
                $dirname = 'uploads/default/';
        }
        $result = [
            'dir' => $dirname,
        ];
        return $result;
    }

    //创建目录
    public static function makeDir($dirpath)
    {
        $dir = './' . $dirpath;
        if (!is_dir($dir)) {
            $mkdirResult = mkdir($dir, 0777, true);
            if ($mkdirResult == false) {
                return false;
            }
        }
        return true;
    }
}

?>