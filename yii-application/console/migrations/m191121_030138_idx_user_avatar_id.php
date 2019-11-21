<?php

use yii\db\Migration;

/**
 * Class m191121_030138_idx_user_avatar_id
 */
class m191121_030138_idx_user_avatar_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // creates index for column `avatar_id`
        $this->createIndex(
            '{{%idx_user_avatar_id}}',
            '{{%user}}',
            'avatar_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops index for column `avatar_id`
        $this->dropIndex(
            '{{%idx_user_avatar_id}}',
            '{{%user}}'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191121_030138_idx_user_avatar_id cannot be reverted.\n";

        return false;
    }
    */
}
