<?php


namespace app\admin\controller;

use app\common\service\NodeService;
use think\Controller;

class Base extends Controller
{
    //true 需要进行登录验证, false 不需要
    public $isMustLogin = true;
    public $serviceClassName = '';
    public $recordClassName = '';
    public $admin = [];
    public $adminSessionName = 'admin';

    //初始化执行
    protected function initialize()
    {
        //验证登录
        $admin = session($this->adminSessionName);
        if ($this->isMustLogin && !$admin) {
            $loginUrl = url('admin/login/login');
            $this->redirect($loginUrl);
        }
        if ($admin) {
            $this->admin = $admin;
            $roleId = $admin['role_id'];
            $topNodeList = NodeService::getTopListByRoleId($roleId);
            $topFirstId = 0;
            if (!empty($topNodeList)) {
                $topFirstId = $topNodeList[0]['id'];
            }
            $this->assign('admin', $admin);
            $this->assign('top_node_list', $topNodeList);
            $this->assign('top_first_id', $topFirstId);
        }
    }

    //设置 service 类
    protected function getServiceClass($name = '')
    {
        if (empty($name)) {
            $name = $this->getCurrentClassName($isSuffix = false);
        }
        $object = app()->create($name, 'service', 'Service', $common = 'common');
        return $object;
    }

    //设置 record 类
    protected function getRecordClass($name = '')
    {
        if (empty($name)) {
            $name = $this->getCurrentClassName($isSuffix = false);
        }
        $object = app()->create($name, 'record', 'Record', 'common');
        return $object;
    }

    // 取当前类的名称
    protected function getCurrentClassName($isSuffix = false)
    {
        $class = get_called_class();
        $filename = str_replace('\\', '/', $class);
        $className = basename($filename);
        if ($isSuffix) {
            $suffix = basename(dirname($className));
            $className = substr($className, 0, -strlen($suffix));
        }
        return $className;
    }

    /******************************************************/
    //
    //搜索条件
    protected function getCondition($params)
    {
        $condition = [];
        if (array_key_exists('id', $params) && $params['id'] !== '') {
            $condition[] = ['id', '=', $params['id']];
        }
        return $condition;
    }

    //搜索条件的其它参数, 例如排序,分页等
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
        return $result;
    }
    /******************************************************/
    //通用 列表
    //取列表
    public function lists()
    {
        $paramData = $this->request->param();
        if (method_exists($this, '_dealParam')) {
            $paramData = $this->_dealParam($paramData, 'lists');
        }
        $data = $this->getList($paramData);
        return $this->jsonSuccess('列表数据', $data);
    }

    //取列表
    public function getList($paramData)
    {
        //搜索条件
        $condition = $this->getCondition($paramData);
        //排序等条件
        $paramData = $this->getConditionExtra($paramData, 'lists');
        //取列表数据
        $serviceClass = $this->getServiceClass($this->serviceClassName);
        $lists = $serviceClass::getPageData($condition, $paramData);
        if (method_exists($this, '_lists')) {
            $lists = $this->_lists($lists);
        }
        $count = $serviceClass::getCount($condition);
        $data = [
            'data' => $lists,
            'count' => $count,
        ];
        return $data;
    }
    //取详情
    public function info()
    {
        //组合搜索条件
        $paramData = $this->request->param();
        if (method_exists($this, '_dealParam')) {
            $paramData = $this->_dealParam($paramData, 'lists');
        }
        $condition = $this->getCondition($paramData);
        //排序等条件
        $paramData = $this->getConditionExtra($paramData, 'info');
        $serviceClass = $this->getServiceClass($this->serviceClassName);
        $info = $serviceClass::getInfo($condition, $paramData);

        if (method_exists($this, '_info')) {
            $info = $this->_info($info);
        }
        $data = [
            'info' => $info
        ];
        return $this->jsonSuccess('详情', $data);
    }
    /******************************************************/
    //通用 添加, 修改, 删除方法 ----------------------- 开始
    //插入
    public function insert()
    {
        $paramData = $this->request->param();
        if (method_exists($this, '_dealParam')) {
            $paramData = $this->_dealParam($paramData, 'insert');
        }
        $recordClass = $this->getRecordClass($this->recordClassName);
        $saveResult = $recordClass::saveData($paramData, 'insert');
        if ($saveResult['code'] == 1) {
            return $this->jsonError($saveResult['message']);
        } else if ($saveResult['code'] === 2) {
            return $this->jsonError('添加数据失败');
        } else {
            return $this->jsonSuccess('添加数据成功', $saveResult['data']);
        }
    }

    //更新
    public function update()
    {
        $paramData = $this->request->param();
        if (method_exists($this, '_dealParam')) {
            $paramData = $this->_dealParam($paramData, 'update');
        }
        $recordClass = $this->getRecordClass($this->recordClassName);
        $saveResult = $recordClass::saveData($paramData, 'update');
        if ($saveResult['code'] == 1) {
            return $this->jsonError($saveResult['message']);
        } else if ($saveResult['code'] === 2) {
            return $this->jsonError('更新数据失败');
        } else {
            return $this->jsonSuccess('更新数据成功', $saveResult['data']);
        }
    }

    //删除
    public function delete()
    {
        $id = $this->request->param('id', '');
        $recordClass = $this->getRecordClass();
        $result = $recordClass::deleteById($id);
        if ($result === false) {
            return $this->jsonError('删除失败');
        } else {
            return $this->jsonSuccess('删除成功');
        }
    }
    /******************************************************/
    //返回json格式方法相关  ----------------------------开始
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
    //返回json格式方法相关  ----------------------------结束
    /******************************************************/

    /******************************************************/
    //直接输出 视图文件 ------------------------------- 开始
    /******************************************************/
    public function index()
    {
        if (method_exists($this, '_data')) {

            $this->_data();
        }
        return view('index');
    }

    public function add()
    {
        if (method_exists($this, '_data')) {
            $this->_data();
        }
        return view('add');
    }

    public function edit()
    {
        if (method_exists($this, '_data')) {
            $this->_data();
        }
        return view('edit');
    }

    public function _empty($name)
    {
        $controller = $this->request->controller(true);
        return view($controller . '/' . $name);
    }
    //直接输出 视图文件 ------------------------------- 结束
    /******************************************************/

}