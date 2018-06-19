<?php

namespace vip9008\MDC\assets;

use yii\web\AssetBundle;

class List extends AssetBundle
{
    public $sourcePath = '@vip9008/MDC/web';
    public $css = [
        "css/mdc.list.css",
    ];
    public $js = [
        "js/mdc.list.js",
    ];
    public $depends = [
        'vip9008\MDC\assets\MaterialGrid',
    ];
}
