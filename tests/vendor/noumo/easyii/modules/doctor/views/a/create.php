<?php
$this->title = Yii::t('easyii', 'Create Doctor');
?>
<?= $this->render('_menu') ?>
<?= $this->render('_form', [
    'model' => $model,
    'user' => $user
]) ?>