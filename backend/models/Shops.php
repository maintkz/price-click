<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "shops".
 *
 * @property string $shop_id
 * @property string $shop_name
 * @property string $shop_img
 * @property string $shop_min_price
 * @property string $shop_open_time
 * @property string $shop_close_time
 * @property string $shop_delivery_price
 * @property string $shop_pay_options
 * @property string $shop_contacts
 * @property string $shop_description
 * @property integer $shop_status
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
            [['shop_name'], 'required'],
            [['shop_min_price', 'shop_delivery_price', 'shop_status'], 'integer'],
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
            'shop_name' => 'Shop Name',
            'shop_img' => 'Shop Img',
            'shop_min_price' => 'Shop Min Price',
            'shop_open_time' => 'Shop Open Time',
            'shop_close_time' => 'Shop Close Time',
            'shop_delivery_price' => 'Shop Delivery Price',
            'shop_pay_options' => 'Shop Pay Options',
            'shop_contacts' => 'Shop Contacts',
            'shop_description' => 'Shop Description',
            'shop_status' => 'Shop Status',
        ];
    }
}
