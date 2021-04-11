<?php
$this->title = Yii::t('easyii', 'Edit product');
?>
<?= $this->render('_menu') ?>
<?= $this->render('_form', [
    'model' => $model,
    'parentCategories' => $parentCategories,
    'modelFiles' => $modelFiles,
    'product' => $product,
    'dataUploads' => $dataUploads,
    'newDataUploads' => $newDataUploads,
    'dataTypes' => $dataTypes,
]) ?>