<?php
namespace frontend\controllers;

use common\lib\WeChatAuth;
use common\models\Users;
use yii;
use yii\web\Controller;
use yii\filters\AccessControl;
/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login','login_validate','weChat', 'error','logout'],
                        'allow' => true,
                    ]
                ],
            ],
        ];
    }


    public function actionLogin(){

        $get = Yii::$app->request->get();
        $users = (new Users())->find()->all();

        (new WeChatAuth())->UserAuthory();

    }

    public function actionGetUserInfo(){
        echo "user";
    }
}
