<?php

namespace app\common\model;


class Job extends Base
{
    protected $append = ['status_name'];
    public $statusList = [
        ['id' => 1, 'title' => '显示'],
        ['id' => 2, 'title' => '不显示']
    ];
    public function getStatusNameAttr($value, $data)
    {
        $statusList = $this->statusList;
        $statusArr = array_column($statusList, 'title', 'id');
        return $statusArr[$data['status']];
    }


}
