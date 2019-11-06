<?php

namespace app\admin\controller;
use app\common\service\JobService;
use app\common\record\JobRecord;

class Job extends Base
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
        if (array_key_exists('desc', $params) && $params['desc'] !== '') {
            $condition[] = ['desc', 'like', '%' . $params['desc'] . '%'];
        }

        if (array_key_exists('status', $params) && $params['status'] !== '') {
            if ($params['status'] == 'index') {
                $condition[] = ['status', '<>', 2];
            } else {
                $condition[] = ['status', '=', $params['status']];
            }
        }
        return $condition;
    }

    //搜索条件的其它参数, 例如排序等
    protected function getConditionExtra($params = [], $type = '')
    {
        $result = [];
        switch ($type) {
            case 'info':
                break;
            case 'lists':
                $result['page'] = isset($params['page']) ? $params['page'] : 1;
                $result['page_size'] = isset($params['limit']) ? $params['limit'] : 1;
                break;
        }
        return $result;
    }

    public function _data()
    {
        $statusList = JobService::getAttribute('statusList');
        $this->assign('status_list', $statusList);
    }

    //删除,支持批量删除
    public function del(){
        $ids = $this->request->param('id');
        $idsArr = explode(',',$ids);
        $res = JobRecord::delete(['id'=>$idsArr]);
        if($res === false)return $this->jsonError('删除失败');
        return $this->jsonSuccess('删除成功');
    }



}
