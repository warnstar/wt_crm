<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/27
 * Time: 18:04
 */

namespace common\lib;


class WeChatAuth
{
	private $AppID = "wx1e713d7916bd3d33";
	private $AppSecret = "3c80a1eb8eeebebaa121ef9b241154c5";
	private $server_api = "http://wtfront.xlooit.com/index.php?r=site/getUserInfo";


	public function UserAuthory(){

		$auth_url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=". $this->AppID . "&redirect_uri=" . $this->server_api . "&response_type=code&scope=snsapi_login&state=1#wechat_redirect";
		header('Location: '.$auth_url);
	}

	//获取微信用户信息/显示个人中心
	public function getUserInfo(){
		$code = $_GET["code"];
		$get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$this->AppID.'&secret='.$this->AppSecret.'&code='.$code.'&grant_type=authorization_code';

		$token_res = $this->curl($get_token_url);


		//根据openid和access_token查询用户信息
		$access_token = $token_res['access_token'];
		$openid = $token_res['openid'];
		$get_user_info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';

		$user = $this->curl($get_user_info_url);

		return $user;
	}


	private function curl($get_token_url){
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$get_token_url);
		curl_setopt($ch,CURLOPT_HEADER,0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		$res = curl_exec($ch);
		curl_close($ch);
		$json_obj = json_decode($res,true);

		return $json_obj;
	}
}