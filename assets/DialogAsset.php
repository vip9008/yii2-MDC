<?php

namespace vip9008\MDC\assets;

use yii\web\AssetBundle;

class DialogAsset extends AssetBundle
{
    public $sourcePath = '@vendor/vip9008/md-assets';
    public $css = [
        "css/mdc.dialog.css",
    ];
    public $js = [
        "js/mdc.dialog.js",
    ];
    public $depends = [
        'vip9008\MDC\assets\MaterialGrid',
        'vip9008\MDC\assets\ButtonAsset',
    ];
}
