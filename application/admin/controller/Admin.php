<?php

namespace app\admin\controller;
use app\common\record\AdminRecord;
use app\common\service\RoleService;
use app\common\service\AdminService;
use app\common\func\PasswordFunc;
class Admin extends Base
{
    public function getCondition($params)
    {
        $condition = [];
        if (array_key_exists('id', $params) && $params['id'] !== '') {
            $condition[] = ['id', '=', $params['id']];
        }
        if (array_key_exists('username', $params) && $params['username'] !== '') {
            $condition[] = ['username', 'like', '%' . $params['username'] . '%'];
        }
        if (array_key_exists('status', $params) && $params['status'] !== '') {
            $condition[] = ['status', '=', $params['status']];
        }
        if (array_key_exists('type', $params) && $params['type'] !== '') {
            $condition[] = ['type', '=', $params['type']];
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
        //$result['orderby'] = ['id' => 'desc'];
        $result['with'] = ['bindRole'];
        return $result;
    }

    public function _info($info)
    {
        if (!empty($info)) {
            unset($info['password']);
        }
        return $info;
    }



    public function info(){
        $id = $this->request->param('id');
        $info = AdminService::getInfo(['id'=>$id]);
        unset($info['password']);
        $data=[];
        $data['info'] = $info;
        return $this->jsonSuccess('详情',$data);
    }

    public function update(){
        $username= $this->request->param('username');
        $mobile = $this->request->param('mobile');
        $password = $this->request->param('password')? $this->request->param('password') : 123456;
        $role_id = $this->request->param('role_id');
        $status = $this->request->param('status');
        $id = $this->request->param('id');
        $password =PasswordFunc::encrypt($password);
        $condition = [
            'id'=>$id,
        ];
        $data = [
            'username'=>$username,
            'mobile'=>$mobile,
            'password'=>$password,
            'role_id'=>$role_id,
            'status'=>$status,
        ];
        $res = AdminRecord::update($condition,$data);
        if($res === false) return $this->jsonError('保存失败');
        return $this->jsonSuccess('保存成功');
    }


    public function _data()
    {
        $statusList = AdminService::getAttribute('statusList');
        $roleList = RoleService::getAllData();
        $this->assign('status_list', $statusList);
        $this->assign('role_list', $roleList);
    }

    public function detail()
    {
        $adminId = $this->admin['id'];
        $condition = [];
        $condition[] = ['id', '=', $adminId];
        $info = AdminService::getInfo($condition);
        $data = ['info' => $info];
        return view('detail', $data);
    }

    public function changePassword()
    {
        $oldPassword = $this->request->param('oldPassword', '');
        $newPassword = $this->request->param('newPassword', '');
        $reNewPassword = $this->request->param('reNewPassword', '');
        $adminId = $this->admin['id'];
        $result = AdminRecord::updatePassword($adminId, $oldPassword, $newPassword, $reNewPassword);
        if ($result === true) {
            return $this->jsonSuccess('修改成功');
        } else if ($result === false) {
            return $this->jsonError('修改失败');
        } else {
            return $this->jsonError($result);
        }
    }

    public function del(){
        $id = $this->request->param('id');
        $res = AdminRecord::delete(['id'=>$id]);
        if($res !== false){
            return $this->jsonSuccess('删除成功');
        }else{
            return $this->jsonError('删除失败');
        }
    }



}
