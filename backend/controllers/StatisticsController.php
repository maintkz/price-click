<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 30.01.2018
 * Time: 17:07
 */

namespace backend\controllers;

use api\models\MobileUser;
use api\models\OrderGroup;
use api\models\Orders;
use backend\models\SellersInfo;
use common\models\User;
use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class StatisticsController extends Controller
{
    public function actionDealers()
    {
        if (Yii::$app->user->can('view-dealers-statistics')) {
            if (Yii::$app->helperComponent->isAdmin()) {
                return $this->render('dealers');
            }
        } else {
            throw new ForbiddenHttpException('Доступ запрещен');
        }
    }

    public function actionDealer($id)
    {
        if (Yii::$app->user->can('view-dealers-statistics')) {
            if (Yii::$app->helperComponent->isAdmin()) {
                $dealer = User::find()
                    ->select('`id`, `username`')
                    ->where(['id' => $id])
                    ->asArray()
                    ->one();

                $dealer['sellers_count'] = SellersInfo::find()
                    ->where(['created_user_id' => $id])
                    ->count();

                $dealer['overall_summ'] = OrderGroup::getDealersOverallSum($id);

                return $this->render('dealer', ['dealer' => $dealer]);
            }
        } else {
            throw new ForbiddenHttpException('Доступ запрещен');
        }
    }

    public function actionSellers()
    {
        if (Yii::$app->user->can('view-sellers-statistics')) {
            if (Yii::$app->helperComponent->isAdmin()) {
                return $this->render('sellers');
            }
        } else {
            throw new ForbiddenHttpException('Доступ запрещен');
        }
    }

    public function actionSeller($id)
    {
        if (Yii::$app->user->can('view-sellers-statistics')) {
            if (Yii::$app->helperComponent->isAdmin()) {
                $seller = User::find()
                    ->select('`id`, `username`')
                    ->where(['id' => $id])
                    ->asArray()
                    ->one();

                $seller['orders_count'] = OrderGroup::getOrdersCount($id);
                $seller['overall_summ'] = OrderGroup::getSellersOverallSum($id);

                return $this->render('seller', ['seller' => $seller]);
            }
        } else {
            throw new ForbiddenHttpException('Доступ запрещен');
        }
    }

    public function actionOrders()
    {
        if (Yii::$app->user->can('view-orders-statistics')) {
            if (Yii::$app->helperComponent->isAdmin()) {

                return $this->render('orders');
            }
        } else {
            throw new ForbiddenHttpException('Доступ запрещен');
        }
    }

    public function actionOrder($id)
    {
        if (Yii::$app->user->can('view-orders-statistics')) {
            if (Yii::$app->helperComponent->isAdmin()) {
                $orderGroup = OrderGroup::find()
                    ->select(
                        '
                        `order_group`.`created_date`,
                        `order_group`.`count`,
                        `order_group`.`overall_summ`,
                        `order_group`.`address`,
                        `order_group`.`description`,
                        `mobile_user`.`phone`,
                        `order_group`.`status`,
                        '
                    )
                    ->where(['`order_group`.`id`' => $id])
                    ->innerJoin('mobile_user', '`mobile_user`.`id` = `order_group`.`mobile_user_id`')
                    ->asArray()
                    ->one();

                return $this->render('order', ['orderGroup' => $orderGroup]);
            }
        } else {
            throw new ForbiddenHttpException('Доступ запрещен');
        }
    }

    public function actionCustomers()
    {
        if (Yii::$app->user->can('view-customers-statistics')) {
            if (Yii::$app->helperComponent->isAdmin()) {
                return $this->render('customers');
            } else {
                throw new ForbiddenHttpException('Доступ запрещен');
            }
        } else {
            throw new ForbiddenHttpException('Доступ запрещен');
        }
    }

    public function actionCustomer($id)
    {
        if (Yii::$app->user->can('view-customers-statistics')) {
            if (Yii::$app->helperComponent->isAdmin()) {
                $customer = MobileUser::find()
                    ->select(
                        '
                        `mobile_user`.`id`,
                        `mobile_user`.`username`,
                        `mobile_user`.`email`,
                        `mobile_user`.`phone`,
                        `mobile_user`.`address`,
                        `cities`.`city_name`
                        '
                    )
                    ->where(['id' => $id])
                    ->innerJoin('cities', '`cities`.`city_id` = `mobile_user`.`city_id`')
                    ->asArray()
                    ->one();

                $orders_count = OrderGroup::find()
                    ->where(['mobile_user_id' => $id])
                    ->count();

                $customer['orders_count'] = $orders_count;

                return $this->render('customer', ['customer' => $customer]);
            } else {
                throw new ForbiddenHttpException('Доступ запрещен');
            }
        } else {
            throw new ForbiddenHttpException('Доступ запрещен');
        }
    }

}