<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 4/27/2018
 * Time: 11:44 AM
 */

namespace app\assets;


use yii\web\AssetBundle;

class ContactAsset extends AssetBundle
{
    public $sourcePath = '@app/media';

    public $js = [
        'https://maps.googleapis.com/maps/api/js?key=AIzaSyBJfqfHrzYLErFI3x8ld_OabKP8K9l0gIs',
        'js/showrooms.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}