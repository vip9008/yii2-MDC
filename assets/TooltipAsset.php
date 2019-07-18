<?php

namespace vip9008\MDC\assets;

use yii\web\AssetBundle;

class TooltipAsset extends AssetBundle
{
    public $sourcePath = '@vendor/vip9008/md-assets';
    public $css = [
        "css/mdc.tooltip.css",
    ];
    public $js = [
        "js/mdc.tooltip.js",
    ];
    public $depends = [
        'vip9008\MDC\assets\MaterialGrid',
    ];
}
