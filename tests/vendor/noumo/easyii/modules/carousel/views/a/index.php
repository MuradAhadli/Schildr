<?php

use yii\easyii\modules\carousel\models\Carousel;
use yii\easyii\modules\page\models\Page;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\easyii\modules\productcategory\models\ProductCategory;

$this->title = Yii::t('easyii', 'Carousel');

$module = $this->context->module->id;
?>

<?= $this->render('_menu') ?>

<?php if ($data->count > 0) : ?>


    <table class="table table-hover">
        <thead>
        <tr>
            <?php if (IS_ROOT) : ?>
                <th width="50">#</th>
            <?php endif; ?>
            <th><?= Yii::t('easyii', 'Title') ?></th>
            <th><?= Yii::t('easyii', 'Parent') ?></th>
            <th width="100"><?= Yii::t('easyii', 'Status') ?></th>
            <th width="120"></th>
        </tr>
        </thead>
        <tbody>
        <?php

        $pageTitlesArr = Page::find()->asArray()->localized(Yii::$app->language)->all();
        foreach ($pageTitlesArr as $pageTitleIem) {
            $pagesArr[$pageTitleIem['id']] = $pageTitleIem['translation']['title'];
        }

        $catTitlesArr = ProductCategory::find()->asArray()->localized(Yii::$app->language)->all();
        foreach ($catTitlesArr as $catTitleItem) {
            $catsArr[$catTitleItem['id']] = $catTitleItem['translation']['title'];
        }

        //VarDumper::dump($catsArr,6,1); die();

        $i = 0;
        foreach ($data->models as $item) : $url = Url::to(['/admin/' . $module . '/a/edit', 'id' => $item->primaryKey]);?>
            <tr data-id="<?= $item->primaryKey ?>">
                <?php if (IS_ROOT) : ?>
                    <td><a href="<?= $url ?>"><?= $item->primaryKey ?></a></td>
                <?php endif; ?>
                <?php
                $page_id = $item->page_id;
                $page = Page::getPageById($page_id);
                $categoryType = '';

                if($item->category_id > 0){
                    $categoryName = ProductCategory::getProductCategory(null, $item->category_id);
                }

                if($item->page_id > 0){
                    $categoryType = '(Page)';
                }elseif($categoryName[0]['parent_id'] == 0){
                    $categoryType = '(Category)';
                }else {
                    $categoryType = '(Sub Category)';
                }
                ?>
                <td>
                    <a href="<?= $url ?>">
                        <?= $item->translation['title'] ?>
                    </a>
                </td>
                <td>
                    <a href="<?= $url ?>">
<!--                        --><?php // VarDumper::dump($item->page_id,10,1);?>
                        <?php if(isset($item->page_id)):?>
                            <?=$pagesArr[$item->page_id]?> - <?=$categoryType?>
                        <?php else :?>
                            <?=$catsArr[$item->category_id]?> - <?=$categoryType?>
                        <?php endif;?>
                    </a>
                </td>
                <td class="status vtop">
                    <?= Html::checkbox('', $item->status == Carousel::STATUS_ON, [
                        'class' => 'switch',
                        'data-id' => $item->primaryKey,
                        'data-link' => Url::to(['/admin/' . $module . '/a/']),
                    ]) ?>
                </td>
                <td>
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="<?= Url::to(['/admin/' . $module . '/a/up', 'id' => $item->primaryKey]) ?>"
                           class="btn btn-default move-up" title="<?= Yii::t('easyii', 'Move up') ?>"><span
                                    class="glyphicon glyphicon-arrow-up"></span></a>
                        <a href="<?= Url::to(['/admin/' . $module . '/a/down', 'id' => $item->primaryKey]) ?>"
                           class="btn btn-default move-down" title="<?= Yii::t('easyii', 'Move down') ?>"><span
                                    class="glyphicon glyphicon-arrow-down"></span></a>
                        <a href="<?= Url::to(['/admin/' . $module . '/a/delete', 'id' => $item->primaryKey]) ?>"
                           class="btn btn-default confirm-delete" title="<?= Yii::t('easyii', 'Delete item') ?>"><span
                                    class="glyphicon glyphicon-remove"></span></a>
                    </div>
                </td>
            </tr>
        <?php $i++; endforeach;?>



        </tbody>
    </table>
    <?= yii\widgets\LinkPager::widget([
        'pagination' => $data->pagination,

    ]) ?>
<?php else : ?>
    <p><?= Yii::t('easyii', 'No records found') ?></p>
<?php endif; ?>