<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "sections".
 *
 * @property string $section_id
 * @property string $section_name
 */
class Sections extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sections';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['section_name'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'section_id' => 'Section ID',
            'section_name' => 'Section Name',
        ];
    }
}
