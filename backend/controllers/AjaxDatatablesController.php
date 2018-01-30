<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 29.01.2018
 * Time: 20:10
 */

namespace backend\controllers;

use backend\components\HelperComponent;
use backend\models\AuthAssignment;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class AjaxDatatablesController extends Controller
{
    public function beforeAction($action)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    /*
     * Dealers Dealers Dealers Dealers Dealers Dealers Dealers Dealers Dealers Dealers Dealers
     * Dealers Dealers Dealers Dealers Dealers Dealers Dealers Dealers Dealers Dealers Dealers
     * Dealers Dealers Dealers Dealers Dealers Dealers Dealers Dealers Dealers Dealers Dealers
     */
    public function actionDealersList()
    {
        $dealers = AuthAssignment::find()
            ->select('`auth_assignment`.`user_id`, `user`.`username`, `user`.`email`, `dealers_info`.`phone`, `auth_assignment`.`status`')
            ->where(['item_name' => 'dealer'])
            ->innerJoin('user', '`user`.`id` = `auth_assignment`.`user_id`')
            ->innerJoin('dealers_info', '`dealers_info`.`user_id` = `auth_assignment`.`user_id`')
            ->asArray()
            ->all();

        $data = array_map('array_values', $dealers);
        return $data;
    }

    public function actionViewDealer()
    {
        $dealer = AuthAssignment::find()
            ->select('`auth_assignment`.`user_id`, `user`.`username`, `user`.`email`, `dealers_info`.`phone`, `auth_assignment`.`status`')
            ->where(['user_id' => '1']) // asdasd
            ->innerJoin('user', '`user`.`id` = `auth_assignment`.`user_id`')
            ->innerJoin('dealers_info', '`dealers_info`.`user_id` = `auth_assignment`.`user_id`')
            ->asArray()
            ->all();

        $data = array_map('array_values', $dealer);
    }
    /*
     * Dealers ends Dealers ends Dealers ends Dealers ends Dealers ends Dealers ends Dealers ends
     * Dealers ends Dealers ends Dealers ends Dealers ends Dealers ends Dealers ends Dealers ends
     * Dealers ends Dealers ends Dealers ends Dealers ends Dealers ends Dealers ends Dealers ends
     */

}