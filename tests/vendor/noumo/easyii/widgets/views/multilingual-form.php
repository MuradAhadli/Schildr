<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 2/13/2018
 * Time: 11:27 AM
 */

use dosamigos\tinymce\TinyMce;
use powerkernel\slugify\Slugify;

\yii\bootstrap\BootstrapPluginAsset::register($this);

$active = '';
?>

<div>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs nav-tabs-lang" role="tablist">

        <?php foreach (yii::$app->params['languages'] as $k => $v): ?>

            <?php if(yii::$app->language == $k) {

                $active = 'active';
            } ?>

                <li role="presentation" class="<?= $active ?>"><a href="#<?= $k.$model->primaryKey ?>" aria-controls="home" role="tab" data-toggle="tab"><?= $v ?></a></li>

        <?php $active = ''; endforeach; ?>

    </ul>

    <!-- Tab panes -->
    <div class="tab-content">

        <?php foreach (yii::$app->params['languages'] as $k => $v):

            $active = '';
            $suffix = '_'.$k;

            if(yii::$app->language == $k) {
                $active = 'active';
                $suffix = '';
            }
            ?>

            <div role="tabpanel" class="tab-pane <?=$active?>" id="<?= $k.$model->primaryKey ?>">

                <?php

                foreach ($fields as $field) {

                    if(is_array($field)) {

                        if(isset($field['editor'])) {

                            echo $form->field($model, $field[0].$suffix)
                                ->widget(TinyMce::className(), [
                                    'language' => yii::$app->language,
                                ])
                                ->label(ucfirst($field[0]), isset($field['options']) ? $field['options'] : []);
                        }

                        if(isset($field['text'])) {

                            echo $form->field($model, $field[0].$suffix)
                                ->textarea(['id' => $field[0].'_'.$k] + (isset($field['options']) ? $field['options'] : []))
                                ->label(ucfirst($field[0]));
                        }
                    }
                    else {

                        echo $form->field($model, $field.$suffix)
                            ->textInput(['id' => $field.'_'.$k])
                            ->label(ucfirst($field));
                    }
                }

                if(is_array($slug)) {

                    echo $form->field($model, 'slug'.$suffix)
                        ->widget(Slugify::className(), ['source'=>'#'.$slug['source'].'_'.$k])
                        ->label('Slug');
                }

                ?>

            </div>

        <?php endforeach; ?>
    </div>

</div>
