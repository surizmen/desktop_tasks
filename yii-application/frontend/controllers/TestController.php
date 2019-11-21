<?php
namespace app\fronend\controllers;

use yii\rest\ActiveController;

class AuthorController extends ActiveController
{
    public $modelClass = 'app\backend\models\Author';
}

