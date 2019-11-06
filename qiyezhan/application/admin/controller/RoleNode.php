<?php

namespace app\admin\controller;

use app\common\service\NodeService;
use app\common\func\NodeFunc;
use app\common\service\RoleNodeService;
use app\common\service\RoleService;

class RoleNode extends Base
{

    public function getCondition($params)
    {
        $condition = [];
        if (array_key_exists('id', $params) && $params['id'] !== '') {
            $condition[] = ['id', '=', $params['id']];
        }
        if (array_key_exists('title', $params) && $params['title'] !== '') {
            $condition[] = ['title', 'like', '%' . $params['title'] . '%'];
        }
        if (array_key_exists('status', $params) && $params['status'] !== '') {
            $condition[] = ['status', '=', $params['status']];
        }
        return $condition;
    }

    public function _data()
    {
        $typeList = RoleService::getAttribute('typeList');
        $this->assign('type_list', $typeList);
    }

    public function _info($info)
    {
        if (!empty($info)) {
            $type = $info['type'];
            $condition = [['type', '=', $type]];
            $allData = NodeService::getAllData($condition);
            $nodeList = NodeFunc::toLayuiTreeData($allData);
            $info['node_list'] = $nodeList;
            $condition = [['role_id', '=', $info['id']]];
            $roleNodeList = RoleNodeService::getAllData($condition);
            $nodeIdArr = array_column($roleNodeList, 'node_id');
            $info['node_id_arr'] = $nodeIdArr;
        }
        return $info;
    }

    public function del()
    {
    }
}
