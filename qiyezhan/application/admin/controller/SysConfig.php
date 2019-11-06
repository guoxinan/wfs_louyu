<?php

namespace app\admin\controller;

use app\common\service\SysConfigService;

class SysConfig extends Base
{

    public function getCondition($params)
    {
        $condition = [];
        if (array_key_exists('id', $params) && $params['id'] !== '') {
            $condition[] = ['id', '=', $params['id']];
        }
//        if (array_key_exists('title', $params) && $params['title'] !== '') {
//            $condition[] = ['title', 'like', '%' . $params['title'] . '%'];
//        }
        return $condition;
    }

    public function lists()
    {
        $all = SysConfigService::getAllData();
        $data = [
            'data' => $all,
            'count' => count($all),
        ];
        return $this->jsonSuccess('配置数据', $data);
    }

}
