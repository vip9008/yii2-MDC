<?php

namespace vip9008\MDC\assets;

use yii\web\AssetBundle;

class ListAsset extends AssetBundle
{
    public $sourcePath = '@vendor/vip9008/md-assets';
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
