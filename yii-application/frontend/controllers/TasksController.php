<?php
namespace frontend\controllers;
use app\models\Tasks;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\rest\ActiveController;
use Yii;

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
            'only'=>['update','create','delete','closetask']
        ];
        return $behaviors;

    }
    //Переопределение дата провайдера где выводит обЪявления только со статусом АКтивные с сортировкой даты по убыванию
    public function get_tasks(){
        $query = Tasks::find()->select(['tasks_title','tasks_price','tasks_date_upload','tasks_photo_id'])->where(['tasks_status_number' => 1])
            ->orderBy(['tasks_date_upload' => SORT_DESC,]);
        return Yii::createObject(
            [
                'class' => ActiveDataProvider::class,
                'query' => $query
            ]
        );
    }


    public function actionClosetask(){
        $task = new Tasks();
        $token = Yii::$app->request->post('token');
        $id = Yii::$app->request->post('id');
        return $task->close_task($token, $id);
    }

    public function actionGettask(){
        $get_id = Yii::$app->request->get('id');
        $task = Tasks::findOne(['tasks_id' => $get_id]);
        $user = User::findOne(['id'=> $task->tasks_user_id]);
        unset($task['tasks_id'],$task['tasks_status_number'],
            $task['tasks_user_id'],$user['id'],$user['updated_at'],$user['city_id'],$user['status'],$user['verification_token']);
        return [$task,$user];
    }


}

