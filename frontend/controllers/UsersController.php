<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/28
 * Time: 14:58
 */

namespace frontend\controllers;


use common\lib\Vote;
use common\models\Area;
use common\models\Medical_group;
use common\models\Medical_group_user;
use common\models\Note;
use common\models\Users;
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
			return $this->renderPartial("users/mgu_list",$data);
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

					$data['visit_notes'] = [];
					if($user['last_mgu']){
						$option['mgu_id'] = $mgu_id;
						$option['user_view'] = 1;
						$data['visit_notes'] = (new Note())->search($option);
					}

					return $this->renderPartial("users/users_detail_more",$data);
				}else{
					$data['user'] = $user;

					$data['visit_notes'] = [];
					if($user['last_mgu']){
						$option['mgu_id'] = $user['last_mgu'];
						$option['user_view'] = 1;
						$data['visit_notes'] = (new Note())->search($option);
					}
					return $this->renderPartial("users/users_detail",$data);
				}

			}else{
				return "用户不存在";
			}
		}else{
			return "无权限";
		}
	}

	/**
	 * ==============================================客服端结束==========================================================
	 * @return string|yii\web\Response
	 */




	/**
	 * ==============================================职员端开始==========================================================
	 * @return string|yii\web\Response
	 */

	public function actionMgu_list_worker(){
		$user_id = Yii::$app->request->get("user_id");

		if($user_id){
			$option['user_id'] = $user_id;
			$groups = (new Medical_group_user())->search($option,false);

			$data['groups'] = $groups['list'];

			return $this->renderPartial("mgu_list",$data);
		}else{
			return $this->goBack();
		}
	}


	public function actionDetail_worker(){
		$user_id = Yii::$app->request->get("user_id");

		if($user_id){
			$user = (new Users())->detail($user_id);
			if($user){
				$mgu_id = Yii::$app->request->get("mgu_id");
				//从疗程足迹过来
				if($mgu_id){
					$data['user'] = (new Medical_group_user())->detail($mgu_id);

					$data['visit_notes'] = [];
					if($user['last_mgu']){
						$option['mgu_id'] = $mgu_id;
						//大区经理的权限范围
						if($this->role_id !=2 && $this->role_id !=3){
							$option['user_view'] = 1;
						}
						$data['visit_notes'] = (new Note())->search($option);
					}

					return $this->renderPartial("users_detail_more",$data);
				}else{
					$data['user'] = $user;

					$data['visit_notes'] = [];
					if($user['last_mgu']){
						$option['mgu_id'] = $user['last_mgu'];
						//大区经理的权限范围
						if($this->role_id !=2 && $this->role_id !=3){
							$option['user_view'] = 1;
						}
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


	public function actionSearch(){

		return $this->renderPartial("users_search");
	}

	public function actionList(){
		$option = [];
		//限制区域
		if($this->area_id != 0){
			if($this->role_id == 5){//区域总监
				$option['area_higher_id'] = $this->area_id;
			}else if($this->role_id == 6){//大区经理
				$option['area_id'] = $this->area_id;
			}
		}
		//限制品牌
		$option['brand_id'] = $this->brand_id;


		$get = Yii::$app->request->get();
		//搜索
		if(isset($get['search']) && $get['search']){
			$option['search'] = $get['search'];
		}
		//筛选出团
		if(isset($get['medical_group_id']) && $get['medical_group_id']){
			$option['medical_group_id'] = $get['medical_group_id'];
		}

		//筛选区域
		if(isset($get['area_id']) && $get['area_id']){
			if($this->role_id != 6){//大区经理
				$option['area_id'] = $get['area_id'];
			}
		}
		//筛选上级区域
		if(isset($get['area_higher_id']) && $get['area_higher_id']){
			$option['area_higher_id'] = $get['area_higher_id'];

		}

		$res = (new Users())->search($option,false);
		$data['users'] = $res['list'];

		/**
		 * 获取出团列表
		 */
		$group_mui = (new Medical_group())->getGroupsMui($this->brand_id);
		$data['medical_groups'] = json_encode($group_mui);

		/**
		 * 获取区域列表
		 */
		$area_mui = (new Area())->getAreaMui($this->role_id,$this->area_id);
		$data['areas'] = json_encode($area_mui);
		

		return $this->renderPartial("users_list",$data);
	}

	public function actionAdd(){
		/**
		 * 获取区域列表
		 */
		$area_mui = (new Area())->getAreaMui($this->role_id,$this->area_id);
		$data['areas'] = json_encode($area_mui);


		return $this->renderPartial("users_add",$data);
	}

	public function actionSave(){
		$post = Yii::$app->request->post();
		$user = new Users();


		if(isset($post['id']) && $post['id']){
			$user = (new Users())->findOne($post['id']);
		}
		$user->name = isset($post['name']) ? $post['name'] : null;
		$user->sex = isset($post['sex']) ? $post['sex'] : null;
		$user->birth = isset($post['birth']) ? strtotime($post['birth']) : null;
		$user->birth_day = date("md",$user->birth);
		$user->phone = isset($post['phone']) ? $post['phone'] : null;
		$user->passport = isset($post['passport']) ? $post['passport'] : null;
		$user->area_id = isset($post['area_id']) ? $post['area_id'] : null;
		$user->cases_code = isset($post['cases_code']) ? $post['cases_code'] : null;

		//创建的时候
		if(!$user->id){
            if($this->role_id != 1){
                $user->brand_id = $this->brand_id;
            }
			$user->create_time = time();
		}
		$msg['status'] = 0;

		if($user->exist()){
			$msg['error'] = "护照号和病历号不能重复！";
		}else{

			if($user->save()){
				$msg['status'] = 1;
			}else{
				$msg['error'] = "操作失败！";
			}
		}

		return json_encode($msg);
	}
	public function actionTest(){

	}
}