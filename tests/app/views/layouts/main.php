<?php
use yii\helpers\Html;
use app\models\Address;

$asset = \app\assets\AppAsset::register($this);

$isHome = yii::$app->session->get('isHome');

if ($isHome){
    $this->title = 'Main'. " » " . Html::encode($this->title) ;
}
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <link rel="icon" href="<?= \yii\helpers\Url::base() ?>/favicon.png" type="image/x-icon">
        <?php $this->head() ?>
    </head>
    <body class="<?= $isHome ? 'home' : 'page' ?>">
    <?php $this->beginBody() ?>

    <?= $this->render('header') ?>

    <main id="<?= $isHome ? 'fullpage' : '' ?>">

        <?php
            if(!$isHome) {
                echo '<div class="content">';
            }

            echo $content;

            if(!$isHome) {
                echo '</div>';
            }

        ?>

        <?= $this->render('footer', [
                'isHome' => $isHome
        ]) ?>

    </main>

    <script>
        var app_lang = '<?= yii::$app->language ?>';

        var branches = [];

        <?php
                $i = 0;
        $address = Address::getAllAddress();
        foreach ($address as $key => $val) : ?>
            branches.push([<?=$i?>, '<?=$val['title']?>', <?=$val['coor_x']?>, <?=$val['coor_y']?>, 'object_2', 'map.svg', <?=$val['id']?>])
        <?php $i++; endforeach; ?>

        var web_url = '<?= yii::getAlias('@web') ?>';

        var domain = '<?= \yii\helpers\Url::to(['/']) ?>';
    </script>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>