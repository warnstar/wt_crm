<?php
namespace frontend\controllers;

use common\lib\WeChatAuth;
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
                        'actions' => ['login','login_validate', 'error','logout'],
                        'allow' => true,
                    ]
                ],
            ],
        ];
    }


    public function actionLogin(){
        $get = Yii::$app->request->get();

        (new WeChatAuth())->UserAuthory();

    }

    public function actionGetUserInfo(){
        echo "user";
    }
}
