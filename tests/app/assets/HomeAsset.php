<?php
namespace app\assets;

class HomeAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@vendor/bower';
    public $css = [
    ];
    public $js = [
    ];
    public $jsOptions = [
        'async' => 'async'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
