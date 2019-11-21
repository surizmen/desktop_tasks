<?php

use yii\db\Migration;

/**
 * Class m191121_030217_idx_tasks_city_id
 */
class m191121_030217_idx_tasks_city_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // creates index for column `city_id`
        $this->createIndex(
            '{{%idx_tasks_city_id}}',
            '{{%tasks}}',
            'tasks_city_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops index for column `city_id`
        $this->dropIndex(
            '{{%idx_tasks_city_id}}',
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
        echo "m191121_030217_idx_tasks_city_id cannot be reverted.\n";

        return false;
    }
    */
}
