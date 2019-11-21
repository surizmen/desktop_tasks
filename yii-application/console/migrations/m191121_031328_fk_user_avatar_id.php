<?php

use yii\db\Migration;

/**
 * Class m191121_031328_fk_user_avatar_id
 */
class m191121_031328_fk_user_avatar_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk_user_avatar_id}}',
            '{{%user}}',
            'avatar_id',
            '{{%photos}}',
            'photos_id',
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
            '{{%fk_user_avatar_id}}',
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
        echo "m191121_031328_fk_user_avatar_id cannot be reverted.\n";

        return false;
    }
    */
}
