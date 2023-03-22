<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%patrons}}".
 *
 * @property int $id
 * @property string|null $username
 * @property string|null $password
 * @property string|null $salt
 * @property string|null $access_token
 * @property string|null $currency
 * @property string|null $remark
 * @property string|null $created_at
 * @property string $updated_at
 * @property string|null $deleted_at
 */
class Patrons extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%patrons}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['remark'], 'string'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['username', 'password', 'salt'], 'string', 'max' => 64],
            [['access_token'], 'string', 'max' => 255],
            [['currency'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'salt' => 'Salt',
            'access_token' => 'Access Token',
            'currency' => 'Currency',
            'remark' => 'Remark',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
}
