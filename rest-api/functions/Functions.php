<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 17.01.2018
 * Time: 10:42
 */

namespace api\functions;


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
}