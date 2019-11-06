<?php

namespace app\admin\controller;


use app\common\func\ExportFunc;
use app\common\func\ProductFunc;
use app\common\record\AdminMessageRecord;
use app\common\record\ProductRecord;
use app\common\service\ProductCateService;
use app\common\service\ProductService;
use app\common\service\UploadService;

class Product extends Base
{

    public function getCondition($params)
    {
        $condition = [];
        if (array_key_exists('id', $params) && $params['id'] !== '') {
            $condition[] = ['id', '=', $params['id']];
        }
        if (array_key_exists('cate_id', $params) && $params['cate_id'] !== '') {
            $condition[] = ['cate_id', '=', $params['cate_id']];
        }
        if (array_key_exists('cate_name', $params) && $params['cate_name'] !== '') {
            $tempCondition = [
                ['title', 'like', '%' . $params['cate_name'] . '%']
            ];
            $tempList = ProductCateService::getAllData($tempCondition);
            if (!empty($tempList)) {
                $idArr = array_column($tempList, 'id');
                $condition[] = ['cate_id', 'in', $idArr];
            } else {
                $condition[] = ['cate_id', '<', 0];
            }
        }
        if (array_key_exists('title', $params) && $params['title'] !== '') {
            $condition[] = ['title', 'like', '%' . $params['title'] . '%'];
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
        $result['with'] = ['bindCate'];
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
        $statusList = ProductService::getAttribute('statusList');
        $condition = [
            ['pid', '=', 0],
            ['status', '=', 1]
        ];
        $cateList = ProductCateService::getAllData($condition);
        $this->assign('status_list', $statusList);
        $this->assign('cate_list', $cateList);
    }

    public function _info($info)
    {
        if (!empty($info)) {
            $imgIdArr = explode('_', $info['carousel']);
            $imgIdArr[] = $info['banner'];
            $imgArr = UploadService::getFilePathById($imgIdArr);
            $info = ProductFunc::addFilePathToInfo($info, $imgArr);
            $condition = [
                ['status', '=', 1]
            ];
            $cateList = ProductCateService::getAllData($condition);
            $info['cate_list'] = $cateList;
        }
        return $info;
    }

    //删除,支持批量删除
    public function del(){
        $ids = $this->request->param('id');
        $idsArr = explode(',',$ids);
        $res = ProductRecord::delete(['id'=>$idsArr]);
        if($res === false)return $this->jsonError('删除失败');
        return $this->jsonSuccess('删除成功');
    }



}
