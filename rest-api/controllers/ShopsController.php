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
//        return new ActiveDataProvider([
//            'query' => Shops::find()->with('authAssignment')->where(['city_id' => $city_id]),
//        ]);

//        return new ActiveDataProvider([
//            'query' => AuthAssignment::find()->with('shops')->where(['city_id' => $city_id]),
//        ]);

        $shops = \backend\models\Shops::find()->all();
        $outData = [];
        foreach($shops as $shop)
        {
            $outData[] = array_merge($shop->attributes, ['user_id' => $shop->authAssignment->attributes]);
        }
        return $outData;
    }
}