<?php


namespace app\api\controller;
use app\common\service\MenuService;
class Menu extends Base
{
	//菜单导航
    public function lists(){
    	$data = [];
    	$condition = ['status' => 1];
    	$params = ['orderby' => ['orderby' => 'desc','id' => 'asc']];
    	$menuList = MenuService::getAllData($condition,$params);
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