<?php
use yii\easyii\helpers\Image;
use yii\easyii\models\Photo;
use yii\easyii\widgets\Fancybox;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\easyii\assets\PhotosAsset;

PhotosAsset::register($this);
Fancybox::widget(['selector' => '.plugin-box']);

$class = get_class($this->context->model);
$item_id = $this->context->model->primaryKey;
$lang = yii::$app->language;

$linkParams = [
    'class' => $class,
    'item_id' => $item_id,
];

?>

<div>
    <div>
        <label><?= yii::t('db','Video') ?></label>
        <input class="video-upload-input form-control" name="add_photo" placeholder="<?= yii::t('db', 'Add youtube id') ?>">
        <input type='hidden' id="video_action" value="<?= '/' . $lang . '/admin/photos/upload-video?class=' . $class . '&item_id=' . $item_id?>">
    </div>
    <button id="video-upload" class="btn btn-success text-uppercase"><span class="glyphicon glyphicon-arrow-up"></span> <?= Yii::t('db', 'Add Video')?></button>
</div>


<button id="photo-upload" class="btn btn-success text-uppercase"><span class="glyphicon glyphicon-arrow-up"></span> <?= Yii::t('db', 'Upload')?></button>
<small id="uploading-text" class="smooth"><?= Yii::t('db', 'Uploading. Please wait')?><span></span></small>

<table id="photo-table" class="table table-hover" style="display: <?= count($photos) ? 'table' : 'none' ?>;">
    <thead>
    <tr>
        <?php if(IS_ROOT) : ?>
        <th width="50">#</th>
        <?php endif; ?>
        <th width="150"><?= Yii::t('easyii', 'Image') ?></th>
        <th><?= Yii::t('easyii', 'Description') ?></th>
        <th width="150"></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($photos as $photo) : ?>

        <tr data-id="<?=$photo->primaryKey?>">
            <?= (IS_ROOT ? '<td>'.$photo->primaryKey.'</td>' : '') ?>
            <td>

                <?php if($photo->type == 0): ?>
                    <a href="<?=$photo->image?>" class="plugin-box" title="<?=$photo->title?>" rel="easyii-photos">
                        <img class="photo-thumb" id="photo-<?=$photo->primaryKey?>" src="<?= yii::getAlias('@web') . $photo->thumb ?>">
                    </a>
                <?php else: ?>
                    <iframe width="134" height="105" src="https://www.youtube.com/embed/<?= $photo->youtube_id ?>"></iframe>
                <?php endif; ?>

            </td>
            <td>
                <?php $form = \yii\widgets\ActiveForm::begin([
                    'id' => 'photos_langs_form_'.$photo->primaryKey
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
                        href="<?= Url::to(['/admin/photos/description/'.$photo->primaryKey .'']) ?>"
                        class="btn btn-sm btn-primary disabled save-photo-description"
                        id="save_<?= $photo->primaryKey ?>">
                    <?= Yii::t('easyii', 'Save') ?>
                </a>
            </td>
            <td class="control vtop">
                <div class="btn-group btn-group-sm" role="group">
                    <a href="<?= Url::to(['/admin/photos/up/'.$photo->primaryKey.''] + $linkParams) ?>" class="btn btn-default move-up" title="<?= Yii::t('easyii', 'Move up') ?>"><span class="glyphicon glyphicon-arrow-up"></span></a>
                    <a href="<?= Url::to(['/admin/photos/down/'.$photo->primaryKey.''] + $linkParams) ?>" class="btn btn-default move-down" title="<?= Yii::t('easyii', 'Move down') ?>"><span class="glyphicon glyphicon-arrow-down"></span></a>
                    <a href="<?= Url::to(['/admin/photos/image/'.$photo->primaryKey.''] + $linkParams) ?>" class="btn btn-default change-image-button" title="<?= Yii::t('easyii', 'Change image') ?>"><span class="glyphicon glyphicon-floppy-disk"></span></a>
                    <a href="<?= Url::to(['/admin/photos/delete/'.$photo->primaryKey.'']) ?>" class="btn btn-default color-red delete-photo" title="<?= Yii::t('easyii', 'Delete item') ?>"><span class="glyphicon glyphicon-remove"></span></a>

                    <input type="file" name="Cover[image]" class="change-image-input hidden">
                </div>
            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
</table>
<p class="empty" style="display: <?= count($photos) ? 'none' : 'block' ?>;"><?= Yii::t('easyii', 'No photos uploaded yet') ?>.</p>

<?= Html::beginForm(Url::to(['/admin/photos/upload'] + $linkParams), 'post', ['enctype' => 'multipart/form-data']) ?>
<?= Html::fileInput('', null, [
    'id' => 'photo-file',
    'class' => 'hidden',
    'multiple' => 'multiple',
])
?>
<?php Html::endForm() ?>