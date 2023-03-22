<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%transaction_logs}}".
 *
 * @property int $id
 * @property string|null $transaction_id
 * @property string|null $username
 * @property string|null $tran_type
 * @property float|null $amount
 * @property float|null $before_balance
 * @property float|null $after_balance
 * @property string|null $currency
 * @property string|null $remark
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $deleted_at
 */
class transaction_logs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%transaction_logs}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount', 'before_balance', 'after_balance'], 'number'],
            [['remark'], 'string'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['transaction_id', 'username'], 'string', 'max' => 64],
            [['tran_type', 'currency'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'transaction_id' => 'Transaction ID',
            'username' => 'Username',
            'tran_type' => 'Tran Type',
            'amount' => 'Amount',
            'before_balance' => 'Before Balance',
            'after_balance' => 'After Balance',
            'currency' => 'Currency',
            'remark' => 'Remark',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
}
