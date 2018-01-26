<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 17.01.2018
 * Time: 12:00
 */

namespace api\controllers;

use api\functions\Functions;
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
        $section_id = Yii::$app->request->get('section_id');
        return Functions::prepareResponse(Functions::getCategoriesSubcategories($section_id));
    }

}
