<?php

namespace app\admin\controller;

use app\common\record\RoleNodeRecord;
use app\common\record\RoleRecord;
use app\common\service\NodeService;
use app\common\func\NodeFunc;
use app\common\service\RoleNodeService;
use app\common\service\RoleService;
use app\common\model\Role as roleModel;
use app\common\model\RoleNode;
use think\Db;
class Role extends Base
{

    public function getCondition($params)
    {
        $condition = [];
        if (array_key_exists('id', $params) && $params['id'] !== '') {
            $condition[] = ['id', '=', $params['id']];
        }
        if (array_key_exists('title', $params) && $params['title'] !== '') {
            $condition[] = ['title', 'like', '%' . $params['title'] . '%'];
        }
        if (array_key_exists('status', $params) && $params['status'] !== '') {
            $condition[] = ['status', '=', $params['status']];
        }
        return $condition;
    }

    //搜索条件的其它参数, 例如排序等
    protected function getConditionExtra($params = [], $type = '')
    {
        $result = [];
        switch ($type) {
            case 'info':
                break;
            case 'lists':
                $result['page'] = isset($params['page']) ? $params['page'] : 1;
                $result['page_size'] = isset($params['limit']) ? $params['limit'] : 1;
                break;
        }
        $result['orderby'] = ['id' => 'desc'];
        //$result['with'] = ['bindRole'];
        return $result;
    }

    public function _data(){
        $allData = NodeService::getAllData();
        $data = NodeFunc::toLayuiTreeData($allData);
        $this->assign('nodeTree',$data);
    }

    public function _info($info)
    {
        if (!empty($info)) {
            $condition = [['role_id', '=', $info['id']]];
            $roleNodeList = RoleNodeService::getAllData($condition);
            $nodeIdArr = array_column($roleNodeList, 'node_id');
            $info['node_id_arr'] = $nodeIdArr;
        }
        $condition = [];
        $allData = NodeService::getAllData($condition);
        $nodeList = NodeFunc::toLayuiTreeData($allData);
        $info['node_list'] = $nodeList;
        return $info;
    }

    public function insert(){
        $title = $this->request->param('title');
        $node_id_arr = $this->request->param('node_id_arr/a');
        //保存
        Db::startTrans();
        try {
            $roleModel = new roleModel();
            $roleModel->title = $title;
            $roleModel->save();//添加数据
            $roleId = $roleModel->id;//获取自增ID
            $data = [];
            foreach ($node_id_arr as $key){
                $data[] = ['node_id'=>$key,'role_id'=>$roleId];
            }
            $roleNodeModel = new RoleNode();
            $res = $roleNodeModel->saveAll($data);
            if($res && $roleId){
                // 提交事务
                Db::commit();
                return $this->jsonSuccess('操作成功');
            }
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return $this->jsonError('操作失败');
        }
    }


    public function update(){
        $id = $this->request->param('id');
        $title = $this->request->param('title');
        $node_id_arr = $this->request->param('node_id_arr/a');
        //保存
        Db::startTrans();
        try {
            $res1 = RoleRecord::update(['id'=>$id],['title'=>$title]);
            foreach ($node_id_arr as $key){
                $data[] = ['node_id'=>$key,'role_id'=>$id];
            }
            $roleNodeModel = new RoleNode();
            //删除role_id = $id的所有数据
            $res2 = $roleNodeModel->where(['role_id'=>$id])->delete();
            $res3 = $roleNodeModel->saveAll($data);
            if($res1 !== false && $res2 !== false && $res3 !== false ){
                // 提交事务
                Db::commit();
                return $this->jsonSuccess('操作成功');
            }
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return $this->jsonError('操作失败');
        }
    }


    public function del(){
        $id = $this->request->param('id');
        $res = RoleRecord::delete(['id'=>$id]);
        if($res !== false) return $this->jsonSuccess('删除成功');
        return $this->jsonError('删除失败');
    }



}
