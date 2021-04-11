<?php
\app\assets\LightGalleryAsset::register($this);

?>


<!--<section class="section-gray">-->
    <div class="gallery bordered-block mt-lg-5 mt-md-4">
        <div id="animated-thumbnails">
            <div class="row">
                <?php foreach ($models as $model): ?>
                    <?php if ($model['type'] == 1): ?>
                        <div class="lightgallery-image lightgallery-media-video col-md-4 col-12" href="https://www.youtube.com/watch?v=<?= $model['youtube_id'] ?>">
                            <img class="youtube-main-image" src="https://img.youtube.com/vi/<?= $model['youtube_id'] ?>/0.jpg" />
                            <img class="youtube-icon-image" src="<?= yii::getAlias('@web') ?> /app/media/img/icon/youtube.png">
                        </div>
                    <?php else: ?>
                        <div class="lightgallery-image col-md-4 col-12" data-src="<?= yii::getAlias('@web').$model['image'] ?>">
                            <img src=<?= yii::getAlias('@web').$model['thumb'] ?> />
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<!--</section>-->
