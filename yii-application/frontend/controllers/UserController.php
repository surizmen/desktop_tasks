<?php
namespace frontend\controllers;

use yii\rest\ActiveController;

class UserController extends BaseApiController
{
    public $modelClass = 'app\models\User';
}

