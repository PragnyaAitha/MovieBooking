<?php

use yii\db\Migration;

class m180929_110222_add_foreign_key_to_cinema_hall extends Migration
{
    public function up()
    {
        $this->addColumn('cinema_hall', 'theatre_id', 'integer');

        $this->addForeignKey(
            'fk-cinema_hall_theatre_id', 'cinema_hall', 'theatre_id', 'theatre', 'id', 'CASCADE'
        );
    }

    public function down()
    {
        $this->dropColumn('cinema_hall', 'theatre_id');
    }
    
}
