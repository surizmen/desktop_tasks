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
            //email: admin@admin.ru password: admin
            ['username','password_hash','email','city_id','created_at','updated_at'],
            [['admin','$2y$13$nUMdR.QP5F7kkzsRBmW7ger4k3gPoYaE76IuRyr11shdmFsI3XGYK','admin@admin.ru','1','123123','123123123']]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%user}}', ['in', ['username','password_hash'], ['admin','$2y$13$nUMdR.QP5F7kkzsRBmW7ger4k3gPoYaE76IuRyr11shdmFsI3XGYK']]);
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
