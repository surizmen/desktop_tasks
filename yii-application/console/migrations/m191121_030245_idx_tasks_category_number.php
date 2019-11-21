<?php

use yii\db\Migration;

/**
 * Class m191121_030245_idx_tasks_category_number
 */
class m191121_030245_idx_tasks_category_number extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // creates index for column `tasks_category_number`
        $this->createIndex(
            '{{%idx_tasks_category_number}}',
            '{{%tasks}}',
            'tasks_category_number'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops index for column `tasks_category_number`
        $this->dropIndex(
            '{{%idx_tasks_category_number}}',
            '{{%tasks}}'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191121_030245_idx_tasks_category_number cannot be reverted.\n";

        return false;
    }
    */
}
