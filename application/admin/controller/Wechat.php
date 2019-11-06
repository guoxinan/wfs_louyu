<?php
namespace app\admin\controller;
use app\common\service\UploadService;
/**
 * 微信配置
 */
class Wechat extends Base
{

	public function _info($info){
        //老婆 你来了  聪明呀 ~~！老公，快点工作啦，我看着你，嘻嘻
        if (!empty($info)) {
            $imgId = $info['img_id'];
            $imgurl = UploadService::getFilePathById($imgId);
            $info['img_url'] = $imgurl;
        }
        return $info;
    }
}