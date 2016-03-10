<?php
namespace backend\controllers;

use app\controllers\CommonController;
use app\models\Area;
use Yii;

/**
 * Site controller
 */
class AreaController extends CommonController
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

        $data['area_list'] = (new Area())->find()->asArray()->all();

        return $this->render('area_list',$data);
    }

    public function actionDetail(){
        return $this->render('area_detail');
    }

    public function actionAdd(){
        return $this->render('area_add');
    }
}
