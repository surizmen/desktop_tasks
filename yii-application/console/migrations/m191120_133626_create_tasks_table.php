<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tasks}}`.
 */
class m191120_133626_create_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tasks}}', [
            'tasks_id' => $this->primaryKey(),
            'tasks_title' => $this->text()->notNull(),
            'tasks_body' => $this->text(),
            'tasks_city_id' => $this->integer()->notNull(),
            'tasks_price' => $this->decimal(255,4)->notNull(),
            'tasks_date_upload' => $this->dateTime()->notNull(),
            'tasks_status_number' => $this->integer()->notNull(),
            'tasks_category_number' => $this->integer()->notNull(),
            'tasks_photo_id' => $this->integer(),
            'tasks_user_id' => $this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tasks}}');
    }
}
