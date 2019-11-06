<?php
namespace app\home\controller;
use think\Controller;
use app\common\record\StatisticsLogRecord;
use app\common\service\StatisticsLogService;
class Base extends Controller{

    //初始化执行
    protected function initialize()
    {
        $this->_statistics();
    }

    //记录用户访问量
    protected function _statistics(){
        //获取用户访问IP
        $ip = $this->getIp();
        //当天0点时间戳
        $todayTime = strtotime(date("Y-m-d"),time());
        $condition = [];
        $condition[]=['ip','=',$ip];
        $condition[]=['create_time','EGT',$todayTime];
        //查看当前IP今天有没有访问过
        $info = StatisticsLogService::getInfo($condition);
        //如果存在
        if(!empty($info)){
            //访问次数加1
            StatisticsLogRecord::update(['id'=>$info['id']],['num'=>$info['num']+1]);
        }else{
           //不存在添加一条新数据
            StatisticsLogRecord::insert(['ip'=>$ip,'create_time'=>time()]);
        }

    }
    //获取客户端IP
    protected function getIp(){
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }


    // json 格式成功
    public function jsonSuccess($message = '操作成功', $data = [], $url = '')
    {
        return $this->json($message, $data, $url, 0);
    }

    // json 格式失败
    public function jsonError($message = '操作失败', $data = [], $url = '')
    {
        return $this->json($message, $data, $url, 1);
    }

    //json 格式 返回值
    private function json($message, $data, $url, $code)
    {
        $result = [
            'code' => $code,
            'message' => $message,
            'data' => $data,
            'url' => $url,
        ];
        echo json_encode($result);
        exit;
    }



}
