<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "photos".
 *
 * @property int $photos_id
 * @property string $photos_path
 * @property string $photos_date_upload
 *
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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['photos_path', 'photos_date_upload'], 'required'],
            [['photos_path'], 'string'],
            [['photos_date_upload'], 'safe'],
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
            'photos_date_upload' => 'Photos Date Upload',
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
