<?php

namespace vip9008\MDC\assets;

use yii\web\AssetBundle;

class SelectionControlAsset extends AssetBundle
{
    public $sourcePath = '@vendor/vip9008/md-assets';
    public $css = [
        "css/mdc.selection.control.css",
    ];
    public $js = [
        "js/mdc.selection.control.js",
    ];
    public $depends = [
        'vip9008\MDC\assets\MaterialGrid',
        'vip9008\MDC\assets\ListAsset',
    ];
}
