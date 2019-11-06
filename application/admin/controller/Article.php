<?php


namespace app\admin\controller;

use app\common\service\ArticleService;
use app\common\service\ArticleCateService;
use app\common\service\UploadService;
use app\common\record\ArticleRecord;

class Article extends Base
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
        $result['with'] = ['bind_cate_name'];
        $result['orderby'] = ['id' => 'desc'];
        return $result;
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

    public function _data(){
        $statusList = ArticleService::getAttribute('statusList');
        $cateList = ArticleCateService::getAllData();

        $this->assign('status_list', $statusList);
        $this->assign('cate_list', $cateList);
    }

    public function _info($info){
        if (!empty($info)) {
            $banner = $info['banner'];
            $bannerUrl = UploadService::getFilePathById($banner);
            $info['banner_url'] = $bannerUrl;
        }
        return $info;

    }

    public function del(){
        $id = $this->request->param('id');
        $res = ArticleRecord::delete(['id'=>$id]);
        if($res !== false){
            return $this->jsonSuccess('删除成功');
        }else{
            return $this->jsonError('删除失败');
        }
    }
}