<?php

use yii\db\Migration;

class m180928_124935_movies extends Migration
{  
    public function up()
    {
        $this->createTable('movie', 
        [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'is_active' => $this->integer()->notNull(),
            'city_id' => $this->integer()->notNull(),
            'release_date' => $this->date('Y-m-d H:i:s')->notNull(),
            'end_date' => $this->date('Y-m-d H:i:s')->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
        ]
        );

        $this->addForeignKey(
            'fk-movie-city_id', 'movie', 'city_id', 'city', 'id', 'CASCADE'
        );

        $this->createIndex(
            'idx-movie-city_id', 'movie', 'city_id'
        );

        $this->createIndex(
            'idx-movie-is_active', 'movie', 'is_active'
        );
    }

    public function down()
    {
        $this->dropTable('movie');
    }
}
