<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "slider_images".
 *
 * @property integer $slider_image_id
 * @property string $slider_image_url
 * @property integer $slider_image_city_id
 * @property integer $slider_image_status
 * @property string $slider_image_created_at
 */
class SliderImages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'slider_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slider_image_id', 'slider_image_url', 'slider_image_city_id', 'slider_image_status'], 'required'],
            [['slider_image_id', 'slider_image_city_id', 'slider_image_status'], 'integer'],
            [['slider_image_created_at'], 'safe'],
            [['slider_image_url'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'slider_image_id' => 'Slider Image ID',
            'slider_image_url' => 'Slider Image Url',
            'slider_image_city_id' => 'Slider Image City ID',
            'slider_image_status' => 'Slider Image Status',
            'slider_image_created_at' => 'Slider Image Created At',
        ];
    }
}
