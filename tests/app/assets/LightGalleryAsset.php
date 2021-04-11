<?php
namespace app\assets;

class LightGalleryAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@app/media';
    public $css = [
        'css/lightgallery.min.css'
    ];
    public $js = [
        'js/lightgallery-all.min.js'
    ];
    public $jsOptions = [
        'async' => 'async'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}