<?php
namespace common\lib;

class Sms{

	private $base = [
			'account'   => "lyr",
			'password'  => "a123456"
	];

    const  BASE_URL  = "http://dx.ipyy.net/smsJson.aspx";

	const  SIGN_TEXT = "【创世华信】";

	//发送短信
	public function sendMessage($phone,$content){
		$post_data['action']    = 'send';
		$post_data['userid']    = '';
		$post_data['sendTime']  = '';
		$post_data['extno']     = '';
		$post_data['mobile']    =   $phone;
		$post_data['content']   =   $content . Sms::SIGN_TEXT;
	    $result = $this->_curl(self::BASE_URL,array_merge($post_data,$this->base));
	    return $result;
	}



	/**
	 * CURL Post
	 */
	private function _curl($url, $option, $header = array(), $type = 'POST') {
		array_push($header, 'Accept:*/*');
		array_push($header, 'Content-Type:multipart/form-data');
		$curl = curl_init (); // 启动一个CURL会话
		curl_setopt ( $curl, CURLOPT_URL, $url ); // 要访问的地址
		curl_setopt ( $curl, CURLOPT_SSL_VERIFYPEER, FALSE ); // 对认证证书来源的检查
		curl_setopt ( $curl, CURLOPT_SSL_VERIFYHOST, FALSE ); // 从证书中检查SSL加密算法是否存在
		curl_setopt ( $curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0)' ); // 模拟用户使用的浏览器
		if ($option) {
			curl_setopt ( $curl, CURLOPT_POSTFIELDS, $option ); // Post提交的数据包
		}

		curl_setopt ( $curl, CURLOPT_TIMEOUT, 30 ); // 设置超时限制防止死循环
		curl_setopt ( $curl, CURLOPT_HTTPHEADER, $header ); // 设置HTTP头
		curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 ); // 获取的信息以文件流的形式返回
		curl_setopt ( $curl, CURLOPT_CUSTOMREQUEST, $type );
		$result = curl_exec ( $curl ); // 执行操作
		curl_close ( $curl ); // 关闭CURL会话
		


		return json_decode($result,true);
	}




}


?>