<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 3/23/2018
 * Time: 3:29 PM
 */

use \yii\helpers\Url;
use \yii\helpers\Html;
use yii\helpers\HtmlPurifier;
$this->title = $title;
?>

<div class="doctors-all">
    <section class="section-gray">
        <div class="row">
            <div class="col-12">

                <?php if($title): ?>
                    <h2 class="section-title"><?= Html::encode($title) ?></h2>
                <?php endif; ?>

                <div class="text">
                    <div class="section-short">
                        <?= HtmlPurifier::process($model['text']) ?>
                    </div>
                </div>
            </div>
        </div>

        <?= \app\widgets\Media\MediaWidget::widget([
            'class_name' => 'yii\easyii\modules\page\models\Page',
            'item_id' => $model['id']
        ]) ?>
    </section>
</div>
