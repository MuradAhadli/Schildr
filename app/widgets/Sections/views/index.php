<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 3/17/2018
 * Time: 3:36 PM
 */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\HtmlPurifier;

?>

<?php if($models): ?>

    <div class="sections">
        <div class="row m-0 h-100">
            <?php foreach ($models as $model):

                if($model['module_class']) {
                    $url = Url::to(['/'.$model['slug']]);

                    if(yii::$app->controller->id == $url) {
                        $active = 'active';
                    }
                }
                else {
                    $url = Url::to(['site/page', 'page_slug' => $model['slug']]);
                }

                ?>
                <div class="col-12 col-md-3 section-col">

                    <a href="<?= $url ?>" class="item">
                        <div class="section-opacity"></div>
                        <div class="section-text">
                            <div class="name"><?= Html::encode($model['title']) ?></div>
                            <div class="short">
                               <?= HtmlPurifier::process($model['short']) ?>
                            </div>
                        </div>
                        <div class="img" style="background-image: url('<?= yii::getAlias('@web') . $model['image'] ?>')"></div>
                    </a>
                </div>

            <?php endforeach; ?>
        </div>
    </div>


<?php endif; ?>