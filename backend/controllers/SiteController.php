<?php
namespace backend\controllers;


use common\models\Worker;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;

use backend\models\SignupForm;


/**
 * Site controller
 */
class SiteController extends Controller
{
    public $enableCsrfValidation = false;

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
                        'actions' => ['login','login_validate','captcha', 'error','logout'],
                        'allow' => true,
                    ]
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' =>  [
                'class' => 'yii\captcha\CaptchaAction',
                'height' => 50,
                'width' => 80,
                'minLength' => 4,
                'maxLength' => 4
            ],
        ];
    }


    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        return $this->renderPartial('login');
    }

    public function actionLogin_validate(){
        $worker = new Worker();


        $worker->phone =Yii::$app->request->post("phone");
        $worker->password = md5(Yii::$app->request->post("password"));


        $msg['status'] = 0;
        if ($worker = $worker->login()) {
            $session = Yii::$app->session;

            $worker_arr = (new Worker())->detail($worker->id);
            $session->set('worker',$worker_arr);

            $msg['status'] = 1;
            if($worker['role_id'] == 1){
                $msg['url'] = Url::toRoute("users/list");
            }else if($worker['role_id'] == 2){
                $msg['url'] = Url::toRoute("visit/un_visit_list");
            }else if($worker['role_id'] == 3){
                $msg['url'] = Url::toRoute("visit/error_un_do");
            }else{
                $msg['status'] = 0;
            }

        } else {
            $msg['status'] = 0;
        }

        return json_encode($msg);
    }

    public function actionLogout()
    {
        $session = Yii::$app->session;
        $session->open();
        $session->destroy();

        $this->redirect(Url::toRoute("site/login"));
    }
}
