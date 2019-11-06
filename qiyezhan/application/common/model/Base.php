<?php

namespace app\common\model;

use think\Model;

class Base extends Model
{
    protected $autoWriteTimestamp = true;

    public $statusList = [
        ['id' => 1, 'title' => '显示'],
        ['id' => 2, 'title' => '不显示']
    ];

    public function getStatusNameAttr($value, $data)
    {
        $lists = $this->statusList;
        $arr = array_column($lists, 'title', 'id');
        $result = '';
        if (isset($data['status'])) {
            $key = $data['status'];
            $result = isset($arr[$key]) ? $arr[$key] : '未知';
        }
        return $result;
    }

}
