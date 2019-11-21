<?php

use yii\db\Migration;

/**
 * Class m191121_034433_idx_tasks_user_id
 */
class m191121_034433_idx_tasks_user_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx_tasks_user_id}}',
            '{{%tasks}}',
            'tasks_user_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx_tasks_user_id}}',
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
        echo "m191121_034433_idx_tasks_user_id cannot be reverted.\n";

        return false;
    }
    */
}
