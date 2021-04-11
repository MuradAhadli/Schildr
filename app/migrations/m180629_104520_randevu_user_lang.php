<?php

use yii\db\Migration;

/**
 * Class m180629_104520_randevu_user_lang
 */
class m180629_104520_randevu_user_lang extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('ALTER TABLE `easyii_randevu` ADD `user_lang` VARCHAR(2) NULL AFTER `user_id`;');
        $this->execute('ALTER TABLE `easyii_consultation` ADD `user_lang` VARCHAR(2) NULL AFTER `created_by`;');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180629_104520_randevu_user_lang cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180629_104520_randevu_user_lang cannot be reverted.\n";

        return false;
    }
    */
}
