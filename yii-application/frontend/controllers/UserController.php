<?php
namespace frontend\controllers;
use app\models\Users;
use common\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\rest\ActiveController;
use frontend\models\SignupForm;
use yii\web\ServerErrorHttpException;

class UserController extends BaseApiController
{
    public $modelClass = 'app\models\Users';
    public $password;

    public function actions()
    {
        $actions = parent::actions();

        // отключить действия "delete" и "create"
        unset($actions['index']);
        unset($actions['view']);
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['delete']);


        return $actions;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => '*',
                'Access-Control-Request-Method' => ['GET', 'OPTIONS', 'PATCH', 'POST', 'PUT'],
                'Access-Control-Request-Headers' => ['Authorization', 'Content-Type'],
                'Access-Control-Max-Age' => 3600
            ]
        ];

        return $behaviors;
    }

    public function actionSignup()
    {

        $user = new User();
        $user->email = Yii::$app->request->post('email');
        $user->setPassword(Yii::$app->request->post('password'));
        $user->generateAuthKey();
        if (Yii::$app->request->post('password')!== null){
            if($user->validate()){
                if($user->save()){
                    return 'Регистрация прошла успешно';
                }
            }
            return ['message' => $user->firstErrors];
        }

        return ['message' => 'Не ввёл пароль!'];}

    public function actionLogin()
    {
        $user = new User();
        $user->load(Yii::$app->request->post(),'');
        $user->login();
        return $user->login();
    }

}

