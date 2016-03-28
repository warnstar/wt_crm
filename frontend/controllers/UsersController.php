<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/28
 * Time: 14:58
 */

namespace frontend\controllers;


use yii\web\Controller;

class UsersController extends Controller
{


	public function actionMgu_list(){
		return $this->renderPartial("mgu_list");
	}
	public function actionDetail(){
		return $this->renderPartial("users_detail");
	}
}