<?php

use yii\db\Migration;

class m180928_193926_create_bookings extends Migration
{
    public function up()
    {
        $this->createTable('booking', [
            'id' => $this->primaryKey(),
            'booking_date' => $this->dateTime()->notNull(),
            'movie_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'cinema_hall_id' => $this->integer()->notNull(),
            'show_time_id' => $this->integer()->notNull(),
            'booking_value' => $this->float()->notNull(),
            'city_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]
        );

        $this->addForeignKey(
            'fk-booking-movie_id', 'booking', 'movie_id', 'movie', 'id', 'CASCADE'
        );

        $this->addForeignKey(
            'fk-booking-user_id', 'booking', 'user_id', 'user', 'id', 'CASCADE'
        );

        $this->addForeignKey(
            'fk-booking-cinema_hall_id', 'booking', 'cinema_hall_id', 'cinema_hall', 'id', 'CASCADE'
        );

        $this->addForeignKey(
            'fk-booking-city_id', 'booking', 'city_id', 'city', 'id', 'CASCADE'
        );

        $this->addForeignKey(
            'fk-booking-show_time_id', 'booking', 'show_time_id', 'show_time', 'id', 'CASCADE'
        );
        
    }

    public function down()
    {
        $this->dropTable('booking');
    }
}
