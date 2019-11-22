<?php

namespace vip9008\MDC\assets;

use yii\web\AssetBundle;

class SliderAsset extends AssetBundle
{
    public $sourcePath = '@vendor/vip9008/md-assets';
    public $css = [
        "css/mdc.slider.css",
    ];
    public $js = [
        "js/mdc.slider.js",
    ];
    public $depends = [
        'vip9008\MDC\assets\MaterialGrid',
    ];
}
