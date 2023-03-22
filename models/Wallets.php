<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%wallets}}".
 *
 * @property int $id
 * @property float|null $balance
 * @property int|null $patronId
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $deleted_at
 *
 * @property Patrons $patron
 */
class Wallets extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%wallets}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['balance'], 'number'],
            [['patronId'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['patronId'], 'exist', 'skipOnError' => true, 'targetClass' => Patrons::class, 'targetAttribute' => ['patronId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'balance' => 'Balance',
            'patronId' => 'Patron ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    /**
     * Gets query for [[Patron]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPatron()
    {
        return $this->hasOne(Patrons::class, ['id' => 'patronId']);
    }
}
