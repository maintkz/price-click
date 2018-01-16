<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 16.01.2018
 * Time: 14:41
 */

namespace api\controllers;


use yii\rest\ActiveController;

class ProductsListController extends ActiveController
{
    public $modelClass = 'backend\models\ProductsList';

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


    public function actionIndex($city_id, $section_id)
    {
        $products = \backend\models\ProductsList::find()
            ->innerJoin('products', '`products`.`product_id` = `products_list`.`product_id`')
            ->where(['product_list_status' => 1])
            ->andWhere(['city_id' => $city_id])
            ->andWhere(['section_id' => $section_id])
            ->asArray()
            ->all();
        if(count($products) > 0) {
            return $products;
        } else {
            throw new \yii\web\NotFoundHttpException;
        }
    }
}