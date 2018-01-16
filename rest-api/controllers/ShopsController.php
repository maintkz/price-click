<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 15.01.2018
 * Time: 12:51
 */

namespace api\controllers;

use backend\models\AuthAssignment;
use backend\models\Shops;
use yii\data\ActiveDataProvider;
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
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'city' => ['get', 'head'],
            ],
        ];
//        $behaviors['authenticator'] = [
//            'class' => HttpBasicAuth::className(),
//            'auth' => function($username, $password)
//            {
//                $out = null;
//                $user = \common\models\User::findByUsername($username);
//                if($user!=null)
//                {
//                    if($user->validatePassword($password)) $out = $user;
//                }
//                return $out;
//            }
//        ];
        return $behaviors;
    }

    public function actionCity($city_id)
    {
        $shops = \backend\models\Shops::find()
            ->innerJoin('auth_assignment', '`auth_assignment`.`user_id` = `shops`.`user_id`')
            ->where(['city_id' => $city_id])
            ->asArray()
            ->all();
        if(count($shops) > 0) {
            return $shops;
        } else {
            throw new \yii\web\NotFoundHttpException;
        }
    }
}
