<?php

use yii\db\Migration;

/**
 * Class m230320_092856_yii2basic_wallets
 */
class m230320_092856_yii2basic_wallets extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('wallets', 
        [
            'id'          =>    $this->bigPrimaryKey(),
            'balance'     =>    $this->float()->defaultValue(0),
            'patronId'    =>    $this->bigInteger(),
            'created_at'  =>    $this->timestamp(),
            'updated_at'  =>    $this->timestamp(),
            'deleted_at'  =>    $this->date(),      
        ],'charset = utf8'
        );

        $this->addForeignKey(
            'fk_patron_wallet_id',
            'wallets',
            'patronId',
            'patrons',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('wallets');   
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230320_092856_yii2basic_wallets cannot be reverted.\n";

        return false;
    }
    */
}
