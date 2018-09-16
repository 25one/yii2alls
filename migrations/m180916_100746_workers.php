<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m180916_100746_workers
 */
class m180916_100746_workers extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('workers', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING,
            'photo' => Schema::TYPE_STRING,
            'sociability' => Schema::TYPE_INTEGER,
            'engineering' => Schema::TYPE_INTEGER,
            'timemanagement' => Schema::TYPE_INTEGER,
            'languages' => Schema::TYPE_INTEGER,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180916_100746_workers cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180916_100746_workers cannot be reverted.\n";

        return false;
    }
    */
}
