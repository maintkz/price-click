<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "dealers_info".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $address
 * @property string $phone
 * @property string $description
 * @property string $date
 */
class DealersInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dealers_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['address', 'phone', 'description'], 'required', 'message' => 'Поле обязательно для заполнения'],
            [['user_id'], 'integer'],
            [['description'], 'string'],
            [['date', 'user_id'], 'safe'],
            [['address'], 'string', 'max' => 2000],
            [['phone'], 'string', 'max' => 50],
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
            'date' => 'Date',
        ];
    }
}
