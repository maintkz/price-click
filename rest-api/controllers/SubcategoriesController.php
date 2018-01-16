<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 16.01.2018
 * Time: 14:00
 */

namespace api\controllers;


use yii\rest\ActiveController;

class SubcategoriesController extends ActiveController
{
    public $modelClass = 'backend\models\Subcategories';
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'city' => ['get', 'head'],
            ],
        ];
        return $behaviors;
    }
}