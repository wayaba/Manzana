<?php

use yii\db\Migration;
use yii\db\Schema;

class m160328_050006_add_planes extends Migration
{
    public function up()
    {
    	if ($this->db->driverName === 'mysql') {
    		// http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
    		$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
    	}
    	 
    	$this->createTable('{{%plan}}', [
    			'id' => $this->primaryKey(),
    			'configuracion_id' => $this->integer()->notNull(),
    			'valor_cuota' => $this->decimal(10,2)->notNull(),
    			'nombre' => $this->string()->notNull(),
    			'descripcion' => $this->text(),
    			 
    			'created_at' => $this->integer()->notNull(),
    			'updated_at' => $this->integer()->notNull(),
    	], $tableOptions);
    	
    	$this->addColumn('{{%socio}}','plan_id',Schema::TYPE_INTEGER);
    	
    	$this->addForeignKey('fk-plan_configuracion-configuracion_id', 'plan', 'configuracion_id', 'configuracion', 'id', 'CASCADE');
    	$this->addForeignKey('fk-socio_plan-plan_id', 'socio', 'plan_id', 'plan', 'id', 'CASCADE');
    	 
    }

    public function down()
    {
        echo "m160328_050006_add_planes cannot be reverted.\n";

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
