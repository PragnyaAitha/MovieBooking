<?php

use yii\db\Migration;

class m180928_191939_create_tickets extends Migration
{
    public function up()
    {
        $this->createTable('ticket', [
            'id' => $this->primaryKey(),
            'ticket_date' => $this->date()->notNull(),
            'ticket_price' => $this->float()->notNull(),
            'cinema_hall_id' => $this->integer()->notNull(),
            'movie_id' => $this->integer()->notNull(),
            'show_time_id' => $this->integer()->notNull(),
            'city_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]
        );

        $this->addForeignKey(
            'fk-ticket-cinema_hall_id', 'ticket', 'cinema_hall_id', 'cinema_hall', 'id', 'CASCADE'
        );

        $this->addForeignKey(
            'fk-ticket-movie_id', 'ticket', 'movie_id', 'movie', 'id', 'CASCADE'
        );

        $this->addForeignKey(
            'fk-ticket-city_id', 'ticket', 'city_id', 'city', 'id', 'CASCADE'
        );

        $this->addForeignKey(
            'fk-ticket-show_time_id', 'ticket', 'show_time_id', 'show_time', 'id', 'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('ticket');
    }   
}
