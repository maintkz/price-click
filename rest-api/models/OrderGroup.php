<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "order_group".
 *
 * @property integer $id
 * @property integer $count
 * @property integer $overall_summ
 * @property string $address
 * @property string $description
 * @property integer $mobile_user_id
 * @property integer $shop_id
 * @property integer $status
 * @property string $updated_date
 * @property string $created_date
 */
class OrderGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['count', 'overall_summ', 'address', 'mobile_user_id', 'shop_id', 'status'], 'required'],
            [['count', 'overall_summ', 'mobile_user_id', 'shop_id', 'status'], 'integer'],
            [['description'], 'string'],
            [['updated_date', 'created_date'], 'safe'],
            [['address'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'count' => 'Count',
            'overall_summ' => 'Overall Summ',
            'address' => 'Address',
            'description' => 'Description',
            'mobile_user_id' => 'Mobile User ID',
            'shop_id' => 'Shop ID',
            'status' => 'Status',
            'updated_date' => 'Updated Date',
            'created_date' => 'Created Date',
        ];
    }

    public static function isSelfOrder($mobile_user_id, $order_group_id)
    {
        if (static::findOne(['mobile_user_id' => $mobile_user_id, 'id' => $order_group_id])) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
