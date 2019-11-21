<?php

use yii\db\Migration;

/**
 * Class m191121_031420_fk_tasks_status_number
 */
class m191121_031420_fk_tasks_status_number extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // add foreign key for table `{{%tasks}}`
        $this->addForeignKey(
            '{{%fk_tasks_status_number}}',
            '{{%tasks}}',
            'tasks_status_number',
            '{{%status}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%tasks}}`
        $this->dropForeignKey(
            '{{%fk_tasks_status_number}}',
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
        echo "m191121_031420_fk_tasks_status_number cannot be reverted.\n";

        return false;
    }
    */
}
