<?php
namespace frontend\controllers;
use app\models\Tasks;
use common\models\User;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use Yii;
use yii\db\Expression;

//ТАскконтроллер это наследуемый класс от BaseApiCOntroller
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
        //НАследуем поведения родителя
        $behaviors = parent::behaviors();
//Подключаем авторизацию
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
        $behaviors['timestamp'] = [
            'class' => TimestampBehavior::className(),
            'attributes' =>  [
                'createdAtAttribute' => 'tasks_date_upload',
                'updatedAtAttribute' => false,
            ],
            'value' => function(){
                return date('Y-m-d H:i:s');
            },
        ];
        return $behaviors;

    }

//Поиск всех обЪявлений со статусом АКтивные, вместе с фильтрами
    public function get_tasks(){
        $searchModel = new \app\models\TasksSearch();
        return $searchModel->search(Yii::$app->request->queryParams);
    }
//Экшон сакрытия своих постов по id
    public function actionClosetask(){
        $task = new Tasks();
        $polz = new User();
        $token = $polz->Getauthtoen();
        $id = Yii::$app->request->get('id');
        return $task->close_task($token, $id);
    }
//Экшон получения определённого поста по id
    public function actionGettask(){
        $count = new Tasks();
        $get_id = Yii::$app->request->get('id');
        if (  $task = Tasks::findOne(['tasks_id' => $get_id]))
        {        $user = User::findOne(['id'=> $task->tasks_user_id]);
            unset($task['tasks_id'],$task['tasks_status_number'],
                $task['tasks_user_id'],$user['id'],$user['updated_at'],$user['city_id'],$user['status'],$user['verification_token']);
            return [$task,$user,$task->tasksCategoryNumber,$task->tasksCity,$task->tasks_photo_id,['Кол-во постов пользователя'=>$count->countposts($get_id)]];}
        else {
            return 'Такого объявления нет';
        }

    }

//Экшон получения своих постов
    public function actionGetmytasks(){
        $polz = new User();
        $searchModel = new \app\models\TasksanotherSearch();
        $get_token = $polz->Getauthtoen();
        $user = $polz::findOne(["verification_token" => $get_token]);
        $params = Yii::$app->request->queryParams;
        return [$searchModel->search($params,$user->id)];
    }

//Экшон создания поста
    public function actionCreate(){
        $model = new Tasks();
        $user_class = new User();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        $user = $user_class::findOne(["verification_token" => $user_class->Getauthtoen()]);
        $model->tasks_user_id = $user->id;
        $model->tasks_status_number = 1;
        $model->tasks_date_upload = date("Y-m-d H:i:s");
        $model->save();
        return $model;
    }
//Экшон обновления поста
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
                        else return ['message' =>'Вы не можете изменить уже закрытое оъявление'];
                    }
                    else return ['message' => 'У Вас нет прав изменить это объявление'];
                }
                else return ['message' => 'Не передал айди поста'];
            }
        $method = $_SERVER['REQUEST_METHOD'];
        if ($model->save() === false && !$model->hasErrors() OR $method!=='PUT') {
            return ['message' =>  'Нe удалось обновить данные поста!'];
        }
        return $model;
    }




}

