<?php

namespace app\common\service;


class RegionService extends BaseService
{
    public static $orderby = ['id' => 'asc'];

    //取全部区域列表
    public static function getAllList($isCache = true)
    {
        $cacheName = 'region_all_data';
        $allData = cache($cacheName);
        if ($isCache && $allData) {
            return $allData;
        }
        $allData = self::getAllData();
        cache($cacheName, $allData);
        return $allData;
    }

    //取子列表
    public static function getSonList($pid = 0, $isCache = true)
    {
        $cacheName = 'region_data_' . $pid;
        $sonData = cache($cacheName);
        if ($isCache && $sonData) {
            return $sonData;
        }
        $allList = self::getAllList();
        $allListArr = [];
        foreach ($allList as $key => $val) {
            $allListArr[$val['pid']] = $val;
        }
        $sonData = [];
        if (isset($allListArr[$pid])) {
            $sonData = $allListArr[$pid];
        }
        cache($cacheName, $sonData);
        return $sonData;
    }

    //把数据, 转换成 ['id'=>'title', 'id'=>'title']的形式的一维数组
    public static function getColumnData($isCache = true)
    {
        $cacheName = 'region_column_data';
        $columnData = cache($cacheName);
        if ($isCache && $columnData) {
            return $columnData;
        }
        $allList = self::getAllList();
        $columnData = array_column($allList, 'title', 'id');
        cache($cacheName, $columnData);
        return $columnData;
    }

    //$id 为数字时, 返回值为 字符串
    //$id 为数组时, 返回值为 数组
    public static function getTitleById($id, $columnData = [])
    {
        if (empty($columnData)) {
            $columnData = self::getColumnData();
        }
        if (is_array($id)) {
            $result = [];
            foreach ($id as $key => $val) {
                if (isset($columnData[$val])) {
                    $result[] = ['id' => $val, 'title' => $columnData[$val]];
                }
            }
        } else {
            $result = isset($columnData[$id]) ? $columnData[$id] : '';
        }
        return $result;
    }

    //给 data 添加上对应的 name 属性
    public static function addTitleToData($data)
    {
        $columnData = self::getColumnData();
        if (array_key_exists('province_id', $data)) {
            $title = self::getTitleById($data['province_id'], $columnData);
            $data['province_name'] = $title;
        }
        if (array_key_exists('city_id', $data)) {
            $title = self::getTitleById($data['city_id'], $columnData);
            $data['city_name'] = $title;
        }
        if (array_key_exists('county_id', $data)) {
            $title = self::getTitleById($data['county_id'], $columnData);
            $data['county_name'] = $title;
        }
        return $data;
    }
}
