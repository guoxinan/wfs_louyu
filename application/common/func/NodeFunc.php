<?php

namespace app\common\func;

class NodeFunc
{
    public static function toLayuiTreeData($data)
    {
        $dataArr = [];
        foreach($data as $key=>$val){
            $id = $val['id'];
            $pid = $val['pid'];
            $temp = [
                'id' => $id,
                'title' => $val['title'],
                'href' => '',
                'spread' => true,
                'checked' => true,
                'children' => [],
            ];
            $dataArr[$pid][] = $temp;
        }
        $result = [];
        if(isset($dataArr[0])){
            foreach($dataArr[0] as $key=>$val){
                $id = $val['id'];
                $children = isset($dataArr[$id]) ? $dataArr[$id] : [];
                $temp = $val;
                $temp['children'] = $children;
                $result[] = $temp;
            }
        }
        return $result;
    }

    public static function toAdminLeftData($data)
    {
        $result = [];
        foreach ($data as $key => $val) {
            $temp = $val;
            $temp['spread'] = false;
            $url = url($val['module'] . '/' . $val['controller'] . '/' . $val['action'], $val['params']);
            $temp['href'] = $url;
            $result[] = $temp;
        }
        //$result = self::_toAdminLeftDataAddDefault($result);
        return $result;
    }

    private static function _toAdminLeftDataAddDefault($data){
        $default = [
            [
                'title' => 'table列表',
                'icon' => 'icon-text',
                'href' => '/admin/index/table.html',
                "spread" => false,
            ],
            [
                'title' => 'form表单',
                'icon' => 'icon-text',
                'href' => '/admin/index/form.html',
                "spread" => false,
            ],
            [
                'title' => 'form2表单',
                'icon' => 'icon-text',
                'href' => '/admin/index/form2.html',
                "spread" => false,
            ]
        ];
        $result = array_merge($default, $data);
        return $result;
    }
}

?>