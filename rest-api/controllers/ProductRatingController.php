<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 19.01.2018
 * Time: 10:35
 */

namespace api\controllers;


use api\functions\Functions;
use api\models\MobileUser;
use api\models\ProductRating;
use Yii;
use yii\web\Controller;

class ProductRatingController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $mUser = new MobileUser;
        $product_rating = new ProductRating;
        if(Yii::$app->request->isPost) {
            $auth_key = Yii::$app->request->post('auth_key');
            $product_id = Yii::$app->request->post('product_id');
            $value = Yii::$app->request->post('value');

            if ($mUser = $mUser->getIdentityByAuthKey($auth_key)) {
                if(ProductRating::isRatedBefore($mUser->id, $product_id)) {
                    $product_rating->mobile_user_id = $mUser->id;
                    $product_rating->product_id = $product_id;
                    $product_rating->value = $value;
                    if($product_rating->validate()) {
                        if($product_rating->save()) {

                        } else {
                            $product_rating->getErrors();
                        }
                    } else {
                        return $product_rating->getErrors();
                    }
                } else {

                }
            } else {
                return Functions::notAuthorizedResponse();
            }
        }
    }
}