<?php

namespace app\common\service;


class ArticleService extends BaseService
{
    public static function getLimitListToUser($limit)
    {
        $defaultData = self::getAttribute('defaultAll');
        $cateIdArr = $defaultData['cate_id_arr'];
        $condition = [];
        $condition[] = ['cate_id', 'in', $cateIdArr];
        $condition[] = ['status', '=', 1];
        $conditionParam = [
            'limit' => $limit
        ];
        $result = self::getLimitData($condition, $conditionParam);
        return $result;
    }
}
