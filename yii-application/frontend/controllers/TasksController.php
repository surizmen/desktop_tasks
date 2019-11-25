<?php
namespace frontend\controllers;

use yii\rest\ActiveController;

class TasksController extends ActiveController
{
    public $modelClass = 'app\models\Tasks';
}
