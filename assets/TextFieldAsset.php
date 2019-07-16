<?php

namespace vip9008\MDC\assets;

use yii\web\AssetBundle;

class TextFieldAsset extends AssetBundle
{
    public $sourcePath = '@vendor/vip9008/md-assets';
    public $css = [
        "css/mdc.text.field.css",
    ];
    public $js = [
        "js/mdc.text.field.js",
    ];
    public $depends = [
        'vip9008\MDC\assets\MaterialGrid',
    ];
}
