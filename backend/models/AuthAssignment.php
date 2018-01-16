<?php

namespace backend\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "auth_assignment".
 *
 * @property string $item_name
 * @property string $user_id
 * @property string $status
 * @property integer $created_at
 *
 * @property AuthItem $itemName
 */
class AuthAssignment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_assignment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_name', 'user_id'], 'required'],
            [['created_at', 'status'], 'integer'],
            [['item_name', 'user_id'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_name' => 'Item Name',
            'user_id' => 'User ID',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemName()
    {
        return $this->hasOne(AuthItem::className(), ['name' => 'item_name']);
    }

    /**
     *
     */
    public function authSave($id, $item_name)
    {
        $new_user_id = $id;
        settype($new_user_id, 'string');
        $this->user_id = $new_user_id;
        $this->item_name = $item_name;
        if($this->save()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     *
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     *
     */
    public function getShops()
    {
        return $this->hasOne(Shops::className(), ['user_id' => 'user_id']);
    }
}
