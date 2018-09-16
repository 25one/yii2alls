<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m180428_181614_create_start
 */
class m180428_181614_create_start extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180428_181614_create_start cannot be reverted.\n";

        return false;
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

        $this->createTable('news', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'content' => Schema::TYPE_TEXT,
        ]);

    }

    public function down()
    {
        echo "m180428_181614_create_start cannot be reverted.\n";

        return false;

        //$this->dropTable('news');

    }

}
