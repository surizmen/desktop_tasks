<?php

use yii\db\Migration;

/**
 * Class m191121_031429_fk_tasks_category_number
 */
class m191121_031429_fk_tasks_category_number extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // add foreign key for table `{{%tasks}}`
        $this->addForeignKey(
            '{{%fk_tasks_category_number }}',
            '{{%tasks}}',
            'tasks_category_number',
            '{{%categories}}',
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
            '{{%fk_tasks_category_number }}',
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
        echo "m191121_031429_fk_tasks_category_number cannot be reverted.\n";

        return false;
    }
    */
}
