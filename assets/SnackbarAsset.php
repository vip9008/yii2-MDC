<?php

namespace vip9008\MDC\assets;

use yii\web\AssetBundle;

class SnackbarAsset extends AssetBundle
{
    public $sourcePath = '@vendor/vip9008/md-assets';
    public $css = [
        "css/mdc.snackbar.css",
    ];
    public $js = [
        "js/mdc.snackbar.js",
    ];
    public $depends = [
        'vip9008\MDC\assets\MaterialGrid',
        'vip9008\MDC\assets\ButtonAsset',
    ];
}
