<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "cities".
 *
 * @property integer $city_id
 * @property string $city_name
 */
class Cities extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cities';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city_name'], 'required'],
            [['city_name'], 'string', 'max' => 150],
            [['city_name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'city_id' => 'City ID',
            'city_name' => 'City Name',
        ];
    }

    public static function getCityNameById($city_id)
    {
        return static::find()->select('city_name')->asArray()->where(['city_id' => $city_id])->one();
    }
}
