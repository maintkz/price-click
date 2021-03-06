<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 14.12.2017
 * Time: 19:21
 */

namespace backend\controllers;

use backend\models\AuthAssignment;
use backend\models\ProductsList;
use backend\models\SellersInfo;
use backend\models\Shops;
use Imagine\Image\ManipulatorInterface;
use moonland\phpexcel\Excel;
use yii\imagine\Image;
use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use backend\models\Products;
use yii\web\HttpException;
use yii\web\UploadedFile;

class SellerController extends Controller
{
     // public $enableCsrfValidation = false;
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
        return $this->render('products-list');
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionProductsList()
    {
        return $this->render('products-list');
    }

    /**
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionAddProduct()
    {
        if(Yii::$app->user->can('add-product')) {
            return $this->render('add-product');
        } else {
            throw new ForbiddenHttpException;
        }
    }

    /**
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionEditProduct($product_list_id)
    {
        $product = ProductsList::find()
            ->select('*')
            ->where(['product_list_id' => $product_list_id])
            ->innerJoin(
                'products',
                '`products_list`.`product_id` = `products`.`product_id`')
            ->asArray()
            ->one();

        if(Yii::$app->user->can('add-product')) {
            return $this->render('edit-product', ['product' => $product]);
        } else {
            throw new ForbiddenHttpException;
        }
    }

    /**
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionAddProductAjax()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $productsListModel = new ProductsList;
        $productsModel = new Products;
        $imagePaths = [];
        $imageMinPaths = [];

        if (Yii::$app->request->isAjax) {
            $productsListModel->load(Yii::$app->request->post());
            $productsListModel->user_id = Yii::$app->user->identity->id;
            $productsListModel->product_list_status = 0;
            $productsListModel->city_id = settype(AuthAssignment::getCityIdByUserId($productsListModel->user_id), 'INTEGER');
            $productsListModel->shop_id = Shops::getShopIdByUserId(Yii::$app->user->identity->id);

            $productsModel->load(Yii::$app->request->post());
            $productsModel->images = UploadedFile::getInstances($productsModel, 'images');

            $productsModel->product_parameters = $productsModel->serializeProductParameters($productsModel->product_parameters);

            if($productsModel->product_description == "") $productsModel->product_description = NULL;   // if description is empty write NULL to db

            $productsModel->product_imgs_min = NULL;
            $productsModel->product_imgs = NULL;
            $productsModel->product_main_img = NULL;

            if(is_array($productsModel->images) && !empty($productsModel->images) && $productsModel->validate()) {
                foreach ($productsModel->images as $image) {
                    $name = Yii::$app->helperComponent->transliterate($productsModel->product_name);
                    $name = substr($name, 0, 20);
                    $path = '/web/uploads/products/' . $name . '.' . rand(1, 99999) . '.' . time();
                    $savePath = Yii::getAlias('@backend') . $path;
                    $extension = '.' . $image->extension;
                    $imagePaths[] = 'backend' . $path . $extension;
                    $imageMinPaths[] = 'backend' . $path . '.min' . $extension;

                    Image::thumbnail($image->tempName, 300, 200, ManipulatorInterface::THUMBNAIL_OUTBOUND)
                        ->save($savePath . '.min' . $extension, ['quality' => 80]);
                    Image::thumbnail($image->tempName, 900, 600, ManipulatorInterface::THUMBNAIL_OUTBOUND)
                        ->save($savePath . $extension, ['quality' => 80]);
                }
                $productsModel->product_imgs_min = serialize($imageMinPaths);
                $productsModel->product_imgs = serialize($imagePaths);
                $productsModel->product_main_img = $imagePaths[0];
            }

            if($productsModel->save()) {
                $productsListModel->product_id = $productsModel->product_id;
                if($productsListModel->save()) {
                    return "success";
                } else {
                    return $productsListModel->getErrors();
                }
            } else {
                return $productsModel->getErrors();
            }
        } else {
            return "nothing received or not ajax";
        }
    }

    public function actionAddByExcel()
    {
        if (Yii::$app->helperComponent->getRole() == 'seller') {
            if (Yii::$app->request->isPost) {
                $xlsx = UploadedFile::getInstanceByName('excel');
                $data = Excel::import($xlsx->tempName);

                $user_id = Yii::$app->user->identity->id;

                foreach($data as $key => $row) {
                    $products[$key] = new Products;
                    $productsList[$key] = new ProductsList;

                    $products[$key]->product_name = $row['наименование'];
                    $products[$key]->product_main_img = NULL;
                    $products[$key]->product_imgs = NULL;
                    $products[$key]->product_imgs_min = NULL;
                    $parameters['color'] = $row['цвет'];
                    $parameters['size'] = $row['размер'];
                    $products[$key]->product_parameters = serialize($parameters);
                    $products[$key]->product_price = $row['цена'];
                    $products[$key]->product_description = $row['описание'];

                    $productsList[$key]->user_id = Yii::$app->user->identity->id;
                    $productsList[$key]->shop_id = Shops::getShopIdByUserId($user_id);
//                    $productsList[$key]->product_id = ;
                    $productsList[$key]->section_id = Yii::$app->request->post('section_id');
                    $productsList[$key]->category_id = Yii::$app->request->post('category_id');
                    $productsList[$key]->subcategory_id = Yii::$app->request->post('subcategory_id');
                    $productsList[$key]->product_list_count = $row['количество'];
                    if (AuthAssignment::isVerifiedSeller($user_id)) {
                        $productsList[$key]->product_list_status = 1;
                    }
                    $productsList[$key]->city_id = settype(AuthAssignment::getCityIdByUserId(Yii::$app->user->identity->id), 'INTEGER');
                }
                $count = count($products);
                for ($i=0; $i < $count; $i++) {
                    if(!$products[$i]->validate()) {
                        return $this->render('add-by-excel', ['error' => TRUE, 'message' => $products[$i]->getErrors()]);
                    } elseif (!$productsList[$i]->validate()) {
                        return $this->render('add-by-excel', ['error' => TRUE, 'message' => $productsList[$i]->getErrors()]);
                    }
                }
                for ($i=0; $i < $count; $i++) {
                    if ($products[$i]->save()) {
                        $productsList[$i]->product_id = $products[$i]->product_id;
                        if (!$productsList[$i]->save()) {
                            return $this->render('add-by-excel', ['error' => TRUE, 'message' => $productsList[$i]->getErrors()]);
                        }
                        if($i + 1 == $count) {
                            return $this->render('add-by-excel', ['success' => TRUE, 'message' => 'Товары успешно добавлены']);
                        }
                    } else {
                        return $this->render('add-by-excel', ['error' => TRUE, 'message' => $products[$i]->getErrors()]);
                    }
                }
                return 'asd';
            } else {
                return $this->render('add-by-excel');
            }
        } else {
            throw new ForbiddenHttpException('Доступ запрещен');
        }
    }

    public function actionAddShop()
    {
        if (Yii::$app->helperComponent->getRole() == 'seller') {
            if (!SellersInfo::isShopAdded(Yii::$app->user->id)) {
                return $this->render('add-shop');
            } else {

            }
        } else {
            throw new ForbiddenHttpException('Доступ запрещен');
        }
    }
}
