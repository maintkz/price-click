<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 25.01.2018
 * Time: 17:48
 */

namespace backend\controllers;


use yii\web\Controller;

class TermsController extends Controller
{
    public function actionIndex()
    {
        return $this->renderAjax('index');
    }
}