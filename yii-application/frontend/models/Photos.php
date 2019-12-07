<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\web\UploadedFile;
use common\models\User;
/**
 * This is the model class for table "photos".
 *
 * @property int $photos_id
 * @property string $photos_path
 * @property Tasks[] $tasks
 * @property User[] $users
 */
class Photos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'photos';
    }
    public $file;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['photos_path'], 'required'],
            [['photos_path'], 'string'],
            [['file'], 'file','skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg', 'maxSize'=> '10240000']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'photos_id' => 'Photos ID',
            'photos_path' => 'Photos Path',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::className(), ['tasks_photo_id' => 'photos_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['avatar_id' => 'photos_id']);
    }
}
