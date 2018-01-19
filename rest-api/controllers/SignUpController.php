<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 17.01.2018
 * Time: 19:57
 */

namespace api\controllers;


use api\models\MobileUser;
use backend\models\SignupForm;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;

class SignUpController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     *
     */
    public function actionIndex()
    {
        $model = new MobileUser;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(Yii::$app->request->isPost) {
            $model->username = Yii::$app->request->post('username');
            $model->email = Yii::$app->request->post('email');
            $model->phone = Yii::$app->request->post('phone');
            $model->password = Yii::$app->request->post('password');
            $model->city_id = Yii::$app->request->post('city_id');;
            if($model->validate()) {
                if($model->register()) {
                    return [
                        "status" => "Зарегистрирован",
                        "auth_key" => $model->auth_key
                    ];
                } else {
                    return $model->getErrors();
                }
            } else {
                return $model->getErrors();
            }
        }
    }

}