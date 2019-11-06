<?php

namespace app\admin\controller;


use app\common\func\PasswordFunc;
use app\common\record\AdminRecord;
use app\common\service\AdminService;
use think\captcha\Captcha;

class Login extends Base
{
    public $isMustLogin = false;

    //登录
    public function login()
    {
        $url = url('admin/index/index', '', true, true);
        if ($this->request->isPost()) {
            $username = $this->request->param('username', '');
            $password = $this->request->param('password', '');
            $code = $this->request->param('code', '');
            $captcha = new Captcha();
            if (!$captcha->check($code, 'admin_login')) {
                return $this->jsonError('验证码错误');
            }
            $condition = [
                ['username', '=', $username]
            ];

            $admin = AdminService::getInfo($condition);
            if (!$admin) {
                return $this->jsonError('该账号不存在');
            }
            $passwordAdmin = $admin['password'];
            $passwordCheck = PasswordFunc::check($password, $passwordAdmin);
            if ($passwordCheck == false) {
                return $this->jsonError('账号或密码错误');
            }
            //登录成功后, 更新登录时间
            $updateData = ['login_time' => $_SERVER['REQUEST_TIME']];
            AdminRecord::updateById($admin['id'], $updateData);

            unset($admin['password']);
            session($this->adminSessionName, $admin);
            $data = [
                'admin' => $admin
            ];
            return $this->jsonSuccess('登录成功', $data, $url);
        } else {
            $admin = session($this->adminSessionName);
            if ($admin) {
                return $this->redirect($url);
            }
            return view('login');
        }
    }

    //验证码
    public function verify()
    {
        $config = [
            'length' => 4,
        ];
        $captcha = new Captcha($config);
        return $captcha->entry('admin_login');
    }

    //退出
    public function logout()
    {
        session($this->adminSessionName, null);
        $url = url('admin/index/index', '', true, true);
        $this->redirect($url);
    }
}
