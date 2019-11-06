<?php 
namespace app\index\controller;
use think\Controller;
use app\common\service\MenuService;
use app\common\service\LinkService;
/**
 * 
 */
class Base extends Controller
{
	
	//初始化执行
    protected function initialize()
    {
    	$param = ['orderby' => ['orderby' => 'desc', 'id' => 'asc']];
    	//菜单
        $menuCondition = [['status', '=', 1]];
        $menuList = MenuService::getAllData($menuCondition, $param);

        //友链
        $linkCondition = [['status', '=', 1]];
        $linkList = LinkService::getAllData($linkCondition);
        $this->assign([
        	'menu_list'=>$menuList,
        	'link_list'=>$linkList
        ]);
    }
}