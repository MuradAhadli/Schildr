<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 3/17/2018
 * Time: 2:32 PM
 */

use yii\helpers\Url;
use yii\easyii\models\User;
use yii\helpers\Html;

$content = yii::$app->cache->get('content');

//\yii\helpers\VarDumper::dump($content,10,1); die();

if(yii::$app->session->get('isHome')) {

    $carousel = \app\models\Carousel::getCarousel();
}
else {
    $session = yii::$app->session;

    if($session->has('page_id')) {

        $page_id = $session->get('page_id');

        $carousel = \app\models\Cover::getCovers($page_id, $this->title);
    }
    elseif (isset($this->params['title'])){

        $carousel = \app\models\Cover::defaultCovers($this->params['title']);

    }
    else {
        $carousel = \app\models\Cover::defaultCovers('');
    }
}

?>


<div class="carousel section full-page">
    <div id="carousel" class="<?= (count($carousel) == 1) ? 'slick-none' : '' ?>">

        <?php if(yii::$app->session->get('isHome')):

            $i = 0;

            foreach ($carousel as $k => $v):?>

            <?php if($v['type'] == 1): ?>

                <div class="item">
                    <div class="video">

                        <video loop muted width="100%" height="100%" class="media-video" id="media_video<?= $i ?>" muted>
                            <source src="<?= yii::getAlias('@web').'/'.$v['link'] ?>" type="video/mp4">
                        </video>

                    </div>
                    <div class="video-foreground carousel-foreground" data-elem-id="<?= $i ?>"></div>

                    <div class="slider-caption">
                        <h1 class="title">
                            <?= Html::encode($v['title']) ?>
                        </h1>

                        <h2><?= Html::encode($v['short']) ?></h2>
                    </div>
                </div>

            <?php else: ?>

                <div class="item" style="background-image: url('<?= yii::getAlias('@web').$v['image'] ?>')">

                    <div class="carousel-foreground" data-elem-id="<?= $i ?>"></div>

                    <div class="slider-caption">
                        <h1 class="title">
                            <?= Html::encode($v['short']) ?>
                        </h1>

                        <h2><?= Html::encode($v['short']) ?></h2>
                    </div>
                </div>

            <?php endif;?>

        <?php
                $i++;
                endforeach;
                else:
        ?>

        <?php foreach ($carousel as $k => $v): ?>

            <div class="item " style="background-image: url('<?= yii::getAlias('@web').$v['image'] ?>')">

                <div class="carousel-foreground"></div>

                <h1 class="caption d-md-block d-flex justify-content-center align-items-center">
                    <?php
                        if(isset($content['parent_title'])) {

                            echo $content['parent_title'];
                        }
                        elseif (isset($content['title'])) {
                            echo $content['title'];
                        }
                        else {
                            echo Html::encode($v['title']);
                        }
                        ?>
                </h1>
            </div>

        <?php endforeach; ?>

        <?php endif; ?>

    </div>

    <div class="hot-call d-block d-md-none">
        <div class="call-green">
            <a href="tel:*0303">
                <img src="<?= yii::getAlias('@web').'/app/media/img/call-center.png' ?>">
            </a>
        </div>

        <div class="call-white">
            <a href="tel:*0303">
                <img src="<?= yii::getAlias('@web').'/app/media/img/call-center-white.png' ?>">
            </a>
        </div>
    </div>

    <div class="hot-call d-none d-md-block">
        <div class="call-green">

                <img src="<?= yii::getAlias('@web').'/app/media/img/call-center.png' ?>">

        </div>

        <div class="call-white">

                <img src="<?= yii::getAlias('@web').'/app/media/img/call-center-white.png' ?>">

        </div>
    </div>

    <div class="login-buttons">

        <?php if (yii::$app->user->isGuest): ?>

            <a href="<?= Url::to(['/login']) ?>" class="btn btn-link">
                <?= Html::encode(yii::t('db', 'Log in')) ?>
            </a>

            <a href="<?= Url::to(['/signup']) ?>" class="btn btn-success btn-lg btn-signup">
                <?= Html::encode(yii::t('db', 'Registration')) ?>
            </a>

        <?php endif; ?>

        <?php if(!yii::$app->user->isGuest): ?>

            <a class="btn btn-link username">
                <?= yii::$app->user->identity->firstname.' '.yii::$app->user->identity->lastname ?>
            </a>

            <a href="<?= Url::to(['/logout']) ?>" class="btn btn-success btn-lg btn-signup">
                <?= Html::encode(yii::t('db', 'Log out')) ?>
            </a>

        <?php endif; ?>

    </div>

    <?php if($isHome): ?>

        <?= \app\widgets\Sections\SectionsWidget::widget() ?>

    <?php endif; ?>

</div>
