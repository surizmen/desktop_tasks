<?php

use yii\db\Migration;

/**
 * Class m191121_031311_fk_user_city_id
 */
class m191121_031311_fk_user_city_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk_user_city_id}}',
            '{{%user}}',
            'city_id',
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
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk_user_city_id}}',
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
        echo "m191121_031311_fk_user_city_id cannot be reverted.\n";

        return false;
    }
    */
}
