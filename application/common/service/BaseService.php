<?php

namespace app\common\service;


class BaseService
{
    protected static $modelInstance;
    protected static $field = '*';
    public static $orderby = ['id' => 'desc'];

    //取数据-一条
    public static function getInfo($condition, $params = [])
    {
        $orderby = static::getOrderBy($params);
        $params['condition'] = $condition;
        $params['orderby'] = $orderby;
        $result = self::_getData($params, 'info');
        return $result;
    }

    //取数据-全部
    public static function getAllData($condition = [], $params = [],$with = [])
    {
        $orderby = static::getOrderBy($params);
        $params['condition'] = $condition;
        $params['orderby'] = $orderby;
        $params['with'] = $with;
        $result = self::_getData($params, 'all');
        return $result;
    }

    //取数据-指定条数
    public static function getLimitData($condition, $params = [])
    {
        $orderby = static::getOrderBy($params);
        $params['condition'] = $condition;
        $params['orderby'] = $orderby;
        $result = self::_getData($params, 'limit');
        return $result;
    }

    //取数据-按分页
    public static function getPageData($condition, $params = [])
    {
        $orderby = static::getOrderBy($params);
        $params['condition'] = $condition;
        $params['orderby'] = $orderby;
        $result = self::_getData($params, 'page');
        return $result;

    }

    //取总数-按条件
    public static function getCount($condition)
    {
        $model = self::_getModelInstance();
        $result = $model->where($condition)->count();
        //echo $model->getLastSql();
        return $result;
    }

    //取一条或多条属性
    //$name 为字符串时 取一条属性
    //$name 为数组时 取多条属性
    public static function getAttribute($name)
    {
        $model = self::_getModelInstance();
        if (is_array($name)) {
            $result = [];
            foreach ($name as $key => $val) {
                $value = $model->$val;
                $result[$val] = $value;
            }
        } else {
            $result = $model->$name;
        }
        return $result;
    }

    //取数据
    //$params['field'] 查询字段
    //$params['condition'] 查询条件
    //$params['with'] 联合模型
    //$params['orderby'] 排序
    //$params['page'] 页码数
    //$params['page_size'] 每页条数
    //$params['limit'] 限制条数
    //$type == all 查询全部数据
    //$type == limit 查询限制条数的数据
    //$type == page 查询某一页的条数
    //$type == info 查询一条数据
    private static function _getData($params, $type = 'all')
    {
        $condition = self::_getValue('condition', $params, []);
        $field = self::_getValue('field', $params, static::$field);
        $orderby = self::_getValue('orderby', $params, static::$orderby);

        $model = self::_getModelInstance();
        if (array_key_exists('with', $params)) {

            $model = $model->with($params['with']);
        }
        if (array_key_exists('group', $params)) {
            $model = $model->group($params['group']);
        }
        if (array_key_exists('having', $params)) {
            $model = $model->having($params['having']);
        }
        $model = $model->field($field);
        $model = $model->where($condition);
        $model = $model->order($orderby);
        switch ($type) {
            case 'all':
                $collection = $model->select();
                break;
            case 'limit':
                $limit = self::_getValue('limit', $params, 10);
                $collection = $model->limit($limit)->select();
                break;
            case 'page':
                $page = self::_getValue('page', $params, 1);
                $pageSize = self::_getValue('page_size', $params, 10);
                $collection = $model->page($page, $pageSize)->select();
                break;
            case 'info':
                $collection = $model->find();
                if (!$collection) {
                    return [];
                }
                break;
            default:
                return [];
        }

        $result = $collection->toArray();
        return $result;
    }

    //返回值 查询排序
    protected static function getOrderBy($params = [])
    {
        $orderby = '';
        if (array_key_exists('orderby', $params)) {
            $orderby = $params['orderby'];
            if (is_array($orderby)) {
                return $orderby;
            }
        }
        switch ($orderby) {
            case 'id_asc':
                $result = ['id' => 'asc'];
                break;
            case 'id_desc':
                $result = ['id' => 'desc'];
                break;
            default:
                $result = static::$orderby;
        }
        return $result;
    }

    //返回值
    //$modelInstance 对应的类 或者 对应类的对象
    public static function getModelClass()
    {
        //return 'app\common\model\Adv';
        //或者
        //$model = \app\common\model\Adv;
        //return $model;
        return '';
    }

    // 取 model类 的对象
    private static function _getModelInstance()
    {
        $modelClass = static::getModelClass();
        if (is_object($modelClass)) {
            return $modelClass;
        }
        if (empty($modelClass)) {
            $class = get_called_class();
            $filename = str_replace('\\', '/', $class);
            $basename = basename($filename);
            $suffix = basename(dirname($filename));
            $modelName = substr($basename, 0, -strlen($suffix));
            $modelClass = 'app\common\model\\' . $modelName;
        }
        $classExists = class_exists($modelClass);
        if (!$classExists) {
            exit($modelClass . ' is not exist');
        }
        $result = new $modelClass();
        return $result;
    }

    //取数组中下标对应的值
    private static function _getValue($name, $arr, $default = '')
    {
        $result = $default;
        if (array_key_exists($name, $arr)) {
            $result = $arr[$name];
        }
        return $result;
    }
}
