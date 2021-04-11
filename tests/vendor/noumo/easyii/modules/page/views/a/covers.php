<?php
use yii\easyii\widgets\Covers;

$this->title = $model->title;
?>

<?= $this->render('_menu') ?>
<?= $this->render('_submenu', ['model' => $model]) ?>

<?= Covers::widget(['model' => $model])?>