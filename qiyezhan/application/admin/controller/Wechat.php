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
        //是不是 看着看着你php也会了  别以后你做后端了  我那以后就去做前端  哈哈哈，老公，你要不要这么秀以后你教我后端
        if (!empty($info)) {
            $imgId = $info['img_id'];
            $imgurl = UploadService::getFilePathById($imgId);
            $info['img_url'] = $imgurl;
        }
        return $info;
    }
}