<?php

use yii\db\Migration;

/**
 * Class m191125_055253_insert_to_user
 */
class m191125_055253_insert_to_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%user}}',
            ['username','auth_key','password_hash','email','city_id','created_at','updated_at'],
            [['dfgdfgdfgdfg','fdgtdfgdfgg','34gedfgrg','kek@kesk.ru','1','123123','123123123']]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%user}}', ['in', ['username','auth_key'], ['dfgdfgdfgdfg','fdgtdfgdfgg']]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191125_055253_insert_to_user cannot be reverted.\n";

        return false;
    }
    */
}
