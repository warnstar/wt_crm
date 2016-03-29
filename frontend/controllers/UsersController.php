<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/28
 * Time: 14:58
 */

namespace frontend\controllers;


use common\models\Medical_group_user;
use common\models\Note;
use common\models\Users;
use common\models\UsersExtra;
use yii\web\Controller;
use yii;


class UsersController extends CommonController
{


	public function actionMgu_list(){
		$session = Yii::$app->session;
		$session->open();

		$user_id = $session->get("user_id");
		if($user_id){
			$option['user_id'] = $user_id;
			$groups = (new Medical_group_user())->search($option,false);
			$data['groups'] = $groups['list'];
			return $this->renderPartial("mgu_list",$data);
		}else{
			return "无权限";
		}
	}
	public function actionDetail(){
		$session = Yii::$app->session;
		$session->open();

		$user_id = $session->get("user_id");
		if($user_id){
			$user = (new Users())->detail($user_id);
			if($user){
				$mgu_id = Yii::$app->request->get("mgu_id");
				//从疗程足迹过来
				if($mgu_id){
					$data['user'] = (new Medical_group_user())->detail($mgu_id);

					if($user['last_mgu']){
						$option['mgu_id'] = $mgu_id;
						$option['user_view'] = 1;
						$data['visit_notes'] = (new Note())->search($option);
					}

					return $this->renderPartial("users_detail_more",$data);
				}else{
					$data['user'] = $user;

					if($user['last_mgu']){
						$option['mgu_id'] = $user['last_mgu'];
						$option['user_view'] = 1;
						$data['visit_notes'] = (new Note())->search($option);
					}
					return $this->renderPartial("users_detail",$data);
				}

			}else{
				return "用户不存在";
			}
		}else{
			return "无权限";
		}
	}



	
}