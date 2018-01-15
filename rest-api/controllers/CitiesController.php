<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 15.01.2018
 * Time: 14:49
 */

namespace api\controllers;


use yii\rest\ActiveController;

class CitiesController extends ActiveController
{
    public $modelClass = 'backend\models\Cities';
}