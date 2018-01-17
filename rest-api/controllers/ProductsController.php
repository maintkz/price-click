<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 17.01.2018
 * Time: 12:44
 */

namespace api\controllers;

use api\functions\Functions;
use backend\models\ProductsList;
use yii\web\Controller;

class ProductsController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionSection()
    {
        $city_id = \Yii::$app->request->get('city_id');
        $section_id = \Yii::$app->request->get('section_id');
        if(empty($city_id)) {
            return Functions::badRequestResponse();
        } elseif(empty($section_id)) {
            return Functions::badRequestResponse('Отсутсвует ID раздела');
        } else {
            $products = Functions::selectProduct();
            $products = $products
                ->where([
                    '`products_list`.`city_id`' => $city_id,
                    '`products_list`.`section_id`' => $section_id,
                    '`products_list`.`product_list_status`' => 1
                ])
                ->all();
            $products = Functions::prepareSerializedData($products);
            return Functions::prepareResponse($products);
        }
    }

    public function actionShop()
    {
        $city_id = \Yii::$app->request->get('city_id');
        $shop_id = \Yii::$app->request->get('shop_id');
        if(empty($city_id)) {
            return Functions::badRequestResponse();
        } elseif(empty($shop_id)) {
            return Functions::badRequestResponse('Отсутсвует ID магазина');
        } else {
            $products = Functions::selectProduct();
            $products = $products
                ->where(['`products_list`.`city_id`' => $city_id,
                    '`products_list`.`shop_id`' => $shop_id,
                    '`products_list`.`product_list_status`' => 1
                ])
                ->all();
            $products = Functions::prepareSerializedData($products);
            return Functions::prepareResponse($products);
        }
    }

    public function actionShopSection()
    {
        $city_id = \Yii::$app->request->get('city_id');
        $shop_id = \Yii::$app->request->get('shop_id');
        $section_id = \Yii::$app->request->get('section_id');
        if(empty($city_id)) {
            return Functions::badRequestResponse();
        } elseif(empty($shop_id)) {
            return Functions::badRequestResponse('Отсутсвует ID магазина');
        } elseif(empty($section_id)) {
            return Functions::badRequestResponse('Отсутсвует ID Раздела');
        } else {
            $products = Functions::selectProduct();
            $products = $products
                ->where([
                    '`products_list`.`city_id`' => $city_id,
                    '`products_list`.`shop_id`' => $shop_id,
                    '`products_list`.`section_id`' => $section_id,
                    '`products_list`.`product_list_status`' => 1
                ])
                ->all();
            $products = Functions::prepareSerializedData($products);
            return Functions::prepareResponse($products);
        }
    }
}
