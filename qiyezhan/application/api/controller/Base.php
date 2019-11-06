<?php


namespace app\api\controller;

use think\Controller;

class Base extends Controller
{
    //初始化执行
    protected function initialize()
    {

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
        return json($result);
    }
}