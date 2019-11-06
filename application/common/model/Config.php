<?php

namespace app\common\model;


class Config extends Base
{
    protected $append = ['type_name'];

    public $typeList = [
        ['id' => 1, 'title' => '系统'],
        ['id' => 2, 'title' => '未定义']
    ];

    public function getTypeNameAttr($value, $data)
    {
        $result = '未知';
        if (array_key_exists('type', $data)) {
            $keyValue = $data['type'];
            $typeList = $this->typeList;
            $typeArr = array_column($typeList, 'title', 'id');
            $result = isset($typeArr[$keyValue]) ? $typeArr[$keyValue] : $result;
        }
        return $result;
    }
}
