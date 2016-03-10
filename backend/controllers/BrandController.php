<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;

/**
 * Site controller
 */
class BrandController extends Controller
{


    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function  actionList(){

        return $this->render('brand_list');
    }

    public function actionDetail(){
        return $this->render('brand_detail');
    }

    public function actionAdd(){
        return $this->render('brand_add');
    }

    public function actionSave(){
        $post = Yii::$app->request->post();

    }
}
