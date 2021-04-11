<?php
$this->title = Yii::t('easyii', 'Create ProjectCategory');
?>
<?= $this->render('_menu') ?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>