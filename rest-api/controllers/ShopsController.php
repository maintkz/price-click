<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 17.01.2018
 * Time: 11:54
 */

namespace api\controllers;

use api\functions\Functions;
use backend\models\ProductsList;
use backend\models\Shops;
use Yii;
use yii\web\Controller;

class ShopsController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        $city_id = \Yii::$app->request->get('city_id');
        if(empty($city_id)) {
            return Functions::badRequestResponse();
        } else {
            $shops = Shops::find()
                ->where(['city_id' => $city_id])
                ->asArray()
                ->all();
            return Functions::prepareResponse($shops);
        }
    }

    public function actionSection()
    {
        $city_id = \Yii::$app->request->get('city_id');
        $section_id = \Yii::$app->request->get('section_id');
        if(empty($city_id)) {
            return Functions::badRequestResponse();
        } elseif(empty($section_id)) {
            return Functions::badRequestResponse('Отсутсвует ID раздела');
        } else {
            $shops_ids = ProductsList::find()
                ->select('user_id')
                ->where(['city_id' => $city_id])
                ->andWhere(['section_id' => $section_id])
                ->groupBy('user_id')
                ->all();
            if(empty($shops_ids)) {
                return Functions::badRequestResponse('Магазины данного раздела не найдены');
            } else {
                $shops = Shops::find()
                    ->where(['user_id' => $shops_ids])
                    ->asArray()
                    ->all();
                return Functions::prepareResponse($shops);
            }
        }
    }

    public function actionCategoryShops()
    {
        if (Yii::$app->request->isGet) {
            $category_id = Yii::$app->request->get('category_id');
            $city_id = Yii::$app->request->get('city_id');
            settype($category_id, 'INTEGER');
            settype($city_id, 'INTEGER');
            if (empty($category_id)) {
                return Functions::missingParameter(['category_id']);
            } elseif (empty($category_id)) {
                return Functions::missingParameter(['city_id']);
            } else {
                $shops_ids = ProductsList::find()
                    ->select('user_id')
                    ->where(['city_id' => $city_id])
                    ->andWhere(['category_id' => $category_id])
                    ->groupBy('user_id')
                    ->all();
                if(empty($shops_ids)) {
                    return Functions::badRequestResponse('Магазины данной категории не найдены');
                } else {
                    $shops = Shops::find()
                        ->where(['user_id' => $shops_ids])
                        ->asArray()
                        ->all();
                    return Functions::prepareResponse($shops);
                }
            }
        } else {
            return Functions::methodNotAllowedResponse('GET');
        }
    }

    public function actionSubcategoryShops()
    {
        if (Yii::$app->request->isGet) {
            $subcategory_id = Yii::$app->request->get('subcategory_id');
            $city_id = Yii::$app->request->get('city_id');
            settype($subcategory_id, 'INTEGER');
            settype($city_id, 'INTEGER');
            if (empty($city_id)) {
                return Functions::missingParameter(['city_id']);
            }
            if (empty($subcategory_id)) {
                return Functions::missingParameter(['subcategory_id']);
            } else {
                $shops_ids = ProductsList::find()
                    ->select('user_id')
                    ->where(['city_id' => $city_id])
                    ->andWhere(['subcategory_id' => $subcategory_id])
                    ->groupBy('user_id')
                    ->all();
                if(empty($shops_ids)) {
                    return Functions::badRequestResponse('Магазины данной категории не найдены');
                } else {
                    $shops = Shops::find()
                        ->where(['user_id' => $shops_ids])
                        ->asArray()
                        ->all();
                    return Functions::prepareResponse($shops);
                }
            }
        } else {
            return Functions::methodNotAllowedResponse('GET');
        }
    }

    public function actionShopInfo()
    {
        if (Yii::$app->request->isGet) {
            $shop_id = Yii::$app->request->get('shop_id');
            settype($shop_id, 'INTEGER');
            if (!empty($shop_id)) {
                $shop = Shops::find()
                    ->where([
                        'shop_id' => $shop_id
                    ])
                    ->asArray()
                    ->all();
                return Functions::prepareResponse($shop);
            } else {
                return Functions::missingParameter(['shop_id']);
            }
        } else {
            return Functions::methodNotAllowedResponse('GET');
        }
    }

    public function actionSearch()
    {
        if (Yii::$app->request->isGet) {
            $query = Yii::$app->request->get('query');
            if (!empty($query)) {
                $shops = Shops::find()
                    ->where(['LIKE', 'shop_name', $query])
                    ->asArray()
                    ->all();
                return Functions::prepareResponse($shops);
            } else {
                return Functions::missingParameter(['query']);
            }
        } else {
            return Functions::methodNotAllowedResponse(['GET']);
        }
    }
}