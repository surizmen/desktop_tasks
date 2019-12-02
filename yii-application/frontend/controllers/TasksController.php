<?php
namespace frontend\controllers;
use app\models\Tasks;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\rest\ActiveController;
use Yii;
use yii\helpers\ArrayHelper;

class TasksController extends BaseApiController
{
    public $modelClass = Tasks::class;

    public function actions()
    {
        $actions = parent::actions();

        //Переопределение дата провайдера
        $actions['index']['prepareDataProvider']=[$this,'get_tasks'];
        return $actions;
    }

    public function behaviors() {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => '*',
                'Access-Control-Request-Method' => ['GET','OPTIONS', 'PATCH', 'POST', 'PUT'],
                'Access-Control-Request-Headers' => ['Authorization', 'Content-Type'],
                'Access-Control-Max-Age' => 3600
            ]
        ];
        $behaviors['authenticator'] = [
            'class' => \yii\filters\auth\HttpBearerAuth::className(),
            //  действия "delete" и "create" и "index" только для авторизированных пользователей
            'only'=>['update','create','delete']
        ];
        return $behaviors;

    }
    //Переопределение дата провайдера где выводи обЪявления только со статусом АКтивные
    public function get_tasks(){
        return Yii::createObject(
            [
                'class' => ActiveDataProvider::class,
                'query' => Tasks::find()->select(['tasks_title','tasks_price','tasks_date_upload','tasks_photo_id'])->where(['tasks_status_number' => 1])
            ]
        );
    }



}

