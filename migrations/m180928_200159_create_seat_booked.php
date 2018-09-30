<?php

use yii\db\Migration;

class m180928_200159_create_seat_booked extends Migration
{
    public function up()
    {
        $this->createTable('seat_booked', [
            'id' => $this->primaryKey(),
            'booking_id' => $this->integer()->notNull(),
            'seat_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
        ]
        );

        $this->addForeignKey(
            'fk-seat_booked-booking_id', 'seat_booked', 'booking_id', 'booking', 'id', 'CASCADE'
        );

        $this->addForeignKey(
            'fk-seat_booked-seat_id', 'seat_booked', 'seat_id', 'seat', 'id', 'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('seat_booked');
    }
}
