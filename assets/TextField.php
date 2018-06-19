<?php

namespace vip9008\MDC\assets;

use yii\web\AssetBundle;

class TextField extends AssetBundle
{
    public $sourcePath = '@vip9008/MDC/web';
    public $css = [
        "css/mdc.text.field.css",
    ];
    public $js = [
        "js/mdc.text.field.js",
    ];
    public $depends = [
        'vip9008\MDC\assets\MaterialGrid',
    ];
}
