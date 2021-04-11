<?php
use yii\easyii\widgets\Covers;

$this->title = $model->name;
?>

<?= $this->render('_menu') ?>
<?= $this->render('_submenu', ['model' => $model]) ?>

<?= Covers::widget(['model' => $model])?>