<?php

use yii\db\Migration;

/**
 * Class m191121_030233_idx_tasks_status_number
 */
class m191121_030233_idx_status_status_number extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // creates index for column `status_number`
        $this->createIndex(
            '{{%idx_status_status_number}}',
            '{{%status}}',
            'status_number'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops index for column `status_number`
        $this->dropIndex(
            '{{%idx_status_status_number}}',
            '{{%status}}'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191121_030233_idx_tasks_status_number cannot be reverted.\n";

        return false;
    }
    */
}
