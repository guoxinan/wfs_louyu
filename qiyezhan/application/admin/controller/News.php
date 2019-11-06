<?php

namespace app\admin\controller;

use app\common\record\CateRecord;
use app\common\record\NewsRecord;
use app\common\service\NewsService;
use app\common\service\NewsCateService;
use app\common\service\UploadService;

class News extends Base
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
        $result['with'] = ['bindCate'];
        $result['orderby'] = ['orderby' => 'desc'];
        return $result;
    }

    public function _data()
    {
        $statusList = NewsService::getAttribute('statusList');
        $condition = [
            ['pid', '=', 0],
            ['status', '=', 1]
        ];
        $oneList = NewsCateService::getAllData($condition);
        $this->assign('status_list', $statusList);
        $this->assign('one_list', $oneList);
    }

    public function _info($info)
    {
        if (!empty($info)) {
            $imgId = $info['banner'];
            $imgurl = UploadService::getFilePathById($imgId);
            $info['banner_url'] = $imgurl;
            $cateId = $info['cate_id'];
            $condition = [['id', '=', $cateId]];
            $cateInfo = NewsCateService::getInfo($condition);
            $one = $cateInfo['pid'];
            $condition = [
                ['pid', '=', $one],
                ['status', '=', 1]
            ];
            $cateList = NewsCateService::getAllData($condition);
            $info['cate_list'] = $cateList;
            $info['one'] = $one;
        }
        return $info;
    }

    public function del(){
        $id = $this->request->param('id');
        $res = NewsRecord::delete(['id'=>$id]);
        if($res === false)return $this->jsonError('删除失败');
        return $this->jsonSuccess('删除成功');
    }





}
