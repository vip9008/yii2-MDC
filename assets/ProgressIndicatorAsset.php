<?php

namespace vip9008\MDC\assets;

use yii\web\AssetBundle;

class ProgressIndicatorAsset extends AssetBundle
{
    public $sourcePath = '@vip9008/md-assets';
    public $css = [
        "css/mdc.progress.indicator.css",
    ];
    public $js = [
    ];
    public $depends = [
        'vip9008\MDC\assets\MaterialGrid',
    ];
}
