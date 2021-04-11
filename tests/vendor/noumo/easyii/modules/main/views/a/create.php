<?php
$this->title = Yii::t('easyii', 'Create Main');
?>
<?= $this->render('_menu') ?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>