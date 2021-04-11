<?php
$this->title = Yii::t('easyii', 'Edit product category');
?>
<?= $this->render('_menu') ?>
<?= $this->render('_form', [
    'model' => $model,
    'parents' => $parents,
]) ?>