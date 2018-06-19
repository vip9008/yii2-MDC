<?php

namespace vip9008\MDC\assets;

use yii\web\AssetBundle;

class ProgressIndicator extends AssetBundle
{
    public $sourcePath = '@vip9008/MDC/web';
    public $css = [
        "css/mdc.progress.indicator.css",
    ];
    public $js = [
        "js/mdc.progress.indicator.js",
    ];
    public $depends = [
        'vip9008\MDC\assets\MaterialGrid',
    ];
}
