<?php
namespace frontend\controllers;

use yii\rest\ActiveController;

class TestController extends ActiveController
{
    public $modelClass = 'app\models\User';
}

