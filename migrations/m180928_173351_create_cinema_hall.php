<?php

use yii\db\Migration;

class m180928_173351_create_cinema_hall extends Migration
{
    public function up()
    {
        $this->createTable('cinema_hall', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'city_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
        ]
        );

        $this->addForeignKey(
            'fk-cinema_hall-city_id', 'cinema_hall', 'city_id', 'city', 'id', 'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('cinema_hall');
    }
    
}
