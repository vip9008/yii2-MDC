<?php

namespace vip9008\MDC\assets;

use yii\web\AssetBundle;

class ImageListAsset extends AssetBundle
{
    public $sourcePath = '@vendor/vip9008/md-assets';
    public $css = [
        "css/mdc.image.list.css",
    ];
    public $js = [
    ];
    public $depends = [
        'vip9008\MDC\assets\MaterialGrid',
    ];
}
