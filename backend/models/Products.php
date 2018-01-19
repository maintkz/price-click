<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property string $product_id
 * @property string $product_name
 * @property string $product_main_img
 * @property string $product_imgs
 * @property integer $product_rating
 * @property string $product_price
 * @property string $product_parameters
 * @property string $product_description
 */
class Products extends \yii\db\ActiveRecord
{
    public $images;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_name', 'product_price'], 'required'],
            [['product_imgs', 'product_imgs_min', 'product_description'], 'string'],
            [['product_rating', 'product_price'], 'integer'],
            [['product_name', 'product_main_img'], 'string', 'max' => 200],
            [['product_parameters'], 'string', 'max' => 2000],
            [['images'], 'file', 'maxFiles' => 10, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'product_name' => 'Product Name',
            'product_main_img' => 'Product Main Img',
            'product_imgs' => 'Product Imgs',
            'product_imgs_min' => 'Product Imgs Min',
            'product_rating' => 'Product Rating',
            'product_price' => 'Product Price',
            'product_parameters' => 'Product Parameters',
            'product_description' => 'Product Description',
        ];
    }

    /**
     * @inheritdoc
     */
    public function serializeProductParameters($json)
    {
        $productParameters = json_decode($json);
        $productPar['colors'] = $productParameters->productColor;
        $productPar['sizes'] = $productParameters->productSize;
        $productPar['parameters'] = (array) $productParameters->productParameters;
        $productPar = array_filter($productPar);
        if(empty($productPar)) {
            $productPar = NULL;
        } else {
            $productPar = serialize($productPar);
        }
        return $productPar;
    }

    public static function getProductById($product_id)
    {
        return static::findOne(['product_id' => $product_id]);
    }
}
