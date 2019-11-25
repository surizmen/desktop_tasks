<?php

use yii\db\Migration;

/**
 * Class m191125_040823_insert_to_cities
 */
class m191125_040823_insert_to_cities extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%cities}}',['cities_name'], [['Питер'],['Железногорск'],['Москва']]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%cities}}', ['in', 'cities_name', ['Питер', 'Железногорск','Москва']]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191125_040823_insert_to_cities cannot be reverted.\n";

        return false;
    }
    */
}
