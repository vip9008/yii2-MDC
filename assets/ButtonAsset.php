<?php

namespace vip9008\MDC\assets;

use yii\web\AssetBundle;

class ButtonAsset extends AssetBundle
{
    public $sourcePath = '@vendor/vip9008/md-assets';
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
