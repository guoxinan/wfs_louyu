<?php


namespace app\admin\controller;

use app\common\service\ArticleCateService;
use app\common\record\ArticleCateRecord;

class ArticleCate extends Base
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

    //搜索条件的其它参数, 例如排序等
    protected function getConditionExtra($params = [], $type = '')
    {
        $result = [];
        switch ($type) {
            case 'info':
                break;
            case 'lists':
                $result['page_size'] = isset($params['limit']) ? $params['limit'] : 20;
                break;
        }
        $result['orderby'] = ['id' => 'desc'];
        return $result;
    }

    public function _data(){
        $statusList = ArticleCateService::getAttribute('statusList');
        $this->assign('status_list', $statusList);
    }

    public function del(){
        $id = $this->request->param('id');
        $res = ArticleCateRecord::delete(['id'=>$id]);
        if($res !== false){
            return $this->jsonSuccess('删除成功');
        }else{
            return $this->jsonError('删除失败');
        }
    }
}