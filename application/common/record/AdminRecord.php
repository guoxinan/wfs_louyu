<?php

namespace app\common\record;

use app\common\model\Admin;

class AdminRecord extends BaseRecord
{
    //更新一些字段信息
    public static function updateById($id, $data)
    {
        $model = new Admin();
        $condition = [['id', '=', $id]];
        $result = $model->allowField(true)->save($data, $condition);
        return $result;
    }



}
