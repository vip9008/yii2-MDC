<?php

namespace vip9008\MDC\assets;

use yii\web\AssetBundle;

class FABAsset extends AssetBundle
{
    public $sourcePath = '@vendor/vip9008/md-assets';
    public $css = [
        "css/mdc.button.fab.css",
    ];
    public $js = [
        "js/mdc.button.fab.js",
    ];
    public $depends = [
        'vip9008\MDC\assets\MaterialGrid',
    ];
}
