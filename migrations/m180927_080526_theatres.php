<?php

use yii\db\Migration;

/**
 * Class m180927_080526_theatres
 */
class m180927_080526_theatres extends Migration
{
    public function up()
    {
        $this->createTable('theatre', [
            'id' => $this->primaryKey(),
            'city_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
    ]); 

        $this->addForeignKey(
            'fk-theatre-city_id', 'theatre', 'city_id', 'city', 'id', 'CASCADE'
        );

    }
    public function down()
    {
        $this->dropTable('theatre');
    }
}
