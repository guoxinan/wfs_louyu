<?php
namespace app\admin\controller;
use app\common\service\UploadService;
use app\common\service\WechatService;
use app\common\service\WechatMenuService;
use app\common\service\MenuService;
use app\common\record\WechatMenuRecord;
/**
 * 微信菜单
 */
class WechatMenu extends Base
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
        $result['with'] = ['bindCate'];
        return $result;
    }

    public function _data()
    {
    	//导航菜单
        $menuList = MenuService::getAllData(['status'=>1]);
        $this->assign('menu_list', $menuList);

    	//微信菜单
        $condition = [['status', '=', 1],['pid','=',0]];
        $with = ['menu'];
        $wechatMenu = WechatMenuService::getAllData($condition,$params=[],$with);
        $this->assign('wechat_menu', $wechatMenu);
        $statusList = WechatMenuService::getAttribute('statusList');
        $this->assign('status_list', $statusList);
    }

    public function del(){
        $id = $this->request->param('id');
        $res = WechatMenuRecord::delete(['id'=>$id]);
        if($res !== false){
            return $this->jsonSuccess('删除成功');
        }else{
            return $this->jsonError('删除失败');
        }
    }

    public function create(){
        $condition = [['status','=',1],['pid','=',0]];
        $params = [];
        $with = ['menu'];
        $menuList = WechatMenuService::getAllData($condition,$params,$with);
        $menu = [];
        foreach ($menuList as $k => $v) {
            $menu[$k]['type'] = 'view';
            $menu[$k]['name'] = $v['menu']['title'];
            $menu[$k]['url'] = $v['menu']['href'];
            $condition = [['status','=',1],['pid','=',$v['id']]];
            $sub_menuList = WechatMenuService::getAllData($condition,$params,$with);
            foreach ($sub_menuList as $kk => $vv) {
                unset($menu[$k]['type']);
                unset($menu[$k]['url']);
                $menu[$k]['sub_button'][$kk]['type'] = 'view';
                $menu[$k]['sub_button'][$kk]['name'] = $vv['menu']['title'];
                $menu[$k]['sub_button'][$kk]['url'] = $vv['menu']['href'];
            }

        }
        $menu = json_encode($menu, JSON_UNESCAPED_UNICODE);

        $condition = [];
        $wechat = WechatService::getInfo($condition);
        if(empty(!$wechat['appid']) && empty(!$wechat['secret'])){
            $config = [
                'appId'     =>$wechat['appid'],
                'appsecret' =>$wechat['secret']
            ];
            $config = $this->accessToken($config);
            if(!isset($config['accessToken'])) {
                return $this->jsonError('公众号配置出错');
            }
            
            //创建按钮
            $xjson = '{ 
              "button":'.$menu.',
              "matchrule":{
                "tag_id":"2",
                "sex":"1",
                "country":"中国",
                "province":"河南",
                "city":"郑州",
                "client_platform_type":"2",
                "language":"zh_CN"
              }
            }';
            //$jsonMenu = json_encode($xjson);
            //创建菜单请求地址
            $post_url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$config['accessToken'];
            //创建自定义菜单
            $ch = curl($post_url,$xjson);
            $datas = json_decode($ch,true);
            if(isset($datas['errcode']) && $datas['errcode'] == 0){
                return $this->jsonSuccess('生成成功');
            }else{
                return $this->jsonError('生成失败',json_decode($ch,true));
            }

        }else{
            return $this->jsonError('生成失败');
        }
        dump($wechat);exit;  //老婆你干嘛呢
    }


    // 获取公众号的access_token;
    public function accessToken($config){
        //判断是否已生成access_token
        if(is_file('accessToken.txt')){
            //获取文件内容
            $file = file_get_contents('accessToken.txt');
            $file_arr = explode(",",$file);
            //判断access_token是否已过有效期
            if($file_arr[1] >= time()-7000){
                    //使用access_token
                $config['accessToken'] = $file_arr[0];
            }else{
                //过期   重新生成
                $url ='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$config['appId'].'&secret='.$config['appsecret'];   
                $accessToken =$this->curl($url);
                $datas = json_decode($accessToken,true);
                $config['accessToken'] = $datas['access_token'];
                //更换储存的access_token
                file_put_contents('wechat/accessToken.txt',$datas['access_token'].','.time());

            } 
        }else{
            //没有生成文件   生成
            $url ='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$config['appId'].'&secret='.$config['appsecret'];   
            $accessToken = curl($url);
            $datas = json_decode($accessToken,true);
            if(!isset($datas['access_token'])){
                return false;
            };
            $config['accessToken'] = $datas['access_token'];
            //储存的access_token
            file_put_contents('accessToken.txt',$datas['access_token'].','.time());
        }
        return $config;
    }
}