<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 14.12.2017
 * Time: 19:21
 */

namespace backend\controllers;

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
     * Displays homepage.
     *
     * @return string
     */
    public function actionViewDealer($id)
    {
        if(Yii::$app->user->can('view-dealer')) {
            $dealer = AuthAssignment::find()
                ->innerJoin('user', '`auth_assignment`.`user_id` = `user`.`id`')
                ->where(['user_id' => $id])
                ->one();
            return $this->render('view-dealer', ['dealer' => $dealer]);
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
            if(Yii::$app->request->isPost) {
                $model = new SignupForm();
                if ($model->load(Yii::$app->request->post())) {
                    if ($user = $model->signup()) {
                        $authModel = new AuthAssignment();
                        if($authModel->authSave($user->id, 'dealer')) {
                            return $this->render('add-dealer', ['success' => TRUE]);
                        } else {
                            return $this->render('add-dealer', ['success' => FALSE]);
                        }
                    }
                }
            }
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
}