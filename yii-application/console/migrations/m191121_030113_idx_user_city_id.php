<?php

use yii\db\Migration;

/**
 * Class m191121_030113_idx_user_city_id
 */
class m191121_030113_idx_user_city_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // creates index for column `city_id`
        $this->createIndex(
            '{{%idx_user_city_id}}',
            '{{%user}}',
            'city_id'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops index for column `city_id`
        $this->dropIndex(
            '{{%idx_user_city_id}}',
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
        echo "m191121_030113_idx_user_city_id cannot be reverted.\n";

        return false;
    }
    */
}
