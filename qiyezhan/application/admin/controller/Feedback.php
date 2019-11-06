<?php


namespace app\admin\controller;

use app\common\service\FeedbackService;
use app\common\record\FeedbackRecord;

class Feedback extends Base
{
    public function getCondition($params)
    {
        $condition = [];
        if (array_key_exists('truename', $params) && $params['truename'] !== '') {
            $condition[] = ['truename|mobile', 'like', '%' . $params['truename'] . '%'];
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

    //对某个字段进行更新
    public function updateColumn()
    {
        $dataId = $this->request->param('id', 0);
        
        if (!$dataId) {
            return $this->jsonError('参数错误');
        }
        
        $condition = [['id', '=', $dataId]];
        $info = FeedbackService::getInfo($condition);
        if (!$info) {
            return $this->jsonError('信息不存在');
        }
        //要更新的字段信息
        $updateData = [];
        $updateData['status'] = 1;
        
        if (empty($updateData)) {
            return $this->jsonError('更新失败');
        }

        $result = FeedbackRecord::update($condition, $updateData, false);
        if ($result !== false) {
            return $this->jsonSuccess('更新数据成功');
        } else {
            return $this->jsonError('更新数据失败');
        }
    }

    public function detail()
    {
        $articleId = $this->request->param('id', 0);
        if (!$articleId) {
            return $this->jsonError('参数出错');
        }

        $condition = [['id', '=', $articleId]];
        $info = FeedbackService::getInfo($condition);
        if (!$info) {
            return $this->jsonError('参数出错');
        }
        return view('detail', ['info' => $info]);
    }
}