<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string|null $username
 * @property string|null $auth_key
 * @property string|null $password_hash
 * @property string|null $password_reset_token
 * @property string $email
 * @property int|null $city_id
 * @property int|null $avatar_id
 * @property string|null $description
 * @property string|null $telephone
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $verification_token
 *
 * @property Tasks[] $tasks
 * @property Cities $city
 * @property Photos $avatar
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'created_at', 'updated_at'], 'required'],
            [['city_id', 'avatar_id', 'status', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['city_id', 'avatar_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['description', 'telephone'], 'string'],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key', 'verification_token'], 'string', 'max' => 32],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['username'], 'unique'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['avatar_id'], 'exist', 'skipOnError' => true, 'targetClass' => Photos::className(), 'targetAttribute' => ['avatar_id' => 'photos_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'city_id' => 'City ID',
            'avatar_id' => 'Avatar ID',
            'description' => 'Description',
            'telephone' => 'Telephone',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'verification_token' => 'Verification Token',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::className(), ['tasks_user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAvatar()
    {
        return $this->hasOne(Photos::className(), ['photos_id' => 'avatar_id']);
    }
}
