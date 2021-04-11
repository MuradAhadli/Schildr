<?php
$this->title = Yii::t('easyii', 'Create product category');
?>

<?= $this->render('_menu') ?>
<?= $this->render('_form', [
    'model' => $model,
    'parents' => $parents,
]) ?>