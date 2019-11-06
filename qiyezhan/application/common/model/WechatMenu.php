<?php

namespace app\common\model;
/*
	*微信菜单
*/
class WechatMenu extends Base
{
	protected $append = ['status_name'];

	public function bindCate()
    {
        $bindArr = ['menu_name' => 'title'];
        return $this->belongsTo('Menu', 'menu_id')->bind($bindArr);
    }

    public function Menu(){
		return $this->hasOne('menu','id','menu_id');
	}
}
