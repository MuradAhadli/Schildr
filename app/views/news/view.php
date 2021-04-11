<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 5/3/2018
 * Time: 5:30 PM
 */

use \yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

$this->title = Html::encode($news['title']);
?>

<div class="doctor check-up news news-in">
    <section class="section-gray">

        <div class="row">
            <div class="col-12">

                <?php if($content['title']): ?>
                    <h2 class="section-title <?= isset($content['parent_title']) ? 'clear': '' ?>">
                        <?= Html::encode($content['title']) ?>
                    </h2>
                <?php endif; ?>

            </div>
        </div>

        <div class="row flex-column-reverse flex-md-row">
            <div class="col-md-4 col-12 pr-xl-4 mt-4 mt-md-0">

                <div class="info-items check-up-list other-news-list">
                    <div class="title">
                        <?= Html::encode(yii::t('db', 'Other news')) ?>
                    </div>

                    <ul class="list-unstyled items">
                        <?php foreach ($other_news as $item):

                                $url = Url::to(['/news/view', 'page_slug' => 'news', 'id' => $item['id'], 'slug' => $item['slug']]);
                            ?>
                            <li class="item">
                                <div class="date">
                                    <?= date('d.m.Y', $item['time']) ?>
                                </div>
                                <div class="title">
                                    <a href="<?= $url ?>">
                                        <?= Html::encode($item['title']) ?>
                                    </a>
                                </div>
                                <div class="short">
                                    <a href="<?= $url ?>">
                                        <?= HtmlPurifier::process($item['short']) ?>
                                    </a>
                                </div>
                                <a href="<?= $url ?>" class="btn btn-success">
                                    <?= Html::encode(yii::t('db', 'read more')) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

            </div>

            <div class="col-md-8 col-12 pl-xl-4">
                <h2 class="section-title">

                    <div class="short m-0">
                        <?= isset($content['title']) ? Html::encode($news['title']) : Html::encode($news['short']) ?>
                    </div>
                </h2>

                <div class="text">
                    <?= HtmlPurifier::process($news['text']) ?>
                </div>

                <?= \app\widgets\Media\MediaWidget::widget([
                        'class_name' => 'yii\easyii\modules\news\models\News',
                        'item_id' => $news['id']
                    ]);
                ?>
            </div>
        </div>


    </section>
</div>



