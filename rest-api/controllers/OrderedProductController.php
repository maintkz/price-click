<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 23.01.2018
 * Time: 13:43
 */

namespace api\controllers;


use api\functions\Functions;
use Yii;
use yii\web\Controller;

class OrderedProductController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     *
     */
    public function actionIndex()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (Yii::$app->request->isPost) {
            
        } else {
            return Functions::methodNotAllowedResponse();
        }
    }
}