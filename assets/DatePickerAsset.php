<?php

namespace vip9008\MDC\assets;

use yii\web\AssetBundle;

class DatePickerAsset extends AssetBundle
{
    public $sourcePath = '@vendor/vip9008/md-assets';
    public $css = [
        "css/mdc.date.picker.css",
    ];
    public $js = [
        "js/mdc.date.picker.js",
    ];
    public $depends = [
        'vip9008\MDC\assets\MaterialGrid',
        'vip9008\MDC\assets\TextFieldAsset',
    ];
}
