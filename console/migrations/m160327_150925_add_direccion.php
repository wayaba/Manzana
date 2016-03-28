<?php

use yii\db\Migration;
use yii\db\Schema;

class m160327_150925_add_direccion extends Migration
{
    public function up()
    {
    	$this->addColumn('{{%socio}}','direccion_calle',Schema::TYPE_STRING);
    	$this->addColumn('{{%socio}}','direccion_numero',Schema::TYPE_STRING);
    	$this->addColumn('{{%socio}}','direccion_localidad',Schema::TYPE_STRING);
    	$this->addColumn('{{%socio}}','direccion_provincia',Schema::TYPE_STRING);
    	$this->addColumn('{{%socio}}','direccion_codigo_postal',Schema::TYPE_STRING);
    	$this->addColumn('{{%socio}}','direccion_departamento',Schema::TYPE_STRING);
    }

    public function down()
    {
        echo "m160327_150925_add_direccion cannot be reverted.\n";

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
