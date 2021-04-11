<?php
use yii\easyii\helpers\Image;
use yii\easyii\models\Photo;
use yii\easyii\widgets\Fancybox;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\easyii\assets\CoversAsset;

CoversAsset::register($this);
Fancybox::widget(['selector' => '.plugin-box']);
\yii\bootstrap\BootstrapPluginAsset::register($this);

$class = get_class($this->context->model);
$item_id = $this->context->model->primaryKey;

$linkParams = [
    'class' => $class,
    'item_id' => $item_id,
];

?>
<button id="photo-upload" class="btn btn-success text-uppercase"><span class="glyphicon glyphicon-arrow-up"></span> <?= Yii::t('easyii', 'Upload')?></button>
<small id="uploading-text" class="smooth"><?= Yii::t('easyii', 'Uploading. Please wait')?><span></span></small>

<table id="photo-table" class="table table-hover" style="display: <?= count($covers) ? 'table' : 'none' ?>;">
    <thead>
    <tr>
        <?php if(IS_ROOT) : ?>
        <th width="50">#</th>
        <?php endif; ?>
        <th width="150"><?= Yii::t('db', 'Image') ?></th>
        <th><?= Yii::t('db', 'Description') ?></th>
        <th width="150"></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($covers as $photo) : ?>
        <tr data-id="<?=$photo->primaryKey?>">
            <?= (IS_ROOT ? '<td>'.$photo->primaryKey.'</td>' : '') ?>
            <td>
                <a href="<?=$photo->image?>" class="plugin-box" title="<?=$photo->title?>" rel="easyii-covers">
                    <img class="photo-thumb" id="photo-<?=$photo->primaryKey?>" src="<?= yii::getAlias('@web') . $photo->image?>">
                </a>
            </td>
            <td>
                <?php $form = \yii\widgets\ActiveForm::begin([
                        'id' => 'cover_langs_form_'.$photo->primaryKey
                ]); ?>

                <?= \yii\easyii\widgets\MultilingualForm::widget([
                    'model' => $photo,
                    'form' => $form,
                    'fields' => [
                            ['title', 'text' => true, 'options' => ['class' => 'form-control photo-description', 'data-id' => $photo->primaryKey]]
                    ]
                ]) ?>

                <?php \yii\widgets\ActiveForm::end(); ?>

                <a
                        href="<?= Url::to(['/admin/covers/description/'.$photo->primaryKey .'']) ?>"
                        class="btn btn-sm btn-primary disabled save-photo-description"
                        id="save_<?= $photo->primaryKey ?>">
                    <?= Yii::t('easyii', 'Save') ?>
                </a>
            </td>
            <td class="control vtop">
                <div class="btn-group btn-group-sm" role="group">
                    <a href="<?= Url::to(['/admin/covers/up/'.$photo->primaryKey.''] + $linkParams) ?>" class="btn btn-default move-up" title="<?= Yii::t('easyii', 'Move up') ?>"><span class="glyphicon glyphicon-arrow-up"></span></a>
                    <a href="<?= Url::to(['/admin/covers/down/'.$photo->primaryKey.''] + $linkParams) ?>" class="btn btn-default move-down" title="<?= Yii::t('easyii', 'Move down') ?>"><span class="glyphicon glyphicon-arrow-down"></span></a>
                    <a href="<?= Url::to(['/admin/covers/image/'.$photo->primaryKey.''] + $linkParams) ?>" class="btn btn-default change-image-button" title="<?= Yii::t('easyii', 'Change image') ?>"><span class="glyphicon glyphicon-floppy-disk"></span></a>
                    <a href="<?= Url::to(['/admin/covers/delete/'.$photo->primaryKey.'']) ?>" class="btn btn-default color-red delete-photo" title="<?= Yii::t('easyii', 'Delete item') ?>"><span class="glyphicon glyphicon-remove"></span></a>

                    <input type="file" name="Cover[image]" class="change-image-input hidden">
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<p class="empty" style="display: <?= count($covers) ? 'none' : 'block' ?>;"><?= Yii::t('easyii', 'No covers uploaded yet') ?>.</p>

<?= Html::beginForm(Url::to(['/admin/covers/upload'] + $linkParams), 'post', ['enctype' => 'multipart/form-data']) ?>
<?= Html::fileInput('', null, [
    'id' => 'photo-file',
    'class' => 'hidden',
    'multiple' => 'multiple',
])
?>
<?php Html::endForm() ?>