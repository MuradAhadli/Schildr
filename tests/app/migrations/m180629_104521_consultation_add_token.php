<?php

use yii\db\Migration;

/**
 * Class m180629_104521_consultation_add_token
 */
class m180629_104521_consultation_add_token extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('ALTER TABLE `easyii_consultation` ADD `token` VARCHAR(50) NOT NULL AFTER `private`;');
        $this->execute('UPDATE `easyii_consultation` SET `token`="asd"');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180629_104521_consultation_add_token cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180629_104521_consultation_add_token cannot be reverted.\n";

        return false;
    }
    */
}
