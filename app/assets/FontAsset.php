<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 5/23/2018
 * Time: 10:13 AM
 */

namespace app\assets;


use yii\web\AssetBundle;

class FontAsset extends AssetBundle
{
    public $sourcePath = '@app/media';

    public $css = [
        'css/font.css'
    ];

    public $depends = [
        'app\assets\AppAsset'
    ];
}