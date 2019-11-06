<?php
namespace app\api\controller;
use app\common\service\AdvService;
class Adv extends Base
{
    //多张轮播图
    public function lists()
    {
        $condition = [['position_id','=',1],['status', '=', 1]];
        $params = ['orderby' => ['orderby' => 'desc','id' => 'asc']];
        $advLists = AdvService::getAllData($condition,$params);
        if($advLists !== false){
            $data = [
                'advList' => $advLists,
            ];
            return $this->jsonSuccess('查询成功', $data);
        }else{
            return $this->jsonError('查询失败', $data);
        }
    }
    //单张轮播图
    public function one()
    {
        $condition = [['position_id','=',1],['status', '=', 1]];
        $advLists = AdvService::getInfo($condition);
        if($advLists !== false){
            $data = [
                'advList' => $advLists,
            ];
            return $this->jsonSuccess('查询成功', $data);
        }else{
            return $this->jsonError('查询失败', $data);
        }
    }
}