<?php

use yii\db\Migration;

class m180928_182744_create_cinema_hall_seat_mapping extends Migration
{
    public function up()
    {
        $this->createTable('seat', [
            'id' => $this->primaryKey(),
            'seat_no' => $this->integer()->notNull(),
            'cinema_hall_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-seat-cinema_hall_id', 'seat', 'cinema_hall_id', 'cinema_hall', 'id', 'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('seat');
    }
}
