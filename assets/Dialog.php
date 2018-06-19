<?php

namespace vip9008\MDC\assets;

use yii\web\AssetBundle;

class Dialog extends AssetBundle
{
    public $sourcePath = '@vip9008/MDC/web';
    public $css = [
        "css/mdc.dialog.css",
    ];
    public $js = [
        "js/mdc.dialog.js",
    ];
    public $depends = [
        'vip9008\MDC\assets\MaterialGrid',
        'vip9008\MDC\assets\Button',
    ];
}
