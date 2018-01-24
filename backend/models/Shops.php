<?php

namespace backend\models;

use api\models\ShopRating;
use Yii;

/**
 * This is the model class for table "shops".
 *
 * @property integer $shop_id
 * @property integer $user_id
 * @property string $shop_name
 * @property string $shop_img
 * @property integer $shop_min_price
 * @property string $shop_open_time
 * @property string $shop_close_time
 * @property integer $shop_delivery_price
 * @property string $shop_pay_options
 * @property string $shop_contacts
 * @property string $shop_description
 * @property integer $shop_rating
 * @property integer $city_id
 * @property integer $shop_fast_delivery
 * @property integer $shop_top
 */
class Shops extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shops';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'shop_name', 'city_id', 'shop_fast_delivery', 'shop_top'], 'required'],
            [['user_id', 'shop_min_price', 'shop_delivery_price', 'city_id', 'shop_fast_delivery', 'shop_top'], 'integer'],
            [['shop_rating'], 'number'],
            [['shop_open_time', 'shop_close_time'], 'safe'],
            [['shop_pay_options', 'shop_contacts', 'shop_description'], 'string'],
            [['shop_name', 'shop_img'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'shop_id' => 'Shop ID',
            'user_id' => 'User ID',
            'shop_name' => 'Shop Name',
            'shop_img' => 'Shop Img',
            'shop_min_price' => 'Shop Min Price',
            'shop_open_time' => 'Shop Open Time',
            'shop_close_time' => 'Shop Close Time',
            'shop_delivery_price' => 'Shop Delivery Price',
            'shop_pay_options' => 'Shop Pay Options',
            'shop_contacts' => 'Shop Contacts',
            'shop_description' => 'Shop Description',
            'shop_rating' => 'Shop Rating',
            'city_id' => 'City ID',
            'shop_fast_delivery' => 'Shop Fast Delivery',
            'shop_top' => 'Shop Top',
        ];
    }

    public static function getUserIdByShopId($shop_id)
    {
        $shop = static::findOne(['shop_id' => $shop_id]);
        return $shop->user_id;
    }

    public static function getShopIdByUserId($user_id)
    {
        $shop = static::findOne(['user_id' => $user_id]);
        return $shop->shop_id;
    }

    public static function setShopRating($shop_id, $rating_value)
    {
        if ($shop = static::findOne(['shop_id' => $shop_id])) {
            $count = ShopRating::find()->where(['shop_id' => $shop_id])->count();
            $new_rating = ($shop->shop_rating * ($count -1) + $rating_value) / $count;
            $new_rating = round($new_rating, 1);
            $shop->shop_rating = $new_rating;
            if ($shop->save()) {
                return $shop;
            } else {
                return NULL;
            }
        } else {
            return NULL;
        }
    }
}
