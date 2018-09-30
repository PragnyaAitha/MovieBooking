<?php

use yii\db\Migration;

class m180927_072944_user extends Migration
{
    public function up()
    {
    	$this->createTable('user', [
    		'id' => $this->primaryKey(),
    		'name' => $this->string()->notNull(),
    		'city_id' => $this->integer()->notNull(),
    		'mobile_number' => $this->integer()->notNull(),
    		'created_at' => $this->dateTime()->notNull(),
    		'updated_at' => $this->dateTime()->notNull(),
    	]);

    	$this->addForeignKey(
            'fk-user-city_id', 'user', 'city_id', 'city', 'id', 'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('user');
    }
}
