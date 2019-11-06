<?php


namespace app\api\controller;
//定义验证token
define("TOKEN", "fan982674");
class Wechat extends Base
{
	//客户端数据
	public function valid(){     
	    //客户端提交的数据 
	    if(!isset($_GET["echostr"])) {  
	        $this->responseMsg(); 
	        exit;         
	    }else{
	      //首次交手
	      //处理 微信客户端提交的数据值 token验证
	      if($this->checkSignature()){
	        $echoStr = $_GET["echostr"];
	        echo $echoStr;
	        exit;
	      }
	    }
	}

	//验证签名  token
	private function checkSignature(){
		//参数     
		$signature = $_GET["signature"];
		$timestamp = $_GET["timestamp"];
		$nonce = $_GET["nonce"];  

		$token = TOKEN;

		$tmpArr = array($token, $timestamp, $nonce);
		//加密
		sort($tmpArr);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		//是否相等
		if( $tmpStr == $signature ){
		  return true;
		}else{
		  return false;
		}
	}
}

