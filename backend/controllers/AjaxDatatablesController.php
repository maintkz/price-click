<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 29.01.2018
 * Time: 20:10
 */

namespace backend\controllers;

use api\models\MobileUser;
use api\models\OrderGroup;
use api\models\Orders;
use backend\models\AuthAssignment;
use backend\models\ProductsList;
use backend\models\SellersInfo;
use backend\models\Shops;
use common\models\User;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class AjaxDatatablesController extends Controller
{
    public $enableCsrfValidation = false;

    public function beforeAction($action)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    /*
     * Dealers Dealers Dealers Dealers Dealers Dealers Dealers Dealers Dealers Dealers Dealers
     * Dealers Dealers Dealers Dealers Dealers Dealers Dealers Dealers Dealers Dealers Dealers
     * Dealers Dealers Dealers Dealers Dealers Dealers Dealers Dealers Dealers Dealers Dealers
     */
    public function actionDealersList()
    {
        $dealers = AuthAssignment::find()
            ->select('`auth_assignment`.`user_id`, `user`.`username`, `user`.`email`, `dealers_info`.`phone`, `auth_assignment`.`status`')
            ->where(['item_name' => 'dealer'])
            ->innerJoin('user', '`user`.`id` = `auth_assignment`.`user_id`')
            ->innerJoin('dealers_info', '`dealers_info`.`user_id` = `auth_assignment`.`user_id`')
            ->asArray()
            ->all();

        $data = array_map('array_values', $dealers);
        return $data;
    }

    public function actionViewDealer()
    {
//        $dealer = AuthAssignment::find()
//            ->select('`auth_assignment`.`user_id`, `user`.`username`, `user`.`email`, `dealers_info`.`phone`, `auth_assignment`.`status`')
//            ->where(['user_id' => '1']) // asdasd
//            ->innerJoin('user', '`user`.`id` = `auth_assignment`.`user_id`')
//            ->innerJoin('dealers_info', '`dealers_info`.`user_id` = `auth_assignment`.`user_id`')
//            ->asArray()
//            ->all();
//
//        $data = array_map('array_values', $dealer);
    }
    /*
     * Dealers ends Dealers ends Dealers ends Dealers ends Dealers ends Dealers ends Dealers ends
     * Dealers ends Dealers ends Dealers ends Dealers ends Dealers ends Dealers ends Dealers ends
     * Dealers ends Dealers ends Dealers ends Dealers ends Dealers ends Dealers ends Dealers ends
     */

/*----------------------------------------------------------------------------------------------------------------------------------------------------*/

    /*
     * Statistics Statistics Statistics Statistics Statistics Statistics Statistics Statistics Statistics Statistics
     * Statistics Statistics Statistics Statistics Statistics Statistics Statistics Statistics Statistics Statistics
     * Statistics Statistics Statistics Statistics Statistics Statistics Statistics Statistics Statistics Statistics
     */

    /**
     * @return array
     */
    public function actionDealersStatistics()
    {
        $dealers = AuthAssignment::find()
        ->select('`auth_assignment`.`user_id`, `user`.`username`')
        ->where(['item_name' => 'dealer'])
        ->innerJoin('user', '`user`.`id` = `auth_assignment`.`user_id`')
        ->asArray()
        ->all();

        $dealers_count = count($dealers);

        for ($i = 0; $i < $dealers_count; $i ++) {

            $shop_count = SellersInfo::find()
                ->where(['created_user_id' => $dealers[$i]['user_id']])
                ->innerJoin('`shops`', '`sellers_info`.`user_id` = `shops`.`user_id`')
                ->asArray()
                ->count();

            $dealers[$i]['shop_count'] = $shop_count;

        }

        return array_map('array_values', $dealers);
    }

    public function actionSellersOfDealerStatistics()
    {
        $dealer_id = Yii::$app->request->post('dealer_id');
        // $shops = SellersInfo::getShopIdsOfDealer($dealer_id);

        $sellers = SellersInfo::find()
            ->select(
                '
                `user_id`,
                `user`.`username`,
                `income_percent`,
                `responsible`'
            )
            ->where(['created_user_id' => $dealer_id])
            ->innerJoin('user', '`user`.`id` = `sellers_info`.`user_id`')
            ->asArray()
            ->all();

        for ($i = 0; $i < count($sellers); $i ++) {
            $shop_id = Shops::getShopIdByUserId($sellers[$i]['user_id']);
            $overall_summ = OrderGroup::find()
                ->select('overall_summ')
                ->where(['shop_id' => $shop_id])
                ->all();

            $overall_summ = Yii::$app->helperComponent->onLevelBefore($overall_summ, 'overall_summ');

            $sellers[$i]['overall_summ'] = array_sum($overall_summ);
            $sellers[$i]['profit'] = $sellers[$i]['overall_summ'] * $sellers[$i]['income_percent'] / 100;
        }

        return array_map('array_values', $sellers);
    }

    public function actionSellersStatistics()
    {
        $sellers = AuthAssignment::find()
            ->select('`auth_assignment`.`user_id`, `user`.`username`')
            ->where(['item_name' => 'seller'])
            ->innerJoin('user', '`user`.`id` = `auth_assignment`.`user_id`')
            ->asArray()
            ->all();

        $sellers_count = count($sellers);

        for ($i = 0; $i < $sellers_count; $i ++) {
            $sellers[$i]['orders_count'] = OrderGroup::getOrdersCount($sellers[$i]['user_id']);
        }

        return array_map('array_values', $sellers);
    }

    public function actionOrdersOfSellerStatistics()
    {
        $seller_id = Yii::$app->request->post('seller_id');
        $shop_id = Shops::getShopIdByUserId($seller_id);

        $orders = OrderGroup::find()
            ->select(
                '
                `order_group`.`id`,
                `count`,
                `overall_summ`,
                `mobile_user`.`phone`,
                `order_group`.`status`,
                `order_group`.`created_date`
                '
            )
            ->where(['shop_id' => $shop_id])
            ->innerJoin('mobile_user', '`mobile_user`.`id` = `order_group`.`mobile_user_id`')
            ->asArray()
            ->all();

        return array_map('array_values', $orders);
    }

    public function actionOrderGroupStatistics()
    {
        $order_group_id = Yii::$app->request->post('order_group_id');

        $orders = Orders::find()
            ->select(
                '
                `orders`.`id`,
                `products`.`product_name`,
                `orders`.`product_price`,
                `orders`.`product_count`,
                `orders`.`product_summ`,
                `orders`.`status`,
                `orders`.`created_date`,
                `products`.`product_id`
                '
            )
            ->where(['order_group_id' => $order_group_id])
            ->innerJoin('products', '`products`.`product_id` = `orders`.`product_id`')
            ->innerJoin('order_group', '`order_group`.`id` = `orders`.`order_group_id`')
            ->innerJoin('mobile_user', '`mobile_user`.`id` = `order_group`.`mobile_user_id`')
            ->asArray()
            ->all();

        return array_map('array_values', $orders);
    }

    public function actionCustomersStatistics()
    {
        $customers = MobileUser::find()
            ->select(
                '
                `mobile_user`.`id`,
                `username`,
                `email`,
                `phone`,
                `address`,
                `cities`.`city_name`
                '
            )
            ->innerJoin('cities', '`cities`.`city_id` = `mobile_user`.`city_id`')
            ->asArray()
            ->all();

        return array_map('array_values', $customers);
    }

    public function actionCustomerStatistics()
    {
        $mobile_user_id = Yii::$app->request->post('mobile_user_id');
        $orders = OrderGroup::find()
            ->select(
                '
                `order_group`.`id`,
                `count`,
                `overall_summ`,
                `shops`.`shop_name`,
                `order_group`.`status`,
                `order_group`.`created_date`
                '
            )
            ->where(['mobile_user_id' => $mobile_user_id])
            ->innerJoin('shops', '`shops`.`shop_id` = `order_group`.`shop_id`')
            ->asArray()
            ->all();

        return array_map('array_values', $orders);
    }

    /*
     * Statistics End Statistics End Statistics End Statistics End Statistics End
     * Statistics End Statistics End Statistics End Statistics End Statistics End
     * Statistics End Statistics End Statistics End Statistics End Statistics End
     */
}
