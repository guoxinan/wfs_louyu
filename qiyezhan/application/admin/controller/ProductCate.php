<?php

namespace app\admin\controller;

use app\common\record\ProductCateRecord;
use app\common\service\ProductCateService;

class ProductCate extends Base
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
                $result['page'] = isset($params['page']) ? $params['page'] : 1;
                $result['page_size'] = isset($params['limit']) ? $params['limit'] : 1;
                break;
        }
        //$result['with'] = ['bind_cate_name', 'bind_brand_name', 'bind_shop'];
        $result['orderby'] = ['orderby' => 'desc'];
        return $result;
    }

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
        $statusList = ProductCateService::getAttribute('statusList');
        $this->assign('status_list', $statusList);
    }


    public function del(){
        $id = $this->request->param('id');
        $res = ProductCateRecord::delete(['id'=>$id]);
        if($res !== false)return $this->jsonSuccess('删除成功');
        return $this->jsonError('删除失败');
    }


}
