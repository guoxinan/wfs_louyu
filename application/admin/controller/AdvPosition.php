<?php

namespace app\admin\controller;

use app\common\service\AdvPositionService;

class AdvPosition extends Base
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
        $statusList = AdvPositionService::getAttribute('statusList');
        $this->assign('status_list', $statusList);
    }

    public function del(){
        $id = $this->request->param('id');
        $res = AdminRecord::delete(['id'=>$id]);
        if($res !== false){
            return $this->jsonSuccess('删除成功');
        }else{
            return $this->jsonError('删除失败');
        }
    }
}
