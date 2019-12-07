<?php

namespace app\models;

use Yii;
use common\models\User;
/**
 * This is the model class for table "tasks".
 *
 * @property int $tasks_id
 * @property string $tasks_title
 * @property string|null $tasks_body
 * @property int $tasks_city_id
 * @property float $tasks_price
 * @property string|null $tasks_date_upload
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
class Tasksanother extends \yii\db\ActiveRecord
{
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
            [['tasks_title', 'tasks_city_id', 'tasks_price', 'tasks_status_number', 'tasks_category_number', 'tasks_user_id'], 'required'],
            [['tasks_title', 'tasks_body'], 'string'],
            [['tasks_city_id', 'tasks_status_number', 'tasks_category_number', 'tasks_photo_id', 'tasks_user_id'], 'default', 'value' => null],
            [['tasks_city_id', 'tasks_status_number', 'tasks_category_number', 'tasks_photo_id', 'tasks_user_id'], 'integer'],
            [['tasks_price'], 'number'],
            [['tasks_date_upload'], 'safe'],
            [['tasks_category_number'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['tasks_category_number' => 'id']],
            [['tasks_city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['tasks_city_id' => 'id']],
            [['tasks_photo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Photos::className(), 'targetAttribute' => ['tasks_photo_id' => 'photos_id']],
            [['tasks_status_number'], 'exist', 'skipOnError' => true, 'targetClass' => Status::className(), 'targetAttribute' => ['tasks_status_number' => 'status_number']],
            [['tasks_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['tasks_user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tasks_id' => 'Tasks ID',
            'tasks_title' => 'Tasks Title',
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
}
