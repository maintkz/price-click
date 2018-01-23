<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "products_list".
 *
 * @property string $product_list_id
 * @property string $shop_id
 * @property string $product_id
 * @property string $section_id
 * @property string $category_id
 * @property string $subcategory_id
 * @property integer $user_id
 * @property integer $city_id
 * @property string $product_list_count
 * @property integer $product_list_status
 */
class ProductsList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'product_id', 'section_id', 'category_id', 'subcategory_id', 'product_list_count', 'product_list_status', 'user_id', 'city_id'], 'integer'],
            [['product_list_count'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_list_id' => 'Product List ID',
            'user_id' => 'User ID',
            'product_id' => 'Product ID',
            'section_id' => 'Section ID',
            'category_id' => 'Category ID',
            'subcategory_id' => 'Subcategory ID',
            'product_list_count' => 'Product List Count',
            'product_list_status' => 'Product List Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['product_id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShop()
    {
        return $this->hasOne(Shops::className(), ['shop_id' => 'shop_id']);
    }

    public static function getShopByProductId($product_id)
    {
        $product = static::findOne(['product_id' => $product_id]);
        return $product->shop_id;
    }
}
