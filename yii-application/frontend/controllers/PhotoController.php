<?php

namespace frontend\controllers;

use app\models\Photos;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
use yii\rest\ActiveController;
use yii\web\UploadedFile;

class PhotoController extends BaseApiController
{
    public $modelClass = 'app\models\Photos';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
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
        ];
        return $behaviors;
    }


    public function actionUpload()
    {
        $model = new Photos();
        $model->file = UploadedFile::getInstanceByName('file');

        $name = Yii::getAlias('@app/upload/') . Yii::$app->security->generateRandomString(15) . "." . $model->file->extension;

        $model->photos_path = $name;
        if ($model->save(false)) {
            $model->file->saveAs($name);
            return $model;
        }

        return 1;
    }
}

