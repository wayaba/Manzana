<?php

use yii\db\Migration;

class m160324_025956_socios extends Migration
{
    public function up()
    {
    	if ($this->db->driverName === 'mysql') {
    		// http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
    		$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
    	}
    	
    	$this->createTable('{{%socio}}', [
    			'id' => $this->primaryKey(),
    			'codigo' => $this->smallInteger()->notNull(),
    			'nombre' => $this->string(100)->notNull(),
    			'apellido' => $this->string(100)->notNull(),
    			'fecha_nacimiento' => $this->date(),
    			'sexo' => $this->smallInteger(),
    			'fecha_inscripcion' => $this->date(),
    			'tiene_apto_medico' => $this->smallInteger()->notNull()->defaultValue(0),
    			'fecha_vencimiento_apto_medico' => $this->date(),
    			'email' => $this->string(100)->unique(),
    			'dni' => $this->string(20),
    			'telefono' => $this->string(20),
    			'telefono_emergencia' => $this->string(20),
    			'estado' => $this->smallInteger()->notNull()->defaultValue(1),
    			'facebook_id' => $this->string(100)->unique(),
    			
    			'created_at' => $this->integer()->notNull(),
    			'updated_at' => $this->integer()->notNull(),
    	], $tableOptions);

    	$this->createTable('{{%pago}}', [
    			'id' => $this->primaryKey(),
    			'socio_id' => $this->integer()->notNull(),
    			'fecha_pago' => $this->date()->notNull(),
    			'monto' => $this->decimal(10,2)->notNull(),
    			'valor_cuota' => $this->decimal(10,2)->notNull(),
    			
    			'created_at' => $this->integer()->notNull(),
    			'updated_at' => $this->integer()->notNull(),
    	], $tableOptions);
    	
    	$this->createTable('{{%medida}}', [
    			'id' => $this->primaryKey(),
    			'socio_id' => $this->integer()->notNull(),
    			'peso' => $this->decimal(10,2),
    			'altura' => $this->decimal(10,2),

    			'created_at' => $this->integer()->notNull(),
    			'updated_at' => $this->integer()->notNull(),
    	], $tableOptions);
    	 

    	$this->createTable('{{%configuracion}}', [
    			'id' => $this->primaryKey(),
    			'valor_cuota' => $this->decimal(10,2)->notNull(),

    			'created_at' => $this->integer()->notNull(),
    			'updated_at' => $this->integer()->notNull(),
    	], $tableOptions);
    	 
    	$this->addForeignKey('fk-socio_pago-socio_id', 'pago', 'socio_id', 'socio', 'id', 'CASCADE');
    	$this->addForeignKey('fk-socio_medida-socio_id', 'medida', 'socio_id', 'socio', 'id', 'CASCADE');
    	 
    }

    public function down()
    {
        echo "m160324_025956_socios cannot be reverted.\n";

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
