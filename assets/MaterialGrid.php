<?php

namespace vip9008\MDC\assets;

use yii\web\AssetBundle;

class MaterialGrid extends AssetBundle
{
    public $sourcePath = '@vendor/vip9008/md-assets';
    public $css = [
        // required fonts
        "https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i,700,700i",
        "https://fonts.googleapis.com/icon?family=Material+Icons",
        // required css files
        "css/md.grid.css",
        "css/md.colors.css",
        "css/mdc.nanoscroller.css",
        "css/mdc.overlay.scrollbars.css",
        "css/mdc.divider.css",
    ];
    public $js = [
        // required js files
        "js/jquery.nanoscroller.custom.js",
        "js/jquery.overlay.scrollbars.min.js",
        "js/md.grid.js",
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
    ];
}
