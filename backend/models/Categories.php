<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property string $category_id
 * @property string $category_name
 * @property string $section_id
 */
class Categories extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['section_id'], 'integer'],
            [['category_name'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'Category ID',
            'category_name' => 'Category Name',
            'section_id' => 'Section ID',
        ];
    }
}
