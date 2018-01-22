<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 17.01.2018
 * Time: 10:42
 */

namespace api\functions;


use backend\models\Categories;
use backend\models\ProductsList;
use backend\models\Subcategories;

class Functions
{
    public static function prepareResponse($data, $status_code = 'Не найдено')
    {
        if(empty($data)) {
            $response[0]['message'] = $status_code;
            $response[0]['status'] = '404';
            \Yii::$app->response->statusCode = 404;
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $response;
        } else {
            \Yii::$app->response->statusCode = 200;
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $data;
        }
    }

    public static function badRequestResponse($message = 'отсутсвует ID города')
    {
        $response[0]['message'] = $message;
        $response[0]['status'] = '400';
        \Yii::$app->response->statusCode = 400;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $response;
    }

    public static function notAuthorizedResponse()
    {
        $response['status'] = '401';
        $response['message'] = 'unauthorized';
        \Yii::$app->response->statusCode = 401;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $response;
    }

    public static function methodNotAllowedResponse()
    {
        $response['status'] = 405;
        $response['message'] = "Method Not Allowed, Allowed Methods: POST";
        \Yii::$app->response->statusCode = 405;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $response;
    }

    public static function prepareSerializedData($array)
    {
        for($i=0; $i<count($array); $i++) {
            if($array[$i]['product_imgs'] != NULL)
                $array[$i]['product_imgs'] = implode(unserialize($array[$i]['product_imgs']));
            if($array[$i]['product_parameters'] != NULL)
                $array[$i]['product_parameters'] = unserialize($array[$i]['product_parameters']);
        }
        return $array;
    }

    public static function selectProduct() {
        $products = ProductsList::find()
            ->select(
                '`product_list_id`,
                    `products`.`product_id`,
                    `shops`.`shop_id`,
                    `shops`.`shop_name`,
                    `subcategories`.`section_name`,
                    `products_list`.`section_id`,
                    `products_list`.`category_id`,
                    `products_list`.`subcategory_id`,
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
            ->innerJoin('shops', '`products_list`.`shop_id` = `shops`.`shop_id`')
            ->innerJoin('subcategories', '`products_list`.`category_id` = `subcategories`.`category_id`')
            ->asArray();
        return $products;
    }

    public static function getCategoryStructure($section_id)
    {
        $categories = Subcategories::find()->where(['section_id' => $section_id])->asArray()->groupBy('category_id')->all();
        for($i=0; $i<count($categories); $i++) {
            $structure[$categories[$i]['category_id']]['name'] = $categories[$i]['category_name'];
        }

        $subcategories = Subcategories::find()->where(['section_id' => $section_id])->asArray()->orderBy('category_id')->all();

        for($i=0; $i<count($subcategories); $i++) {
            $structure[$subcategories[$i]['category_id']]['subcategories'][$subcategories[$i]['subcategory_id']] = $subcategories[$i]['subcategory_name'];
        }
        for($i=0; $i<count($subcategories); $i++) {
            $categories[$subcategories[$i]['category_name']][] = $subcategories[$i]['subcategory_name'];
        }
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $structure;
    }
}