<?php

namespace app\common\model;


class Article extends Base
{
	protected $append = ['status_name'];
    public $defaultAll = [
        'cate_id_arr' => [1]
    ];

    public function bindCateName()
    {
        $bindArr = ['cate_name'=>'title'];
        return $this->belongsTo('ArticleCate', 'cate_id')->bind($bindArr);
    }

    public function bindUpload()
    {
        $bindArr = ['filepath' => 'filepath'];
        return $this->belongsTo('Upload', 'banner')->bind($bindArr);
    }

}
