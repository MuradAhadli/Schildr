<?php
$this->title = Yii::t('easyii', 'Create PageBlock');
?>
<?= $this->render('_menu') ?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>