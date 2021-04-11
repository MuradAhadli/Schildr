<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 16.04.2018
 * Time: 14:44
 */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;


$this->title = $content['title'];
?>

<div class="" id="media">
    <section class="section-gray">

        <div class="row">
            <div class="col-12">
                <h2 class="section-title">
                    <?= Html::encode($content['title']) ?>
                </h2>

                <div class="section-short">
                    <?= HtmlPurifier::process($content['text']) ?>
                </div>

                <div class="iframe-block" id="modal_360">
                    <iframe allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true" width="100%" height="100%" src="https://360.az/embed/1136" frameborder="0" allowfullscreen></iframe>

                    <button type="button" id="open_360">
                        <i class="fas fa-compress"></i>
                    </button>

                    <button type="button" id="close_360" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>

    </section>
</div>
