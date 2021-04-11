<?php

use yii\db\Migration;

/**
 * Class m180629_104520_mailaddresses
 */
class m180629_104521_mailaddresses extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('CREATE TABLE `easyii_mailaddresses` (
                              `faq_id` int(11) NOT NULL,
                              `name` varchar(50) NOT NULL,
                              `tech_name` varchar(50) NOT NULL,
                              `email` varchar(50) NOT NULL,
                              `order_num` int(11) DEFAULT NULL,
                              `status` tinyint(1) DEFAULT \'1\'
                            ) ENGINE=MyISAM DEFAULT CHARSET=utf8;');

        $this->execute("INSERT INTO `easyii_mailaddresses` (`faq_id`, `name`, `tech_name`, `email`, `order_num`, `status`) VALUES
                                (4, 'Randevu və checkup', 'appointment', 'reseption@mediland.az', 1, 1),
                                (7, 'Əlaqə və Şöbələrdəki forma', 'contact_form', 'info@mediland.az', 4, 1),
                                (6, 'Konsultasiya', 'consultation', 'n.abdullayeva@mediland.az', 3, 1);");

        $this->execute('ALTER TABLE `easyii_mailaddresses` ADD PRIMARY KEY (`faq_id`);');
        $this->execute('ALTER TABLE `easyii_mailaddresses` MODIFY `faq_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180629_104520_mailaddresses cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180629_104520_mailaddresses cannot be reverted.\n";

        return false;
    }
    */
}
