<?php

namespace app\admin\controller;

use app\common\service\MenuService;
use app\common\record\MenuRecord;

class Menu extends Base
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

    //菜单列表
    public function index()
    {
        if (method_exists($this, '_data')) {
            $this->_data();
        }
        $routeParam = $this->request->route();
        $queryStr = http_build_query($routeParam);
        $this->assign('query_str', $queryStr);
        return view('index');
    }

    public function _data()
    {
        $statusList = MenuService::getAttribute('statusList');
        $this->assign('status_list', $statusList);

    }

    public function del(){
        $id = $this->request->param('id');
        $res = MenuRecord::delete(['id'=>$id]);
        if($res !== false){
            return $this->jsonSuccess('删除成功');
        }else{
            return $this->jsonError('删除失败');
        }
    }

}
