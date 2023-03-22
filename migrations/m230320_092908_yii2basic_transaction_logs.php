<?php

use yii\db\Migration;

/**
 * Class m230320_092908_yii2basic_transaction_logs
 */
class m230320_092908_yii2basic_transaction_logs extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('transaction_logs', 
        [
            'id'            =>    $this->bigPrimaryKey(),
            'transaction_id'=>    $this->string(64),
            'username'      =>    $this->string(64),
            'tran_type'     =>    $this->string(32),
            'amount'        =>    $this->double()->defaultValue(0),
            'before_balance'=>    $this->double()->defaultValue(0),
            'after_balance' =>    $this->double()->defaultValue(0),
            'currency'      =>    $this->string(32)->defaultValue("MYR"),
            'remark'        =>    $this->text(),
            'created_at'    =>    $this->timestamp(),
            'updated_at'    =>    $this->timestamp(),
            'deleted_at'    =>    $this->date(),      
        ],'charset = utf8');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('transaction_logs');   
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230320_092908_yii2basic_transaction_logs cannot be reverted.\n";

        return false;
    }
    */
}
