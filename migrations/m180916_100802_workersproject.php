<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m180916_100802_workersproject
 */
class m180916_100802_workersproject extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->createTable('{{%workersproject}}', [
            'id' => Schema::TYPE_PK,
            'id_worker' => Schema::TYPE_INTEGER,
            'id_project' => Schema::TYPE_INTEGER,
       ]);
       $this->createIndex('FK_workersproject_workers', '{{%workersproject}}', 'id_worker');
       $this->addForeignKey(
            'FK_workersproject_workers', '{{%workersproject}}', 'id_worker', '{{%workers}}', 'id', 'SET NULL', 'CASCADE'
       );     
       $this->createIndex('FK_workersproject_projects', '{{%workersproject}}', 'id_project');
       $this->addForeignKey(
            'FK_workersproject_projects', '{{%workersproject}}', 'id_project', '{{%projects}}', 'id', 'SET NULL', 'CASCADE'
       );                
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180916_100802_workersproject cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180916_100802_workersproject cannot be reverted.\n";

        return false;
    }
    */
}
