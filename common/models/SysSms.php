<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/22
 * Time: 11:38
 */

namespace common\models;

use common\lib\Sms;

class SysSms
{
	/**
	 * 待访客户通知、异常备注通知
	 * @param $phone
	 * @return mixed
	 */
	public function undo_notice($phone){
		$content = "你还有未处理的问题，请及时登录系统处理。";
		$res = (new Sms())->sendMessage($phone,$content);
		return $res;
	}

	/**
	 * 待处理异常通知
	 *
	 * @param $phone
	 * @param $user_id
	 * @return bool|mixed
	 */
	public function error_notice($phone,$user_id){
		$user = (new Users())->find()->where(['id'=>$user_id])->one();
		if($user){
			$content = "客服在向" . $user->name . "（护照号：" . $user->passport . "）回访时遇到问题，需要你的帮助，请登录系统查看";
			$res = (new Sms())->sendMessage($phone,$content);
			return $res;
		}else{
			return false;
		}
	}

	public function sendBirthDayGreeting($phone){

	}
	public function sendFestivalGreeting($phone,$content){

	}
}