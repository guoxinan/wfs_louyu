<?php

namespace app\admin\controller;

use app\common\service\SysConfigService;
use app\common\service\InvoiceService;
use app\common\service\UserService;
use app\common\record\StatisticsLogRecord;
use app\common\service\StatisticsLogService;

class Index extends Base
{
    public function home()
    {
        //获取访问统计信息
        //当天0点时间戳
        $todayStartTime = strtotime(date("Y-m-d"),time());
        //本周开始的时间戳
        $weekStartTime = strtotime(date('Y-m-d', strtotime("this week Monday", time())));
        //本月开始的时间戳
        $monthStartTime = mktime(0, 0, 0, date('m'), 1, date('Y'));
        //只查询本月所有的数据
        $info = StatisticsLogService::getAllData([['create_time','egt',$monthStartTime]]);

        //今天的访问量
        $todayCount = 0;
        //本周的访问量
        $weekCount = 0;
        //本月的访问量
        $monthCount = count($info);

        //今天的访问次数
        $todayNum = 0;
        //本周的访问次数
        $weekNum = 0;
        //本月的访问次数
        $monthNum = 0;
        foreach ($info as $key=>$val) {
            if (strtotime($val['create_time']) >= $todayStartTime) {
                //当天
                $todayCount++;
                $todayNum += $val['num'];
            }
            if (strtotime($val['create_time']) >= $weekStartTime) {
                //本周
                $weekCount++;
                $weekNum += $val['num'];
            }
            if (strtotime($val['create_time']) >= $monthStartTime) {
                //本月
                $monthNum += $val['num'];
            }
        }
        $this->assign([
            'todayCount'=>$todayCount,
            'todayNum'=>$todayNum,
            'weekCount'=>$weekCount,
            'weekNum'=>$weekNum,
            'monthCount'=>$monthCount,
            'monthNum'=>$monthNum,
        ]);
        return view();
    }

    private function _addNumberToData($data, $numberList, $dataKey = 'id', $numberKey = 'id')
    {
        foreach ($data as $key => $val) {
            $number = 0;
            foreach ($numberList as $k => $v) {
                if ($val[$dataKey] == $v[$numberKey]) {
                    $number = $v['number'];
                }
            }
            $data[$key]['number'] = $number;
        }
        return $data;
    }

    public function index()
    {

        return view();
    }

    public function table()
    {
        return $this->fetch();
    }

}
