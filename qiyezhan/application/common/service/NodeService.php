<?php

namespace app\common\service;


use app\common\model\RoleNode;

class NodeService extends BaseService
{
    public static $orderby = ['orderby' => 'desc', 'id' => 'desc'];

    //取顶部列表
    public static function getTopListByRoleId($roleId)
    {
        $listToRole = self::getListByRoleId($roleId);
        $result = [];
        foreach ($listToRole as $key => $val) {
            if ($val['position'] == 'top') {
                $result[] = $val;
            }
        }
        return $result;
    }

    //取左侧列表
    public static function getLeftListByRoleId($roleId, $pid)
    {
        $listToRole = self::getListByRoleId($roleId);
        $result = [];
        foreach ($listToRole as $key => $val) {
            if ($val['pid'] == $pid) {
                $result[] = $val;
            }
        }
        return $result;
    }

    //取 角色的 节点列表
    public static function getListByRoleId($roleId)
    {
        $condition = [];
        if ($roleId != 1) {
            $roleNodeCondition = [['role_id', '=', $roleId]];
            $roleNodeList = RoleNode::where($roleNodeCondition)->select()->toArray();
            $nodeIdArr = array_column($roleNodeList, 'node_id');
            $condition[] = ['id', 'in', $nodeIdArr];
        }
        $condition[] = ['status', '=', 1];
        $result = self::getAllData($condition);
        return $result;
    }
}
