<?php

use yii\db\Migration;

/**
 * Class m191125_041445_insert_to_status_number
 */
class m191125_041445_insert_to_status_number extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%status}}',['status_name','status_number'], [['Активное',1],['Закрытое',2]]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%status}}', ['in', 'status_name', ['Активное', 'Закрытое']]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191125_041445_insert_to_status_number cannot be reverted.\n";

        return false;
    }
    */
}
