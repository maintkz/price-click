<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 18.01.2018
 * Time: 13:16
 */

namespace api\controllers;


use api\models\MobileUser;
use Yii;
use yii\web\Controller;

class LoginController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        $model = new MobileUser;
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(Yii::$app->request->isPost) {
            $model->email = Yii::$app->request->post('email');
            $model->password = Yii::$app->request->post('password');

            $mUser = $model->getIdentityByEmail($model->email);
            if($mUser->validatePassword($model->password)) {
                if ($mUser->generateAuthKey()) {
                    \Yii::$app->response->statusCode = 200;
                    unset($mUser->password);
                    return $mUser;
                } else {
                    return "error occurred while generating and saving auth key";
                }
            } else {
                \Yii::$app->response->statusCode = 400;
                $response['status'] = "400";
                $response['message'] = "not valid password";
                return $response;
            }
        } else {
            \Yii::$app->response->statusCode = 405;
            return [
                "status" => "405",
                "message" => "Method not Allowed"
            ];
        }
    }
}