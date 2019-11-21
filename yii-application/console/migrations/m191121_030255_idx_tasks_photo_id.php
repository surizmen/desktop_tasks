<?php

use yii\db\Migration;

/**
 * Class m191121_030255_idx_tasks_photo_id
 */
class m191121_030255_idx_tasks_photo_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // creates index for column `city_id`
        $this->createIndex(
            '{{%idx_tasks_photo_id}}',
            '{{%tasks}}',
            'tasks_photo_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops index for column `tasks_photo_id`
        $this->dropIndex(
            '{{%idx_tasks_photo_id}}',
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
        echo "m191121_030255_idx_tasks_photo_id cannot be reverted.\n";

        return false;
    }
    */
}
