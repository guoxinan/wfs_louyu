<?php

namespace app\admin\controller;

use app\common\service\AdvService;
use app\common\service\AdvPositionService;
use app\common\service\UploadService;
use app\common\record\AdvRecord;

class Adv extends Base
{
    public function getCondition($params)
    {
        $condition = [];
        if (array_key_exists('id', $params) && $params['id'] !== '') {
            $condition[] = ['id', '=', $params['id']];
        }
        if (array_key_exists('position_id', $params) && $params['position_id'] !== '') {
            $condition[] = ['position_id', '=', $params['position_id']];
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
        $result['with'] = ['bind_position_name'];
        $result['orderby'] = ['id' => 'desc'];
        return $result;
    }

    public function _data()
    {

        $statusList = AdvService::getAttribute('statusList');
        $condition = [['status', '=', 1]];
        $positionList = AdvPositionService::getAllData($condition);
        $this->assign('status_list', $statusList);
        $this->assign('position_list', $positionList);
    }

    public function _info($info)
    {
        if (!empty($info)) {
            $imgId = $info['img_id'];
            $imgurl = UploadService::getFilePathById($imgId);
            $info['imgurl'] = $imgurl;
        }
        return $info;
    }

    public function del(){
        $id = $this->request->param('id');
        $res = AdvRecord::delete(['id'=>$id]);
        if($res !== false){
            return $this->jsonSuccess('删除成功');
        }else{
            return $this->jsonError('删除失败');
        }
    }
}
