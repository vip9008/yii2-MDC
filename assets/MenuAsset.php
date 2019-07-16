<?php

namespace vip9008\MDC\assets;

use yii\web\AssetBundle;

class MenuAsset extends AssetBundle
{
    public $sourcePath = '@vendor/vip9008/md-assets';
    public $css = [
        "css/mdc.menu.css",
    ];
    public $js = [
        "js/mdc.menu.js",
    ];
    public $depends = [
        'vip9008\MDC\assets\MaterialGrid',
        'vip9008\MDC\assets\ListAsset',
        'vip9008\MDC\assets\TextFieldAsset',
    ];
}
