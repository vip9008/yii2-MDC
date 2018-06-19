<?php

namespace vip9008\MDC\assets;

use yii\web\AssetBundle;

class MaterialGrid extends AssetBundle
{
    public $sourcePath = '@vip9008/MDC/web';
    public $css = [
        "css/md.grid.css",
        "css/md.colors.css",
        "css/mdc.divider.css",
    ];
    public $js = [
        "js/md.grid.js",
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
    ];
}
