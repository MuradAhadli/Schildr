<?php
$this->title = Yii::t('easyii', 'Create product');
?>

<?= $this->render('_menu') ?>
<?= $this->render('_form', [
    'model' => $model,
    'parentCategories' => $parentCategories,
]) ?>