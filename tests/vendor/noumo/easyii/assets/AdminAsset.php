<?php
namespace yii\easyii\assets;

class AdminAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@easyii/media';
    public $css = [
        'css/admin.css',
        'css/fileinput.css',
        'css/fileinput-rtl.css',
    ];
    public $js = [
        'js/piexif.js',
        'js/purify.js',
        'js/sortable.js',
        'js/fileinput.js',
        'js/admin.js',
        'js/fontawesome-all.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\easyii\assets\SwitcherAsset',
    ];
    public $jsOptions = array(
        'position' => \yii\web\View::POS_END
    );
}
