<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 15.01.2018
 * Time: 17:05
 */

namespace api\controllers;

use yii\rest\ActiveController;

class SliderImagesController extends ActiveController
{
    public $modelClass = 'backend\models\SliderImages';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'index' => ['get', 'head'],
            ],
        ];
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }


    public function actionIndex($city_id)
    {
        $slider_images = \backend\models\SliderImages::find()
            ->where(['city_id' => $city_id])
            ->asArray()
            ->all();
        if(count($slider_images) > 0) {
            return $slider_images;
        } else {
            throw new \yii\web\NotFoundHttpException;
        }
    }
}