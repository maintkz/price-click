<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 14.12.2017
 * Time: 19:21
 */

namespace backend\controllers;

use backend\models\Categories;
use backend\models\Cities;
use backend\models\DealersInfo;
use backend\models\ProductsList;
use backend\models\AuthAssignment;
use backend\components\HelperComponent;
use backend\models\SellersInfo;
use backend\models\Shops;
use backend\models\SignupForm;
use Imagine\Image\ManipulatorInterface;
//use Imagine\Imagick\Image;
use yii\imagine\Image;
use Yii;
use yii\web\Controller;
use backend\models\Subcategories;
use yii\web\Response;
use yii\web\UploadedFile;

class AjaxController extends Controller
{
    public $enableCsrfValidation = FALSE;

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
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction($action)
    {

        Yii::$app->response->format = Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    /**
     *
     *
     * @return string
     */
    public function actionGetCategoriesStructure()
    {
        $model = New Subcategories;
        $categories = $model->find()->asArray()->orderBy(['section_id' => SORT_ASC, 'category_id' => SORT_ASC])->all();

        $sections = HelperComponent::getCategoriesStructure($categories);

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $sections;
    }

    /**
     *
     *
     * @return string
     */
    public function actionGetProductSubcategory()
    {
        $product_list_id = Yii::$app->request->post('product_list_id');
//        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//        return $product_list_id;
        $model = New ProductsList;
        $categories = $model->find()
            ->select('section_id, category_id, subcategory_id')
            ->where(['product_list_id' => $product_list_id])
            ->one();

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $categories;
    }

    /**
     *
     * @return string
     */
    public function actionGetProductsList()
    {
        $products = ProductsList::find()
            ->select(
                '
                `products_list`.`product_list_id`,
                `subcategories`.`subcategory_name`,
                `products`.`product_name`,
                `products`.`product_price`,
                `product_list_count`,
                `product_list_status`,
                `product_list_id`,
                `products`.`product_id`
                '
            )
            ->innerJoin('subcategories', '`subcategories`.`subcategory_id` = `products_list`.`subcategory_id`')
            ->innerJoin('shops', '`shops`.`user_id` = `products_list`.`user_id`')
            ->innerJoin('products', '`products`.`product_id` = `products_list`.`product_id`')
            ->asArray()
            ->all();

        $data = array_map('array_values', $products);

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $data;
    }

    /**
     *
     * @return string
     */
    public function actionGetDealersList()
    {
        $table['name'] = "`auth_assignment`";
        $table['columns'] = '`user_id`, `user`.`email`, `user`.`username`, `auth_assignment`.`status`';
        $table['join_tables'][0]['name'] = '`user`';
        $table['join_tables'][0]['join_column'] = '`id`';
        $table['join_tables'][0]['core_column'] = '`user_id`';
        $table['where'][0]['column'] = '`item_name`';
        $table['where'][0]['value'] = "'dealer'";
        $data = HelperComponent::getDataForDataTableDealers($table);

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $data;
    }

    /**
     *
     * @return string
     */
    public function actionGetSellersList()
    {
        $table['name'] = "`auth_assignment`";
        $table['columns'] = '`user_id`, `user`.`email`, `user`.`username`, `auth_assignment`.`status`';
        $table['join_tables'][0]['name'] = '`user`';
        $table['join_tables'][0]['join_column'] = '`id`';
        $table['join_tables'][0]['core_column'] = '`user_id`';
        $table['where'][0]['column'] = '`item_name`';
        $table['where'][0]['value'] = "'seller'";
        $data = HelperComponent::getDataForDataTableSellers($table);

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $data;
    }

    /**
     *
     * @return string
     */
    public function actionGetProduct()
    {
        $product_list_id = Yii::$app->request->post('list_id');

        $table = Array(
            'name' => "`products_list`",
            'columns' => '`subcategories`.`section_name`, `subcategories`.`category_name`, `subcategories`.`subcategory_name`,`products`.`product_name`, `products`.`product_parameters`, `products`.`product_price`, `product_list_count`, `product_list_status`, `products`.`product_description`',
            'join_tables' => Array(
                0 => Array(
                    'name' => '`subcategories`',
                    'join_column' => '`subcategory_id`'
                ),
                1 => Array(
                    'name' => '`products`',
                    'join_column' => '`product_id`'
                )
            ),
            'where' => Array(
                0 => Array(
                    'column' => '`product_list_id`',
                    'value' => $product_list_id
                )
            )
        );
        $data = HelperComponent::getDataForDataTable($table, TRUE);

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $data;
    }

    /**
     *
     * @return string
     */
    public function actionEditProduct()
    {
        $product_list_id = Yii::$app->request->post('list_id');

        $table = Array(
            'name' => "`products_list`",
            'columns' => '`subcategories`.`section_name`, `subcategories`.`category_name`, `subcategories`.`subcategory_name`,`products`.`product_name`, `products`.`product_parameters`, `products`.`product_price`, `product_list_count`, `product_list_status`, `products`.`product_description`',
            'join_tables' => Array(
                0 => Array(
                    'name' => '`subcategories`',
                    'join_column' => '`subcategory_id`'
                ),
                1 => Array(
                    'name' => '`products`',
                    'join_column' => '`product_id`'
                )
            ),
            'where' => Array(
                0 => Array(
                    'column' => '`product_list_id`',
                    'value' => $product_list_id
                )
            )
        );
        $data = HelperComponent::getDataForDataTable($table, TRUE);

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $data;
    }


    /*
     * * edit dealer
     *
     */

    public function actionEditDealerUsername()
    {
        if (Yii::$app->request->isAjax && Yii::$app->user->can('edit-dealer')) {
            $user_id = Yii::$app->request->post('user_id');
            $username = Yii::$app->request->post('username');

            $query = "UPDATE `user` SET `username` = '$username' WHERE `id` = '$user_id'";

            $connection = Yii::$app->getDb();
            $command = $connection->createCommand($query);

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($command->execute()) {
                return ['status' => 'success'];
            } else {
                return ['status' => 'fail'];
            }
        } else {
            return "У Вас нет доступа к данной операции.";
        }
    }

    public function actionEditDealerEmail()
    {
        if (Yii::$app->request->isAjax && Yii::$app->user->can('edit-dealer')) {
            $user_id = Yii::$app->request->post('user_id');
            $email = Yii::$app->request->post('email');

            $query = "UPDATE `user` SET `email` = '$email' WHERE `id` = '$user_id'";

            $connection = Yii::$app->getDb();
            $command = $connection->createCommand($query);

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($command->execute()) {
                return ['status' => 'success'];
            } else {
                return ['status' => 'fail'];
            }
        } else {
            return "У Вас нет доступа к данной операции.";
        }
    }

    public function actionEditDealerPassword()
    {
        if (Yii::$app->request->isAjax && Yii::$app->user->can('edit-dealer')) {
            $user_id = Yii::$app->request->post('user_id');
            $password = Yii::$app->request->post('password');

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if (strlen($password) < 6) {
                return ['status' => 'fail', 'error' => 'Пароль не может состоять из менее чем 6 символов.'];
            }
            $password_hash = Yii::$app->security->generatePasswordHash($password);

            $query = "UPDATE `user` SET `password_hash` = '$password_hash' WHERE `id` = '$user_id'";

            $connection = Yii::$app->getDb();
            $command = $connection->createCommand($query);

            if ($command->execute()) {
                return ['status' => 'success'];
            } else {
                return ['status' => 'fail'];
            }
        } else {
            return "У Вас нет доступа к данной операции.";
        }
    }

    public function actionEditDealerStatus()
    {
        if (Yii::$app->request->isAjax && Yii::$app->user->can('edit-dealer')) {
            $user_id = Yii::$app->request->post('user_id');
            $status = Yii::$app->request->post('status');

            $query = "UPDATE `auth_assignment` SET `status` = $status WHERE `user_id` = '$user_id'";

            $connection = Yii::$app->getDb();
            $command = $connection->createCommand($query);

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//            return $query;
            if ($command->execute()) {
                return ['status' => 'success'];
            } else {
                return ['status' => 'fail'];
            }
        } else {
            return "У Вас нет доступа к данной операции.";
        }
    }

    /*
     * * edit seller
     *
     */

    public function actionEditSellerUsername()
    {
        if (Yii::$app->request->isAjax && Yii::$app->user->can('edit-seller')) {
            $user_id = Yii::$app->request->post('user_id');
            $username = Yii::$app->request->post('username');

            $query = "UPDATE `user` SET `username` = '$username' WHERE `id` = '$user_id'";

            $connection = Yii::$app->getDb();
            $command = $connection->createCommand($query);

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($command->execute()) {
                return ['status' => 'success'];
            } else {
                return ['status' => 'fail'];
            }
        } else {
            return "У Вас нет доступа к данной операции.";
        }
    }

    public function actionEditSellerEmail()
    {
        if (Yii::$app->request->isAjax && Yii::$app->user->can('edit-seller')) {
            $user_id = Yii::$app->request->post('user_id');
            $email = Yii::$app->request->post('email');

            $query = "UPDATE `user` SET `email` = '$email' WHERE `id` = '$user_id'";

            $connection = Yii::$app->getDb();
            $command = $connection->createCommand($query);

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($command->execute()) {
                return ['status' => 'success'];
            } else {
                return ['status' => 'fail'];
            }
        } else {
            return "У Вас нет доступа к данной операции.";
        }
    }

    public function actionEditSellerPassword()
    {
        if (Yii::$app->request->isAjax && Yii::$app->user->can('edit-seller')) {
            $user_id = Yii::$app->request->post('user_id');
            $password = Yii::$app->request->post('password');

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if (strlen($password) < 6) {
                return ['status' => 'fail', 'error' => 'Пароль не может состоять из менее чем 6 символов.'];
            }
            $password_hash = Yii::$app->security->generatePasswordHash($password);

            $query = "UPDATE `user` SET `password_hash` = '$password_hash' WHERE `id` = '$user_id'";

            $connection = Yii::$app->getDb();
            $command = $connection->createCommand($query);

            if ($command->execute()) {
                return ['status' => 'success'];
            } else {
                return ['status' => 'fail'];
            }
        } else {
            return "У Вас нет доступа к данной операции.";
        }
    }

    public function actionEditSellerStatus()
    {
        if (Yii::$app->request->isAjax && Yii::$app->user->can('edit-seller')) {
            $user_id = Yii::$app->request->post('user_id');
            $status = Yii::$app->request->post('status');

            $query = "UPDATE `auth_assignment` SET `status` = $status WHERE `user_id` = '$user_id'";

            $connection = Yii::$app->getDb();
            $command = $connection->createCommand($query);

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($command->execute()) {
                return ['status' => 'success'];
            } else {
                return ['status' => 'fail'];
            }
        } else {
            return "У Вас нет доступа к данной операции.";
        }
    }

    public function actionGetCategories()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $section_id = Yii::$app->request->post('section_id');
            $categories = Categories::find()->where(['section_id' => $section_id])->all();
            return $categories;
        } else {
            return ['status' => 'fail', 'error' => 'Unavailable method'];
        }
    }

    public function actionGetSubcategories()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $section_id = Yii::$app->request->post('section_id');
            $category_id = Yii::$app->request->post('category_id');
            $subcategories = Subcategories::find()->where(['section_id' => $section_id, 'category_id' => $category_id])->all();
            return $subcategories;
        } else {
            return ['status' => 'fail', 'error' => 'Unavailable method'];
        }
    }

    public function actionAddToStructure()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (Yii::$app->request->isAjax && Yii::$app->user->can('add-category')) {
            $data = Yii::$app->request->post('data');
            if (isset($data) && !empty($data)) {
                if ($data['type'] == 'section') {
                    $query = "INSERT INTO `sections`(`section_name`) VALUES('" . $data['section_name'] . "') ";
                } elseif ($data['type'] == 'category') {
                    $query = "INSERT INTO `categories`(`section_id`, `category_name`) VALUES('" . $data['section_id'] . "','" . $data['category_name'] . "')";
                } elseif ($data['type'] == 'subcategory') {
                    $query = "INSERT INTO `subcategories` VALUES(NULL, '" . $data['subcategory_name'] . "', " . $data['section_id'] . ", '" . $data['section_name'] . "', " . $data['category_id'] . ", '" . $data['category_name'] . "')";
                }

                $connection = Yii::$app->getDb();
                $command = $connection->createCommand($query);

                if ($command->execute()) {
                    return ['status' => 'success'];
                } else {
                    return [
                        'status' => 'fail',
                        'error' => 'Не удалось добавить запись'
                    ];
                }
            } else {
                return [
                    'status' => 'fail',
                    'error' => 'Данные не получены'
                ];
            }
        } else {
            return "У Вас нет доступа к данной операции.";
        }
    }

    public function actionRemoveFromStructure()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (Yii::$app->request->isAjax && Yii::$app->user->can('add-category')) {
            $data = Yii::$app->request->post('data');
            if (isset($data) && !empty($data)) {
                if ($data['name'] == 'section') {
                    $query = "DELETE FROM `sections` WHERE `section_id` = '" . $data['section_id'] . "';";
                    $query .= "DELETE FROM `categories` WHERE `section_id` = '" . $data['section_id'] . "';";
                    $query .= "DELETE FROM `subcategories` WHERE `section_id` = '" . $data['section_id'] . "';";
                    $query .= "DELETE FROM `products_list` WHERE `section_id` = '" . $data['section_id'] . "';";
                } elseif ($data['name'] == 'category') {
                    $query = "DELETE FROM `categories` WHERE `category_id` = '" . $data['category_id'] . "';";
                    $query .= "DELETE FROM `subcategories` WHERE `category_id` = '" . $data['category_id'] . "';";
                    $query .= "DELETE FROM `products_list` WHERE `category_id` = '" . $data['category_id'] . "';";
                } elseif ($data['name'] == 'subcategory') {
                    $query = "DELETE FROM `subcategories` WHERE `subcategory_id` = '" . $data['subcategory_id'] . "';";
                    $query .= "DELETE FROM `products_list` WHERE `subcategory_id` = '" . $data['subcategory_id'] . "';";
                }

                $connection = Yii::$app->getDb();
                $command = $connection->createCommand($query);

                if ($command->execute()) {
                    return ['status' => 'success'];
                } else {
                    return [
                        'status' => 'fail',
                        'error' => 'Не удалось удалить запись'
                    ];
                }
            } else {
                return [
                    'status' => 'fail',
                    'error' => 'Данные не получены'
                ];
            }
        } else {
            return "У Вас нет доступа к данной операции.";
        }
    }


    /*
     *  New ajax requests
     */
    public function actionAddDealer()
    {
        if (Yii::$app->request->isAjax) {
            if (Yii::$app->user->can('add-dealer')) {
                $signupForm = new SignupForm();
                $dealersInfo = new DealersInfo();
                $authAssignment = new AuthAssignment();
                $signupForm->load(Yii::$app->request->post());
                $dealersInfo->load(Yii::$app->request->post());
                if (!$signupForm->validate()) {
                    $response['status_code'] = 400;
                    $response['message'] = 'Validating failed.';
                    $response['target'] = 'SignupForm';
                    $response['error'] = $signupForm->getErrors();
                    return $response;
                } elseif (!$dealersInfo->validate()) {
                    $response['status_code'] = 400;
                    $response['message'] = 'Validating failed.';
                    $response['target'] = 'DealersInfo';
                    $response['error'] = $dealersInfo->getErrors();
                    return $response;
                } else {
                    if ($user = $signupForm->signup()) {
                        $dealersInfo->user_id = $user->id;
                        if ($dealersInfo->save() && $authAssignment->authSave($user->id, 'dealer')) {
                            $response['status_code'] = 201;
                            $response['message'] = 'Success';
                            return $response;
                        } else {
                            $response['status_code'] = 500;
                            $response['message'] = 'Save failed';
                            $response['error'] = $dealersInfo->getErrors();
                            return $response;
                        }
                    } else {
                        $response['status_code'] = 500;
                        $response['message'] = 'Save failed';
                        $response['error'] = $signupForm->getErrors();
                        return $response;
                    }
                }
            } else {
                $response['status_code'] = 403;
                $response['message'] = 'У вас нету прав для регистрации дилера';
                return $response;
            }
        } else {
            $response['status_code'] = 405;
            $response['message'] = 'Request must be an Ajax';
            return $response;
        }
    }

    public function actionAddSeller()
    {
        if (Yii::$app->request->isAjax) {
            if (Yii::$app->user->can('add-seller')) {
                $signupForm = new SignupForm();
                $sellersInfo = new SellersInfo();
                $authAssignment = new AuthAssignment();
                $signupForm->load(Yii::$app->request->post());
                $sellersInfo->load(Yii::$app->request->post());
                $authAssignment->load(Yii::$app->request->post());
                if (!$signupForm->validate()) {
                    $response['status_code'] = 400;
                    $response['message'] = 'Validating failed.';
                    $response['target'] = 'SignupForm';
                    $response['error'] = $signupForm->getErrors();
                    return $response;
                } elseif (!$sellersInfo->validate()) {
                    $response['status_code'] = 400;
                    $response['message'] = 'Validating failed.';
                    $response['target'] = 'SellersInfo';
                    $response['error'] = $sellersInfo->getErrors();
                    return $response;
                } else {
                    if ($user = $signupForm->signup()) {
                        $sellersInfo->user_id = $user->id;
                        $sellersInfo->created_user_id = Yii::$app->user->identity->id;
                        if ($sellersInfo->save() && $authAssignment->authSave($user->id, 'seller')) {
                            $response['status_code'] = 201;
                            $response['message'] = 'Success';
                            return $response;
                        } else {
                            $response['status_code'] = 500;
                            $response['message'] = 'Save failed';
                            $response['error'] = $sellersInfo->getErrors();
                            return $response;
                        }
                    } else {
                        $response['status_code'] = 500;
                        $response['message'] = 'Save failed';
                        $response['error'] = $signupForm->getErrors();
                        return $response;
                    }
                }
            } else {
                $response['status_code'] = 403;
                $response['message'] = 'У вас нету прав для регистрации дилера';
                return $response;
            }
        } else {
            $response['status_code'] = 405;
            $response['message'] = 'Request must be an Ajax';
            return $response;
        }
    }

    public function actionAddShop()
    {
        if (Yii::$app->request->isAjax) {
            if (!SellersInfo::isShopAdded(Yii::$app->user->id)) {
                $shop = new Shops();
                $shop->load(Yii::$app->request->post());
                $shop->image = UploadedFile::getInstance($shop, 'image');
                $shop->user_id = Yii::$app->user->id;
                $shop->city_id = AuthAssignment::getCityId($shop->user_id);

                if (!$shop->validate()) {
                    $response['status_code'] = 400;
                    $response['message'] = 'Validating failed.';
                    $response['target'] = 'Shops';
                    $response['city_id'] = $shop->city_id;
                    $response['error'] = $shop->getErrors();
                    return $response;
                } else {
                    $name = Yii::$app->helperComponent->transliterate($shop->shop_name);
                    $name = substr($name, 0, 20);
                    $path = '/web/uploads/shops/' . $name . '.' . rand(1, 99999) . '.' . time();
                    $savePath = Yii::getAlias('@backend') . $path;
                    $extension = '.' . $shop->image->extension;
                    $shop->shop_img = 'backend' . $path . $extension;

                    if (empty($shop->image)) {
                        $response['status_code'] = 400;
                        $response['message'] = 'Ошибка валидации';
                        $response['target'] = 'Shops';
                        $response['error']['image'][] = 'Загрузите картинку';
                        return $response;
                    }

                    if ($added_shop = $shop->save()) {
                        $image = Image::thumbnail($shop->image->tempName, 500, 500, ManipulatorInterface::THUMBNAIL_OUTBOUND);

                        if ($image->save($savePath . $extension, ['quality' => 80])) {
                            $query = "UPDATE `sellers_info` SET `shop_added` = 1 WHERE `user_id` = " . Yii::$app->user->id . ";";
                            $connection = Yii::$app->getDb();
                            $command = $connection->createCommand($query);

                            if (!$command->execute()) {
                                $response['sql'] = 'query error';
                            }

                            $response['status_code'] = 201;
                            $response['message'] = 'Успешно добавлено';
                            return $response;
                        } else {
                            $response['status_code'] = 500;
                            $response['message'] = 'Image save failed';
                            return $response;
                        }
                    } else {
                        $response['status_code'] = 500;
                        $response['message'] = 'Save failed';
                        $response['error'] = $shop->getErrors();
                        return $response;
                    }
                }
            } else {
                $response['status_code'] = 403;
                $response['message'] = 'У вас нету прав для регистрации дилера';
                return $response;
            }
        } else {
            $response['status_code'] = 405;
            $response['message'] = 'Request must be an Ajax';
            return $response;
        }
    }

    public function actionGetCities() {
        if (Yii::$app->request->isAjax) {
            $cities = Cities::find()->all();
            return $cities;
        } else {
            $response['status_code'] = 405;
            $response['message'] = 'Request must be an Ajax';
            return $response;
        }
    }
}
