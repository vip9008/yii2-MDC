<?php

namespace vip9008\MDC\assets;

use yii\web\AssetBundle;

class TopAppBarAsset extends AssetBundle
{
    public $sourcePath = '@vip9008/MDC/web';
    public $css = [
        "css/mdc.top.app.bar.css",
    ];
    public $js = [
        "js/mdc.top.app.bar.js",
    ];
    public $depends = [
        'vip9008\MDC\assets\MaterialGrid',
    ];
}
