<?php


namespace app\api\controller;
use app\common\service\LinkService;
class Link extends Base
{
	//友情链接
    public function lists(){
    	$data = [];
    	$condition = ['status' => 1];
    	$menuList = LinkService::getAllData($condition);
    	if($menuList){
    		$data = [
	    		'menuList' => $menuList
	    	];
    		return $this->jsonSuccess('查询成功',$data);
    	}else{
    		return $this->jsonError('查询失败');
    	}
    }
}