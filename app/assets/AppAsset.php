<?php
namespace app\assets;

use yii\helpers\FileHelper;
use yii;

class AppAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@app/media';

    public $js = [
        'js/jquery-3.3.1.min.js',
        'js/bootstrap.min.js',
        'js/all.min.js',
        'js/lightgallery-all.min.js',
        'js/jquery.waypoints.min.js',
        'js/jquery.countup.min.js',
        'js/slick.js',
        'js/slick-lightbox.js',
        'js/main.js',
    ];


    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function init(){
        parent::init();

        $this->css = [
            'css/bootstrap.min.css',
            'css/font-awesome.min.css',
            'css/lightgallery.css',
            'css/slick.css',
            'css/slick-theme.css',
            'css/slick-lightbox.css',
            'css/fonts.css',
            'css/all.min.css',
            'css/style.css',
            'css/media.css',
        ];

    }
}
