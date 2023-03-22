<?php

use yii\db\Migration;

/**
 * Class m230320_071414_yii2basic_patrons
 */
class m230320_071414_yii2basic_patrons extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('patrons', 
        [
            'id'          =>    $this->bigPrimaryKey(),
            'username'    =>    $this->string(64),
            'password'    =>    $this->string(64),
            'salt'        =>    $this->string(64),
            'access_token'=>    $this->string()->defaultValue(""),
            'currency'    =>    $this->string(32)->defaultValue("MYR"),
            'remark'      =>    $this->text(),
            'created_at'  =>    $this->date(),
            'updated_at'  =>    $this->timestamp(),
            'deleted_at'  =>    $this->date(),      
        ],'charset = utf8');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropTable('patrons');    
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230320_071414_yii2basic_patrons cannot be reverted.\n";

        return false;
    }
    */
}
