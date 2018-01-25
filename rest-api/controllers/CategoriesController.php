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
        $section = \Yii::$app->request->get('section_id');

        if (Yii::$app->request->isPost) {
            //
        }

        if(empty($section)) {
            return Functions::badRequestResponse('Отсутвует ID раздела');
        } else {
            return Functions::getCategoryStructure($section);
        }
    }
}
