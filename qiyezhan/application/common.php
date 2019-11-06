<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件


//使用curl 发送get/post请求 第二个参数有值是是post请求
function curl($url,$fields=[]){
	$ch = curl_init();
	//设置我们请求的地址
	curl_setopt($ch, CURLOPT_URL, $url);
	//数据返回都不要直接显示
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	//禁止证书校验
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	//判断是否是post请求
	if($fields){
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	}
	$data = '';
	if(curl_exec($ch)){
		//发送成功，获取数据
		$data = curl_multi_getcontent($ch);
	  
	}
	curl_close($ch);
	return $data;
}
