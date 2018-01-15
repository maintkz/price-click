<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 06.01.2018
 * Time: 12:35
 */

namespace api\controllers;


use yii\rest\Controller;

class TestRestController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'index' => ['get'],
            ],
        ];
        $behaviors['authenticator'] = [
            'class' => \yii\filters\auth\HttpBasicAuth::className(),
        ];
        return $behaviors;
    }

    private function dataList()
    {
        return [
            [ 'id' => 1, 'name' => 'Albert', 'surname' => 'Einstein' ],
            [ 'id' => 2, 'name' => 'Enzo', 'surname' => 'Ferrari' ],
            [ 'id' => 4, 'name' => 'Mario', 'surname' => 'Bros' ]
        ];
    }
    public function actionIndex()
    {
        return $this->dataList();
    }
}