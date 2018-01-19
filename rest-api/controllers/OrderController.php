<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 18.01.2018
 * Time: 15:34
 */

namespace api\controllers;


use api\models\MobileUser;
use api\models\OrderGroup;
use api\models\Orders;
use backend\models\Products;
use backend\models\Shops;
use common\models\User;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use backend\models\ProductsList;

class OrderController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     *
     */
    public function actionIndex()
    {
        $order = new Orders;
        $mUser = new MobileUser;
        $order_group = new OrderGroup;
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(Yii::$app->request->isPost) {
            $auth_key = Yii::$app->request->post('auth_key');

            if ($mUser = $mUser->getIdentityByAuthKey($auth_key)) {
                $products = Yii::$app->request->post('products');
                $overall_summ = 0;
                foreach ($products as $key => $value) {
                    $orders[$key] = new Orders;
                }
                foreach ($products as $key => $value) {
                    $orders[$key]->product_id = $value['product_id'];
                    $orders[$key]->product_price = $value['product_price'];
                    $orders[$key]->product_count = $value['product_count'];
                    $orders[$key]->product_summ = $order->product_price * $order->product_count;
                    $orders[$key]->product_parameter = $value['product_parameters'];
                    $orders[$key]->product_parameter = serialize($order->product_parameter);
                    $orders[$key]->status = Orders::STATUS_ORDERED;
                    $overall_summ += $order->product_price * $order->product_count;
                    if(!$orders[$key]->validate()) {
                        return $orders[$key]->getErrors();
                    }
                }
                $order_group->mobile_user_id = $mUser->id;
                $order_group->address = Yii::$app->request->post('address');
                $order_group->description = Yii::$app->request->post('description');
                $order_group->count = count($products);
                $order_group->overall_summ = $overall_summ;
                $order_group->status = Orders::STATUS_ORDERED;
                $order_group->shop_id = ProductsList::getShopByProductId($orders[0]->product_id);
                if($order_group->validate()) {
                    foreach ($orders as $order) {
                        if(!$order->save()) {
                            return $order->getErrors();
                        }
                    }
                    if($order_group->save()) {
                        \Yii::$app->response->statusCode = 200;
                        return [
                            "status" => "200",
                            "message" => "Successfully ordered"
                        ];
                    }
                } else {
                    return $order_group->getErrors();
                }
//                $model->mobile_user_id = $mUser->id;
//                $model->product_id = Yii::$app->request->post('product_id');
//                $model->product_price = Yii::$app->request->post('product_price');
//                $model->product_count = Yii::$app->request->post('product_count');
//                $model->product_summ = $model->product_price * $model->product_count;
//                $model->product_parameters = Yii::$app->request->post('product_parameters');
//                $model->address = Yii::$app->request->post('address');
//                $model->description = Yii::$app->request->post('description');
//                $model->status = Orders::STATUS_ORDERED;
//
//                $model->shop_id = ProductsList::getShopByProductId($model->product_id);
//                $model->product_parameters = serialize($model->product_parameters);
//
//
//
//                if($model->validate()) {
//                    if($model->save()) {
//                        $user_id = Shops::getUserIdByShopId($model->shop_id);
//                        $user_email = User::getEmailByUserId($user_id);
//                        $product = Products::getProductById($model->product_id);
//
//                        $product_body = [];
//                        foreach(ArrayHelper::toArray($product) as $attr_name => $attr_value) {
//                            $product_body .= $attr_name . ': ' . $attr_value . '<br />';
//                        }
//
//                        Yii::$app->mailer->compose()
//                            ->setFrom([Yii::$app->params['mailerRobot'] => 'Price Click'])
//                            ->setTo($user_email)
//                            ->setSubject('Уведомление о заказе товара')
//                            ->setHtmlBody(
//                                '<h3>Заказ товара</h3>'
//                                . '<p>Был заказан товар:</p>'
//                                . '<span>Наименование: ' .$product->product_name . '</span><br />'
//                                . '<span>Цена: ' . $model->product_price . '</span><br />'
//                                . '<span>Количество: ' .$model->product_count . '</span><br />'
//                                . '<span>Сумма: ' .$model->product_summ . '</span><br />'
//                                . '<span>Адресс доставки: ' .$model->address . '</span><br />'
//                                . '<span>Комментарий к покупке: ' .$model->description . '</span><br />'
//                            )
//                            ->send();
//                        return [
//                            "status" => "successfully ordered"
//                        ];
//                    } else {
//                        return $model->getErrors();
//                    }
//                } else {
//                    return $model->getErrors();
//                }
            } else {
                return "Identity not found";
            }
        }
    }
}