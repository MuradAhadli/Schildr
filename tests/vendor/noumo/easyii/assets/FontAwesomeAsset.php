<?php
namespace yii\easyii\assets;

class FontAwesomeAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@easyii/media';
    public $css = [
        'css/font-awesome.css'
    ];
    public $depends = [
//        'yii\web\JqueryAsset',
//        'yii\bootstrap\BootstrapAsset',
//        'yii\easyii\assets\SwitcherAsset',
    ];
    public $jsOptions = array(
        'position' => \yii\web\View::POS_HEAD
    );
}
