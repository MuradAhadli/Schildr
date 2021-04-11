<?php
use yii\easyii\widgets\Photos;

$this->title = $model->title;
//\yii\helpers\VarDumper::dump($model,10,1); die();
?>

<?= $this->render('_menu') ?>
<?= $this->render('_submenu', ['model' => $model]) ?>

<?= Photos::widget(['model' => $model])?>