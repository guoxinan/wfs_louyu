<?php

namespace app\common\model;


class Adv extends Base
{
    public function bindPositionName()
    {
        $bindArr = ['position_name'=>'title'];
        return $this->belongsTo('AdvPosition', 'position_id')->bind($bindArr);
    }

    public function bindUpload()
    {
        $bindArr = ['filepath' => 'filepath'];
        return $this->belongsTo('Upload', 'img_id')->bind($bindArr);
    }

}
