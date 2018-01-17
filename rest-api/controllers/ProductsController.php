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
            $products = ProductsList::find()
                ->select(
                    '`product_list_id`,
                    `products`.`product_id`,
                    `section_id`,
                    `category_id`,
                    `subcategory_id`,
                    `product_list_count`,
                    `products`.`product_name`,
                    `products`.`product_main_img`,
                    `products`.`product_imgs`,
                    `products`.`product_rating`,
                    `products`.`product_price`,
                    `products`.`product_parameters`,
                    `products`.`product_description`'
                )
                ->innerJoin('products', '`products_list`.`product_id` = `products`.`product_id`')
                ->asArray()
                ->where(['city_id' => $city_id, 'section_id' => $section_id, 'product_list_status' => 1])
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
            $products = ProductsList::find()
                ->select(
                    '`product_list_id`,
                    `products`.`product_id`,
                    `section_id`,
                    `category_id`,
                    `subcategory_id`,
                    `product_list_count`,
                    `products`.`product_name`,
                    `products`.`product_main_img`,
                    `products`.`product_imgs`,
                    `products`.`product_rating`,
                    `products`.`product_price`,
                    `products`.`product_parameters`,
                    `products`.`product_description`'
                )
                ->innerJoin('products', '`products_list`.`product_id` = `products`.`product_id`')
                ->asArray()
                ->where(['city_id' => $city_id, 'shop_id' => $shop_id, 'product_list_status' => 1])
                ->all();
            $products = Functions::prepareSerializedData($products);
            return Functions::prepareResponse($products);
        }
    }
}
