<?php

namespace app\common\model;


class News extends Base
{

    protected $append = ['status_name'];
    public $statusList = [
        ['id' => 1, 'title' => '正常'],
        ['id' => 2, 'title' => '禁用']
    ];
    public function getStatusNameAttr($value, $data)
    {
        $statusList = $this->statusList;
        $statusArr = array_column($statusList, 'title', 'id');
        return $statusArr[$data['status']];
    }


    public function bindCate()
    {
        $bindArr = ['cate_name' => 'title'];
        return $this->belongsTo('NewsCate', 'cate_id')->bind($bindArr);
    }
}
