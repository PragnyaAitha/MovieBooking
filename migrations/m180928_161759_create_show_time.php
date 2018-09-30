<?php

use yii\db\Migration;

class m180928_161759_create_show_time extends Migration
{
    public function up()
    {
        $this->createTable('show_time', [
            'id' => $this->primaryKey(),
            'timing' => $this->time()->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
        ]);
    }

    public function down()
    {
       $this->dropTable('show_time');
    }
    
}
