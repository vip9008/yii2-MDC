<?php

namespace vip9008\MDC\assets;

use yii\web\AssetBundle;

class Button extends AssetBundle
{
    public $sourcePath = '@vip9008/MDC/web';
    public $css = [
        "css/mdc.button.css",
    ];
    public $js = [
        "js/mdc.button.js",
    ];
    public $depends = [
        'vip9008\MDC\assets\MaterialGrid',
    ];
}
