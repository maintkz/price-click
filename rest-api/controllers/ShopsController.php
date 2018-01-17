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
}