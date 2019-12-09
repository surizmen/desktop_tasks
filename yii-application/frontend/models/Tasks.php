<?php

namespace app\models;

use common\models\User;
use Yii;
use yii\base\InvalidCallException;
use yii\db\ActiveRecordInterface;
use yii\db\BaseActiveRecord;
use yii\web\NotFoundHttpException;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "tasks".
 *
 * @property int $tasks_id
 * @property string $tasks_title
 * @property string|null $tasks_body
 * @property int $tasks_city_id
 * @property float $tasks_price
 * @property string $tasks_date_upload
 * @property int $tasks_status_number
 * @property int $tasks_category_number
 * @property int|null $tasks_photo_id
 * @property int $tasks_user_id
 *
 * @property Categories $tasksCategoryNumber
 * @property Cities $tasksCity
 * @property Photos $tasksPhoto
 * @property Status $tasksStatusNumber
 * @property User $tasksUser
 */
class Tasks extends \yii\db\ActiveRecord
{
    const SCENARIO_UPDATE = 'update';
    public $count;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tasks_title'], 'required', 'message' => 'Заполните Заголовок объявления'],
            [['tasks_body'], 'required', 'message' => 'Заполните Описание объявления'],
            [['tasks_city_id'], 'required', 'message' => 'Укажите свой город'],
            [['tasks_price'], 'required', 'message' => 'Укажите цену'],
            [['tasks_category_number'], 'required', 'message' => 'Укажите категорию товара'],
            [[ 'tasks_price', 'tasks_status_number', 'tasks_category_number', 'tasks_user_id'], 'required', 'message' => 'Заполните {attribute}'],
            [['tasks_title', 'tasks_body'], 'string'],
            [['tasks_city_id', 'tasks_status_number', 'tasks_category_number', 'tasks_photo_id', 'tasks_user_id'], 'default', 'value' => null],
            [['tasks_city_id', 'tasks_status_number', 'tasks_category_number', 'tasks_photo_id', 'tasks_user_id'], 'integer'],
            [['tasks_price'], 'number', 'message' => 'Цена должна быть числом'],
            [['tasks_category_number'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['tasks_category_number' => 'id']],
            [['tasks_city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['tasks_city_id' => 'id']],
            [['tasks_photo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Photos::className(), 'targetAttribute' => ['tasks_photo_id' => 'photos_id']],
            [['tasks_status_number'], 'exist', 'skipOnError' => true, 'targetClass' => Status::className(), 'targetAttribute' => ['tasks_status_number' => 'id']],
            [['tasks_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['tasks_user_id' => 'id']],
            [['tasks_user_id'], 'safe', 'on' => self::SCENARIO_UPDATE]
        ];
    }
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['self::SCENARIO_UPDATE'] = ['tasks_price','tasks_title','tasks_body','tasks_category_number','tasks_price','tasks_photo_id'];
        return $scenarios;
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tasks_id' => 'Айди объявления',
            'tasks_title' => 'Загловок Объявления',
            'tasks_body' => 'Tasks Body',
            'tasks_city_id' => 'Tasks City ID',
            'tasks_price' => 'Tasks Price',
            'tasks_date_upload' => 'Tasks Date Upload',
            'tasks_status_number' => 'Tasks Status Number',
            'tasks_category_number' => 'Tasks Category Number',
            'tasks_photo_id' => 'Tasks Photo ID',
            'tasks_user_id' => 'Tasks User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasksCategoryNumber()
    {
        return $this->hasOne(Categories::className(), ['id' => 'tasks_category_number']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasksCity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'tasks_city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasksPhoto()
    {
        return $this->hasOne(Photos::className(), ['photos_id' => 'tasks_photo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasksStatusNumber()
    {
        return $this->hasOne(Status::className(), ['status_number' => 'tasks_status_number']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasksUser()
    {
        return $this->hasOne(User::className(), ['id' => 'tasks_user_id']);
    }

    public function close_task($token,$id){
        $polz = new User();
        if ($user = $polz::findOne(["verification_token" => $token])){
            if ($task = self::findOne(["tasks_id" => $id])){
                if ($task->tasks_user_id == $user->id){
                    if ($task->tasks_status_number !== 2){
                        $task->tasks_status_number = 2;
                        $task->save();
                        return 'Вы закрыли объявление';
                    }
                    else return 'Уже закрыто';
                }
            else return 'У Вас нет прав закрыть это объявление';
            }
            else return 'Не найдено объявление с таким айди';
        }
        else {
            return 0;
        }
    }

    public function countposts($id){
        return  $this->find()->where(['tasks_user_id' => $id])->count();
    }

}
