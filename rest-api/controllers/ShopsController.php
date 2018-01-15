<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 15.01.2018
 * Time: 12:51
 */

namespace api\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\QueryParamAuth;

class ShopsController extends ActiveController
{
    public $modelClass = 'backend\models\Shops';
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            'auth' => function($username, $password)
            {
                $out = null;
                $user = \common\models\User::findByUsername($username);
                if($user!=null)
                {
                    if($user->validatePassword($password)) $out = $user;
                }
                return $out;
            }
        ];
        return $behaviors;
    }
}