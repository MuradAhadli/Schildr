<?php
/**
 * Created by PhpStorm.
 * User: idealand
 * Date: 7/9/18
 * Time: 21:49
 */

use yii\helpers\Html;

$asset = \app\assets\StaticAsset::register($this);

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
<body>
<?php $this->beginBody() ?>

<?=$content?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
