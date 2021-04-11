<?php

use yii\db\Migration;

class create_photo_youtube_id extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE `easyii_photos` ADD `youtube_id` INT NOT NULL AFTER `thumb`;');
        $this->execute('ALTER TABLE `easyii_photos` CHANGE `youtube_id` `youtube_id` VARCHAR(125) NOT NULL;');
        $this->execute('ALTER TABLE `easyii_photos` ADD `type` TINYINT(1) NOT NULL AFTER `youtube_id`;');
    }

    public function down()
    {
        echo "create_photo_youtube_id cannot be reverted.\n";

        return false;
    }

}
