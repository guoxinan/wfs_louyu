<?php

namespace app\admin\controller;

use app\common\record\NewsCateRecord;
use app\common\service\NewsCateService;

class NewsCate extends Base
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
        $result['orderby'] = ['orderby' => 'asc'];
        //$result['with'] = ['bindRole'];
        return $result;
    }


    public function _data()
    {
        //一级分类列表
        $cateList = NewsCateService::getAllData(['pid'=>0,'status'=>1]);
        $this->assign('cateList', $cateList);
        $statusList = NewsCateService::getAttribute('statusList');
        $this->assign('status_list', $statusList);
    }

    public function del(){
        $id = $this->request->param('id');
        $res = NewsCateRecord::delete(['id'=>$id]);
        if($res !== false)return $this->jsonSuccess('删除成功');
        return $this->jsonError('删除失败');

    }

    public function sonList()
    {
        $pid = $this->request->param('pid', 0);
        $condition = [['pid', '=', $pid]];
        $allData = NewsCateService::getAllData($condition,['status'=>1]);
        return $this->jsonSuccess('子列表数据', $allData);
    }



}
