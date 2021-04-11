<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 5/5/2018
 * Time: 10:50 AM
 */

use yii\easyii\modules\gallerycategory\models\GalleryCategory;
use yii\helpers\Url;
use yii\helpers\Html;

?>

<div class="filter">
    <ul class="list-unstyled list-inline text-center m-0">

        <?php foreach (GalleryCategory::getCategories() as $k => $v): ?>

            <li class="list-inline-item <?= ($v['id'] == $cat_id) ? 'active': '' ?>">
                <a href="<?=
                Url::to([
                    '/media/'.$action.'',
                    'page_slug' => ($action == 'photo' ? 'foto' : 'video'),
                    'cat_id' => $v['id'],
                    'cat_slug' => $v['slug']
                ]) ?>">

                    <?= Html::encode($v['name']) ?>
                </a>
            </li>

        <?php endforeach; ?>

    </ul>
</div>
