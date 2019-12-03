<?php
namespace frontend\controllers;
use app\models\Users;
use common\models\User;
use http\Message;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\rest\ActiveController;
use frontend\models\SignupForm;
use yii\web\IdentityInterface;
use yii\web\ServerErrorHttpException;
use yii\db\Query;

class UserController extends BaseApiController
{
    public $modelClass = 'app\models\Users';
    public $password;

    public function actions()
    {
        $actions = parent::actions();

        // отключить действия "delete" и "create" и "index"
        unset($actions['index']);
        unset($actions['create']);
        unset($actions['delete']);
        return $actions;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        // НАследуем поведение родителя
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
//Экшн Регистрации
    public function actionSignup()
    {

        $user = new User();
        $user->email = Yii::$app->request->post('email');
        $user->setPassword(Yii::$app->request->post('password'));
        $user->generateAuthKey();
        if (Yii::$app->request->post('email')!== ''){
        if (Yii::$app->request->post('password')!== ''){
            if($user->validate()){
                if($user->save()){
                    return 'Регистрация прошла успешно';
                }
            }
            return ['message' => $user->firstErrors];
        }
        else {return ['message' => 'Не ввёл пароль!'];}}
        else {
           return ['message' => 'Не ввёл email!'];
        }
    }
//Экшн Авторизации
    public function actionLogin()
    {
        $user = new User();
        $user->load(Yii::$app->request->post(),'');
        $password = Yii::$app->request->post('password');
        if (Yii::$app->request->post('email')!== ''){
            if (Yii::$app->request->post('password')!== ''){
                $user->login($password);
                return $user->login($password);}
            else {
                return ['message' => 'Заполните пароль'];
            }}
        else {return ['message' => 'Заполните email'];}

    }



}

