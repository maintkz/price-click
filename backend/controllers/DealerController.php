<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 14.12.2017
 * Time: 19:21
 */

namespace backend\controllers;

use backend\models\SignupForm;
use backend\models\AuthAssignment;
use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use common\models\User;

class DealerController extends Controller
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
        return $this->render('sellers-list');
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionSellersList()
    {
        return $this->render('sellers-list');
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionViewSeller($id)
    {
        if(Yii::$app->user->can('view-seller')) {
            $seller = AuthAssignment::find()
                ->innerJoin('user', '`auth_assignment`.`user_id` = `user`.`id`')
                ->where(['user_id' => $id])
                ->one();
            return $this->render('view-seller', ['seller' => $seller]);
        }
    }

    /**
     * Displays display
     *
     *
     */
    public function actionEditSeller($id)
    {
        if(Yii::$app->user->can('edit-seller')) {
            $model = new User();

            $seller = $model->find()
                ->select('`id`, `username`, `email`, `auth_assignment`.`status`')
                ->where(['id' => $id])
                ->innerJoin('auth_assignment', '`user`.`id` = `auth_assignment`.`user_id`')
                ->one();
            if($seller != NULL) {
                return $this->render('edit-seller', ['seller' => $seller]);
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
    public function actionAddSeller()
    {
        if(Yii::$app->user->can('add-seller')) {
            if(Yii::$app->request->isPost) {
                $model = new SignupForm();
                if ($model->load(Yii::$app->request->post())) {
                    if ($user = $model->signup()) {
                        $authModel = new AuthAssignment();
                        if($authModel->authSave($user->id, 'seller')) {
                            return $this->render('add-seller', ['success' => TRUE]);
                        } else {
                            return $this->render('add-seller', ['success' => FALSE]);
                        }
                    }
                }
            }
            return $this->render('add-seller');
        } else {
            throw new ForbiddenHttpException('Доступ запрещен');
        }
    }

}