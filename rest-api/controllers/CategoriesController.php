<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 17.01.2018
 * Time: 12:00
 */

namespace api\controllers;

use api\functions\Functions;
use backend\models\Categories;
use Yii;
use yii\web\Controller;

class CategoriesController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $section = \Yii::$app->request->get('section');
        if(empty($section)) {
            return Functions::badRequestResponse();
        } else {
            $categories = Categories::find()
                ->where(['section_id' => $section])
                ->asArray()
                ->all();
            return Functions::prepareResponse($categories);
        }
    }

    public function actionCategoryStructure()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (Yii::$app->request->isGet) {
            $section = \Yii::$app->request->get('section_id');
            if($section) {

            } else {
                \Yii::$app->response->statusCode = 400;
                $response['status'] = '400';
                $response['message'] = 'section_id is not send or empty';
                return $response;
            }
        } else {
            return Functions::methodNotAllowedResponse('GET');
        }

        if(empty($section)) {
            return Functions::badRequestResponse('Отсутвует ID раздела');
        } else {
            return Functions::getCategoryStructure($section);
        }
    }
}
