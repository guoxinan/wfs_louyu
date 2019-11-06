<?php

namespace app\common\service;


class UploadService extends BaseService
{
    //$id 为数字时, 返回值为 字符串
    //$id 为数组时, 返回值为 数组
    public static function getFilePathById($id, $domain = true)
    {
        $condition = [];
        $imageDomain = '';
        if ($domain) {
            $imageDomain = config('caigou.image_domain');
        }

        if (is_array($id)) {
            $condition[] = ['id', 'in', $id];
            $data = self::getAllData($condition);
            foreach ($data as $key => $val) {
                $data[$key]['filepath'] = $imageDomain . $val['filepath'];
            }
            $result = array_column($data, 'filepath', 'id');
        } else {
            $condition[] = ['id', '=', $id];
            $info = self::getInfo($condition);
            $result = $info ? $imageDomain . $info['filepath'] : '';
        }
        return $result;
    }
    //为数据添加图片显示路径只适用于数据数组中只有一种图片
    //$data  需要添加的数据
    //$imageArr 图片数组
    //$field 需要拼接的字段
    public static function addFileUrlByData($data, $imageArr, $field, $showField = 'img')
    {
        $fieldUrl = $showField . '_url';
        foreach ($data as $key => $val) {
            $data[$key][$fieldUrl] = isset($imageArr[$val[$field]]) ? $imageArr[$val[$field]] : '';
        }
        return $data;
    }
    //为数据添加图片显示路径只适用于数据数组中只有一种图片
    //$info  需要添加的数据
    //$imageArr 图片数组
    //$field 需要拼接的字段
    public static function addFileUrlByInfo($info, $imageArr, $field, $showField = 'img')
    {
        $fieldUrl = $showField . '_url';
        $info[$fieldUrl] = isset($imageArr[$info[$field]]) ? $imageArr[$info[$field]] : '';
        return $info;
    }
}
