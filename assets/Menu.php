<?php

namespace vip9008\MDC\assets;

use yii\web\AssetBundle;

class Menu extends AssetBundle
{
    public $sourcePath = '@vip9008/MDC/web';
    public $css = [
        "css/mdc.menu.css",
    ];
    public $js = [
        "js/mdc.menu.js",
    ];
    public $depends = [
        'vip9008\MDC\assets\MaterialGrid',
        'vip9008\MDC\assets\List',
        'vip9008\MDC\assets\TextField',
    ];
}
