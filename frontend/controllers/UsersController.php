<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/28
 * Time: 14:58
 */

namespace frontend\controllers;


use common\models\Note;
use common\models\Users;
use common\models\UsersExtra;
use yii\web\Controller;
use yii;


class UsersController extends CommonController
{


	public function actionMgu_list(){
		return $this->renderPartial("mgu_list");
	}
	public function actionDetail(){
		$session = Yii::$app->session;
		$session->open();

		$user_id = $session->get("user_id");
		if($user_id){
			$user = (new Users())->detail($user_id);
			if($user){
				$data['user'] = $user;
				if($user['last_mgu']){
					$option['mgu_id'] = $user['last_mgu'];
					$option['user_view'] = 1;
					$data['visit_notes'] = (new Note())->search($option);
				}
				
				return $this->renderPartial("users_detail",$data);
			}else{
				echo "用户不存在";
			}

		}else{
			echo "无权限";
		}

	}


	public function actionBind(){
		return $this->renderPartial("bind");
	}

	public function actionBind_save(){
		$post = Yii::$app->request->post();

		$passport = isset($post['passport']) ? $post['passport'] : null;
		$name = isset($post['name']) ? $post['name'] : null;

		//验证用户是否存在
		$user = (new Users())->find()->where(['passport'=>$passport,'name'=>$name])->one();
		$msg['status'] = 0;
		if($user){
			//进行绑定
			$session = Yii::$app->session;
			$session->open();
			$bind_extra_uid = $session->get("bind_extra_uid");
			if($bind_extra_uid){

				$extra = (new UsersExtra())->createBind($bind_extra_uid,$user->id);
				if($extra){
					//绑定成功
				}else{
					//绑定失败
				}
			}else{
				//直接登陆
			}

			//无论无何都是登陆成功
			$msg['status'] = 1;
			$msg['url'] = yii\helpers\Url::toRoute("users/detail");
			$session->set("user_id",$user->id);

		}else{
			$msg['error'] = "用户不存在,请联系客服！";
		}
		return json_encode($msg);
	}
	
}