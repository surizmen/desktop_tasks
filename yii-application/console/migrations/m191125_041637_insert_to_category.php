<?php

use yii\db\Migration;

/**
 * Class m191125_041637_insert_to_category
 */
class m191125_041637_insert_to_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%categories}}',['categories_name'], [['Техника'],['Одежда']]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->delete('{{%categories}}', ['in', 'categories_name', ['Техника', 'Одежда']]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191125_041637_insert_to_category cannot be reverted.\n";

        return false;
    }
    */
}
