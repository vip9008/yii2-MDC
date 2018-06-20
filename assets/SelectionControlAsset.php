<?php

namespace vip9008\MDC\assets;

use yii\web\AssetBundle;

class SelectionControlAsset extends AssetBundle
{
    public $sourcePath = '@vip9008/MDC/web';
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
