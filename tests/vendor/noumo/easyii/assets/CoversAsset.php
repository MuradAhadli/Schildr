<?php
namespace yii\easyii\assets;

class CoversAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@easyii/assets/photos';
    public $css = [
        'photos.css',
    ];
    public $js = [
        'covers.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
