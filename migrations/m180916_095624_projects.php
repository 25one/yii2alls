<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m180916_095624_projects
 */
class m180916_095624_projects extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('projects', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING,
        ]);
        $this->batchInsert('projects', ['name'], [
          ['ПРОЕКТ 1'],
          ['ПРОЕКТ 2'],
          ['ПРОЕКТ 3'],
          ['ПРОЕКТ 4'],
          ['ПРОЕКТ 5'],
          ['ПРОЕКТ 6'],
          ['ПРОЕКТ 7'],          
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180916_095624_projects cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180916_095624_projects cannot be reverted.\n";

        return false;
    }
    */
}
