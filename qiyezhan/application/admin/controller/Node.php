<?php

namespace app\admin\controller;


use app\common\func\NodeFunc;
use app\common\service\NodeService;

class Node extends Base
{

    public function getCondition($params)
    {
        $condition = [];
        if (array_key_exists('position', $params) && $params['position'] !== '') {
            $condition[] = ['position', '=', $params['position']];
        }
        if (array_key_exists('pid', $params) && $params['pid'] !== '') {
            $condition[] = ['pid', '=', $params['pid']];
        }
        if (array_key_exists('type', $params) && $params['type'] !== '') {
            $condition[] = ['type', '=', $params['type']];
        }
        if (array_key_exists('status', $params) && $params['status'] !== '') {
            $condition[] = ['status', '=', $params['status']];
        }
        return $condition;
    }

    public function leftAll()
    {
        $pid = $this->request->param('pid', 0);
        if ($pid == 0) {
            return $this->jsonSuccess('空数据', []);
        }
        $roleId = $this->admin['role_id'];
        $lists = NodeService::getLeftListByRoleId($roleId, $pid);
        $data = NodeFunc::toAdminLeftData($lists);
        return $this->jsonSuccess('左侧列表数据', $data);
    }

    public function allList()
    {
        $allData = NodeService::getAllData();
        $data = NodeFunc::toLayuiTreeData($allData);
        return $this->jsonSuccess('不同后台不同节点列表', $data);
    }
}
