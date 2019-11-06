<?php 
namespace app\admin\controller;
use app\common\service\AdminService;
/**
 * excel 导入
 */
class Excel extends Base
{
	public function getCondition($params)
    {
        $condition = [];
        if (array_key_exists('id', $params) && $params['id'] !== '') {
            $condition[] = ['id', '=', $params['id']];
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
        $statusList = AdminService::getAttribute('statusList');
        $this->assign('status_list', $statusList);
    }

    public function insert(){
    	if(request()->file()){
    		dump(123);
    	}
    	dump($_FILES);exit;
    }

   	public function upload(){
   		dump($_FILES);exit;
   	}
}