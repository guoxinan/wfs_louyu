<?php

namespace app\admin\controller;


use app\common\func\UploadFunc;
use app\common\record\UploadRecord;
use think\facade\Cache;

class Ajax extends Base
{
    //上传
    public function upload()
    {
        $uploadResult = UploadFunc::run();
        $uploadCode = $uploadResult['code'];
        $message = $uploadResult['message'];
        $filepath = $uploadResult['filepath'];
        if ($uploadCode === 0) {
            $domain = $this->request->domain();
            $fileurl = $domain . $filepath;
            $insertData = [
                'filepath' => $filepath,
            ];
            $insertResult = UploadRecord::insert($insertData, true);
            if($insertResult !== false){
                $data = [
                    'id' => $insertResult['data']['id'],
                    'filepath' => $filepath,
                    'fileurl' => $fileurl,
                ];
                return $this->jsonSuccess($message, $data);
            } else {
                $data = [
                    'filepath' => '',
                    'fileurl' => '',
                ];
                return $this->jsonError('入库失败', $data);
            }

        } else {
            $data = [
                'filepath' => '',
                'fileurl' => '',
            ];
            return $this->jsonError($message, $data);
        }
    }

    //清除缓存
    public function cacheClear()
    {
        Cache::clear();
    }
}
