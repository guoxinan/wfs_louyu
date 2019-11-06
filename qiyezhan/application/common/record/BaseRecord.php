<?php

namespace app\common\record;

class BaseRecord
{
    //添加或更新 --主要在后台使用--后台通用添加或更新
    //$type == 'insert' 添加
    //$type == 'update' 更新
    public static function saveData($data, $type)
    {
        if (!in_array($type, ['insert', 'update'])) {
            $result = ['code' => 1, 'message' => '错误的类型', 'data' => []];
            return $result;
        }
        $checkResult = self::checkData($data, $type);
        if ($checkResult !== true) {
            $result = ['code' => 1, 'message' => $checkResult, 'data' => []];
            return $result;
        }
        $dealData = self::dealData($data, $type);
        if ($dealData === false) {
            $result = ['code' => 1, 'message' => '处理数据失败', 'data' => []];
            return $result;
        }
        $model = self::_getModelInstance();
        $model = ($type == 'update') ? $model->isUpdate(true) : $model->isUpdate(false);
        $updateResult = $model->allowField(true)->save($data);
        if ($updateResult === true) {
            $result = ['code' => 0, 'message' => '更新数据成功', 'data' => $model];
        } else {
            $result = ['code' => 2, 'message' => '更新数据失败', 'data' => []];
        }
        return $result;
    }

    //添加
    public static function insert($data)
    {
        $model = self::_getModelInstance();
        $insertResult = $model->allowField(true)->save($data);
        if ($insertResult === true) {
            $result = ['code' => 0, 'message' => '添加数据成功', 'data' => $model];
        } else {
            $result = ['code' => 1, 'message' => '添加数据失败', 'data' => []];
        }
        return $result;
    }

    //更新
    public static function update($condition, $data)
    {
        $model = self::_getModelInstance();
        $updateResult = $model->allowField(true)->save($data, $condition);
        if ($updateResult === true) {
            $result = ['code' => 0, 'message' => '更新数据成功', 'data' => $model];
        } else {
            $result = ['code' => 1, 'message' => '更新数据失败', 'data' => []];
        }
        return $result;
    }

    //删除
    public static function delete($condition)
    {
        $model = self::_getModelInstance();
        $result = $model->where($condition)->delete();
        return $result;
    }

    //删除--主要在后台使用--后台通用删除
    public static function deleteById($id)
    {
        $data = ['id' => $id];
        $checkResult = self::checkData($data, 'delete');
        if ($checkResult !== true) {
            $result = ['code' => 1, 'message' => $checkResult, 'data' => []];
            return $result;
        }
        $model = self::_getModelInstance();
        $condition = [];
        if (is_array($id)) {
            $condition[] = ['id', 'in', $id];
        } else {
            $condition[] = ['id', '=', $id];
        }
        $result = $model->where($condition)->delete();
        return $result;
    }

    //批量添加
    public static function insertAll($data)
    {
        $model = self::_getModelInstance();
        $result = $model->saveAll($data);
        return $result;
    }

    //插入 更新 删除 验证数据
    //type == 'insert' 插入
    //type == 'update' 更新
    //type == 'del' 删除
    //返回时 true 时 验证通过, 其它字符串时, 错误信息
    //判断时  需要全等于(===)
    public static function checkData($data = [], $type = '')
    {
        switch ($type) {
            case 'insert':
                return static::checkInsertData($data);
                break;
            case 'update':
                return static::checkUpdateData($data);
                break;
            case 'delete':
                return static::checkDeleteData($data);
                break;
            default:
                return true;
        }
    }

    //返回时 true 时 验证通过, 其它字符串时, 错误信息
    public static function checkInsertData($data)
    {
        return true;
    }

    //返回时 true 时 验证通过, 其它字符串时, 错误信息
    public static function checkUpdateData($data)
    {
        return true;
    }

    //返回时 true 时 验证通过, 其它字符串时, 错误信息
    public static function checkDeleteData($data)
    {
        return true;
    }

    //插入 更新 删除 处理数据
    //type == 'insert' 插入
    //type == 'update' 更新
    //type == 'del' 删除
    //返回时 true 时 验证通过, 其它字符串时, 错误信息
    //判断时  需要全等于(===)
    public static function dealData($data, $type = '')
    {
        switch ($type) {
            case 'insert':
                return static::dealInsertData($data);
                break;
            case 'update':
                return static::dealUpdateData($data);
                break;
            default:
                return $data;
        }
    }

    //返回时 true 时 验证通过, 其它字符串时, 错误信息
    public static function dealInsertData($data)
    {
        return $data;
    }

    //返回时 true 时 验证通过, 其它字符串时, 错误信息
    public static function dealUpdateData($data)
    {
        return $data;
    }

    //返回值
    //$modelInstance 对应的类 或者 对应类的对象
    public static function getModelClass()
    {
        //return 'Adv';
        //或者
        //$model = new \app\common\model\Adv();
        //return $model;
        return '';
    }

    // 取 model类 的对象
    private static function _getModelInstance()
    {
        $modelClass = static::getModelClass();
        if (is_object($modelClass)) {
            return $modelClass;
        } else if ($modelClass != '') {
            $object = app()->create($modelClass, 'model', false, 'common');
            return $object;
        } else {
            $modelName = self::_getCurrentClassName();
            $object = app()->create($modelName, 'model', false, 'common');
            return $object;
        }
    }

    // 取当前类的名称
    private static function _getCurrentClassName($isSuffix = true)
    {
        $class = get_called_class();
        $filename = str_replace('\\', '/', $class);
        $className = basename($filename);
        if ($isSuffix) {
            $suffix = basename(dirname($filename));
            $className = substr($className, 0, -strlen($suffix));
        }
        return $className;
    }

}
