<?php
namespace frontend\controllers;
use common\models\User;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;

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
        unset($actions['update']);
        unset($actions['option']);
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
        $behaviors['authenticator'] = [
            'class' => \yii\filters\auth\HttpBearerAuth::className(),
            //  действия "update" только для авторизированных пользователей
            'only'=>['update']
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
            if (User::findOne(["email" => $user->email])){
                return 'Такой email уже существует!';

            } else {            if($user->validate()){
                if($user->save()){
                    return 'Регистрация прошла успешно';
                }
                return ['message' => $user->firstErrors];
            }
                }


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

//Функция обновления информации о пользователе
    public function actionUpdate()
    {
        /* @var $model ActiveRecord */
        $polz = new User();
        $token = $polz->Getauthtoen();
        $user = $polz::findOne(["verification_token" => $token]);
        $polz->scenario = User::SCENARIO_USERUPDATE;
        try {
            $user->load(Yii::$app->getRequest()->getBodyParams(), '');
        } catch (InvalidConfigException $e) {
        }
        $user->save();
        return $user;
    }



}

