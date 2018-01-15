<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "ratings".
 *
 * @property string $rating_id
 * @property string $user_id
 * @property string $product_id
 * @property string $shop_id
 * @property integer $rating_value
 */
class Ratings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ratings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'rating_value'], 'required'],
            [['user_id', 'product_id', 'shop_id', 'rating_value'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rating_id' => 'Rating ID',
            'user_id' => 'User ID',
            'product_id' => 'Product ID',
            'shop_id' => 'Shop ID',
            'rating_value' => 'Rating Value',
        ];
    }
}
