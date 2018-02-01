<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "sellers_info".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $address
 * @property integer $phone
 * @property string $description
 * @property integer $created_user_id
 * @property integer $income_percent
 * @property integer $shop_added
 * @property integer $verified
 * @property string $responsible
 * @property string $date
 */
class SellersInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sellers_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['address', 'phone', 'description', 'income_percent', 'responsible'], 'required'],
            [['user_id', 'created_user_id', 'income_percent', 'shop_added', 'verified'], 'integer'],
            [['description'], 'string'],
            [['date', 'user_id', 'created_user_id'], 'safe'],
            [['address'], 'string', 'max' => 2000],
            [['phone'], 'string', 'max' => 50],
            [['responsible'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'address' => 'Address',
            'phone' => 'Phone',
            'description' => 'Description',
            'created_user_id' => 'Created User ID',
            'income_percent' => 'Income Percent',
            'responsible' => 'Responsible',
            'date' => 'Date',
        ];
    }

    public static function getShopIdsOfDealer($dealer_id)
    {
        $shops = static::find()
            ->select('`shops`.`shop_id`')
            ->where(['created_user_id' => $dealer_id])
            ->innerJoin('`shops`', '`sellers_info`.`user_id` = `shops`.`user_id`')
            ->asArray()
            ->all();

        if ($shops) {
            for ($i = 0; $i < count($shops); $i++) {
                $shops[$i] = $shops[$i]['shop_id'];
            }
            return $shops;
        } else {
            return NULL;
        }
    }

    public static function getSellerIdsOfDealer($dealer_id)
    {
        $seller_ids = static::find()
            ->select('`user_id`')
            ->where(['created_user_id' => $dealer_id])
            ->asArray()
            ->all();

        if ($seller_ids) {
            for ($i = 0; $i < count($seller_ids); $i++) {
                $seller_ids[$i] = $seller_ids[$i]['user_id'];
            }
            return $seller_ids;
        } else {
            return NULL;
        }
    }

}
