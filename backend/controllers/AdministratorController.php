<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 14.12.2017
 * Time: 19:21
 */

namespace backend\controllers;

use backend\models\DealersInfo;
use backend\models\Sections;
use backend\models\SignupForm;
use backend\models\AuthAssignment;
use common\models\User;
use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class AdministratorController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('dealers-list');
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionDealersList()
    {
        return $this->render('dealers-list');
    }

    /**
     * Displays asd.
     *
     * @param $id
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionViewDealer($id)
    {
        if(Yii::$app->user->can('view-dealer')) {
            $userRole = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->id))[0];

            if ($userRole == 'admin') {
                $dealer = AuthAssignment::find()
                    ->select('
                    `auth_assignment`.`user_id`,
                    `user`.`username`,
                    `user`.`email`,
                    `auth_assignment`.`status`,
                    `dealers_info`.`phone`,
                    `dealers_info`.`address`,
                    `dealers_info`.`description`
                    ')
                    ->innerJoin('user', '`auth_assignment`.`user_id` = `user`.`id`')
                    ->innerJoin('dealers_info', '`auth_assignment`.`user_id` = `dealers_info`.`user_id`')
                    ->asArray()
                    ->where(['`auth_assignment`.`user_id`' => $id])
                    ->one();
                return $this->render('view-dealer', ['dealer' => $dealer]);
            } else {
                throw new ForbiddenHttpException('Доступ запрещен');
            }
        } else {
            throw new ForbiddenHttpException('Доступ запрещен');
        }
    }

    /**
     * Displays asd.
     *
     * @param $id
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionDealerShops($id)
    {
        if(Yii::$app->user->can('view-dealer')) {
            $userRole = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->id))[0];

            if ($userRole == 'admin') {
                $dealer = AuthAssignment::find()
                    ->select('
                    `auth_assignment`.`user_id`,
                    `user`.`username`,
                    `user`.`email`,
                    `auth_assignment`.`status`,
                    `dealers_info`.`phone`,
                    `dealers_info`.`address`,
                    `dealers_info`.`description`
                    ')
                    ->innerJoin('user', '`auth_assignment`.`user_id` = `user`.`id`')
                    ->innerJoin('dealers_info', '`auth_assignment`.`user_id` = `dealers_info`.`user_id`')
                    ->asArray()
                    ->where(['`auth_assignment`.`user_id`' => $id])
                    ->one();
                return $this->render('view-dealer', ['dealer' => $dealer]);
            } else {
                throw new ForbiddenHttpException('Доступ запрещен');
            }
        } else {
            throw new ForbiddenHttpException('Доступ запрещен');
        }
    }

    /**
     * Displays display
     *
     *
     */
    public function actionEditDealer($id)
    {
        if(Yii::$app->user->can('edit-dealer')) {
            $model = new User();

            $dealer = $model->find()
                ->select('`id`, `username`, `email`, `auth_assignment`.`status`')
                ->where(['id' => $id])
                ->innerJoin('auth_assignment', '`user`.`id` = `auth_assignment`.`user_id`')
                ->one();
            if($dealer != NULL) {
                return $this->render('edit-dealer', ['dealer' => $dealer]);
            } else {
//                return
            }
        } else {
            throw new ForbiddenHttpException('Доступ запрещен');
        }
    }

    /**
     * Displays display
     *
     *
     */
    public function actionAddDealer()
    {
        if(Yii::$app->user->can('add-dealer')) {
            return $this->render('add-dealer');
        } else {
            throw new ForbiddenHttpException('Доступ запрещен');
        }
    }

    /**
     * Displays display
     *
     *
     */
    public function actionCategoriesList()
    {
        if(Yii::$app->user->can('add-category')) {
            $sections = Sections::find()
                ->all();
            return $this->render('categories-list', ['sections' => $sections]);
        } else {
            throw new ForbiddenHttpException('Доступ запрещен');
        }
    }

    /**
     * Displays display
     *
     *
     */
    public function actionDealerPermissions()
    {
        if(Yii::$app->user->can('grant-permission-to-dealer')) {
            $dealers = AuthAssignment::find()
                ->select(
                    '`user_id`,
                    `user`.`email`,
                    `user`.`username`,
                    `auth_assignment`.`status`'
                )
                ->where(['item_name' => 'dealer'])
                ->innerJoin('user', '`auth_assignment`.`user_id` = `user`.`id`')
                ->asArray()
                ->all();
            return $this->render('dealer-permissions', ['dealers' => $dealers]);
        } else {
            throw new ForbiddenHttpException('Доступ запрещен');
        }
    }

    /**
     * Displays display
     *
     *
     */
    public function actionSellerPermissions()
    {
        if(Yii::$app->user->can('grant-permission-to-dealer')) {
            $sellers = AuthAssignment::find()
                ->select(
                    '`user_id`,
                    `user`.`email`,
                    `user`.`username`,
                    `auth_assignment`.`status`'
                )
                ->where(['item_name' => 'seller'])
                ->innerJoin('user', '`auth_assignment`.`user_id` = `user`.`id`')
                ->asArray()
                ->all();
            return $this->render('seller-permissions', ['sellers' => $sellers]);
        } else {
            throw new ForbiddenHttpException('Доступ запрещен');
        }
    }

    /**
     * Displays display
     *
     *
     */
    public function actionDealersBalance()
    {
        if (Yii::$app->user->can('view-dealers-balance')) {
            return $this->render('dealers-balance');
        } else {
            throw new ForbiddenHttpException('Доступ запрещен');
        }
    }
}
