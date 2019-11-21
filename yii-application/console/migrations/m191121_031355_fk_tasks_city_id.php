<?php

use yii\db\Migration;

/**
 * Class m191121_031355_fk_tasks_city_id
 */
class m191121_031355_fk_tasks_city_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // add foreign key for table `{{%tasks}}`
        $this->addForeignKey(
            '{{%fk_tasks_city_id}}',
            '{{%tasks}}',
            'tasks_city_id',
            '{{%cities}}',
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
            '{{%fk_tasks_city_id}}',
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
        echo "m191121_031355_fk_tasks_city_id cannot be reverted.\n";

        return false;
    }
    */
}
