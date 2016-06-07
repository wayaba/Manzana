<?php

use yii\db\Migration;
use yii\db\Schema;

class m160520_183906_add_admin extends Migration
{
    public function up()
    {
    	$this->addColumn('{{%user}}','admin',Schema::TYPE_INTEGER);
    }

    public function down()
    {
        echo "m160520_183906_add_admin cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
