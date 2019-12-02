<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%status}}`.
 */
class m191120_141204_create_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%status}}', [
            'id' => $this->primaryKey(),
            'status_name' => $this->text()->notnull(),
            'status_number' => $this->integer()->notnull()->unique(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%status}}');
    }
}
