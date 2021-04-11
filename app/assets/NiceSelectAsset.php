<?php
namespace app\assets;

class NiceSelectAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@app/media';
    public $css = [
        'css/nice-select.css',
    ];
    public $js = [
        'js/jquery.nice-select.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}
