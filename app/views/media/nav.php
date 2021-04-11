<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 5/4/2018
 * Time: 5:34 PM
 */

use yii\helpers\Html;
?>

<div class="media-nav">
    <div class="row text-center">
        <div class="col-6 item pr-0 <?= ($active == 'photo') ? 'active' : '' ?>">
            <div>
                <a href="<?= \yii\helpers\Url::to(['/media/photo', 'page_slug' => 'foto']) ?>">
                    <span class="d-md-block d-none">
                        <?= Html::encode(yii::t('db', 'Photo gallery')) ?>
                    </span>
                    <span class="d-block d-md-none">
                        <?= Html::encode(yii::t('db', 'Photo')) ?>
                    </span>
                </a>
            </div>
        </div>
        <div class="col-6 item pl-0 <?= ($active == 'video') ? 'active' : '' ?>">
            <div>
                <a href="<?= \yii\helpers\Url::to(['/media/video', 'page_slug' => 'video']) ?>">
                    <span class="d-md-block d-none">
                        <?= Html::encode(yii::t('db', 'Video gallery')) ?>
                    </span>
                    <span class="d-block d-md-none">
                        <?= Html::encode(yii::t('db', 'Video')) ?>
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>
