<?php

namespace vip9008\MDC\assets;

use yii\web\AssetBundle;

class TabsAsset extends AssetBundle
{
    public $sourcePath = '@vendor/vip9008/md-assets';
    public $css = [
        "css/mdc.tabs.css",
    ];
    public $js = [
        "js/mdc.tabs.js",
    ];
    public $depends = [
        'vip9008\MDC\assets\MaterialGrid',
    ];
}
