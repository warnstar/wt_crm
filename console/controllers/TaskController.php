<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/21
 * Time: 21:02
 */
namespace console\controllers;


use common\models\Festival;
use common\models\Medical_group_user;
use common\models\SysSms;
use common\models\Users;
use common\models\Visit;

class TaskController extends \yii\console\Controller
{

	public function actionUndoNotice(){
		$this->UnDeal();
		$this->UnVisit();
	}

	//给今天生日的客户发送祝福短信
	public function actionBirthday(){
		$users = (new Users())->getBirthDayUsers();

		if($users){
			foreach($users as $v){
				$sms_log[] = (new SysSms())->sendBirthDayGreeting($v['phone'],$v['name']);
			}
		}
		return null;
	}
	//发送节日祝福短信
	public function actionFestival(){


		$festival = (new Festival())->getTodayFestival();
		if($festival){
			$users = (new Users())->find()->asArray()->all();
			if($users){
				foreach($users as $v){
					$sms_log[] = (new SysSms())->sendFestivalGreeting($v['phone'],$festival['greeting']);
				}
			}
		}
		return null;
	}



	//给有待访客户的客服发送通知
	private function UnVisit(){
		$workers = (new Visit())->un_deal_brand();
		$sms_log = [];
		if($workers){
			foreach($workers as $worker){
				$sms_log[] = (new SysSms())->undo_notice($worker['phone']);
			}
		}
		return null;
	}

	//给有待处理客服问题的对接人员发送通知
	public function UnDeal(){
		$workers = (new Medical_group_user())->un_visit_brands();
		$sms_log = [];
		if($workers){
			foreach($workers as $worker){
				$sms_log[] = (new SysSms())->undo_notice($worker['phone']);
			}
		}
		return null;
	}


}
