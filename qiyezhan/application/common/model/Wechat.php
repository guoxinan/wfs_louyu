<?php

namespace app\common\model;
/*
	*微信设置
*/
class Wechat extends Base
{
	public function bindUpload()
    {
        $bindArr = ['filepath' => 'filepath'];
        return $this->belongsTo('Upload', 'banner')->bind($bindArr);
    }

}
