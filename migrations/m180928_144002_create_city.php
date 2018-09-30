<?php

use yii\db\Migration;

class m180928_144002_create_city extends Migration
{
    public function up()
    {
        $this->createTable('city', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
        ]
        );
    }

    public function down()
    {
        $this->dropTable('city');
    }
    
}
