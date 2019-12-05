<?php
namespace frontend\controllers;
use app\models\Tasks;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use Yii;

class TasksController extends BaseApiController
{
    public $modelClass = Tasks::class;
    private $errors;

    public function actions()
    {
        $actions = parent::actions();

        //Переопределение дата провайдера
        $actions['index']['prepareDataProvider']=[$this,'get_tasks'];
        unset($actions['update']);
        unset($actions['options']);
        unset($actions['delete']);
        unset($actions['view']);
        unset($actions['create']);
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
            'only'=>['update','create','delete','closetask','getmytasks']
        ];

        return $behaviors;

    }

    //Переопределение дата провайдера где выводит обЪявления только со статусом активные с сортировкой даты по убыванию
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
        $polz = new User();
        $token = $polz->Getauthtoen();
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

    public function actionGetmytasks(){
        $polz = new User();
        $get_token = $polz->Getauthtoen();
        $user = $polz::findOne(["verification_token" => $get_token]);
        $task = Tasks::find()->select(['tasks_title','tasks_body','tasks_photo_id','tasks_price','tasks_category_number','tasks_city_id','tasks_status_number'])->where(['tasks_user_id' => $user->id])->all();
        return [$task];
    }

    public function actionCreate(){
        $model = new Tasks();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        $model->save();
        return $model;
    }

    public function actionUpdate($id)
    {
        $user_class = new User();
        /* @var $model ActiveRecord */
        //Ищу таск по айди и записываю в $model
        $model = Tasks::findOne(['tasks_id' => $id]);
        //ИСпользую данные со сценария update
        $model->scenario = Tasks::SCENARIO_UPDATE;
        //ЗАбираю данные с запроса
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
      $token = $user_class->Getauthtoen();
            //использую модель пользователя
            $polz = new User();
            if ($user = $polz::findOne(["verification_token" => $token])){
                if ($task = Tasks::findOne(["tasks_id" => $id])){
                    if ($task->tasks_user_id == $user->id){
                        if ($task->tasks_status_number !== 2){
                            //Изменяю данные
                           $model->save();
                            return $model;
                        }
                        else return 'Вы не можете изменить уже закрытое оъявление';
                    }
                    else return 'У Вас нет прав изменить это объявление';
                }
                else return 'Не передал айди поста';
            }
        $method = $_SERVER['REQUEST_METHOD'];
        if ($model->save() === false && !$model->hasErrors() OR $method!=='PUT') {
            return 'Нe удалось обновить данные поста!';
        }
        return $model;
    }




}

