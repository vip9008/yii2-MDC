<?php

namespace vip9008\MDC\assets;

use yii\web\AssetBundle;

class NavDrawer extends AssetBundle
{
    public $sourcePath = '@vip9008/MDC/web';
    public $css = [
        "css/mdc.nav.drawer.css",
    ];
    public $js = [
        "js/mdc.nav.drawer.js",
    ];
    public $depends = [
        'vip9008\MDC\assets\MaterialGrid',
        'vip9008\MDC\assets\List',
    ];
}
