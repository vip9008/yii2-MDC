<?php

namespace vip9008\MDC\assets;

use yii\web\AssetBundle;

class SideSheetAsset extends AssetBundle
{
    public $sourcePath = '@vendor/vip9008/md-assets';
    public $css = [
        'css/mdc.sheets.side.css',
    ];
    public $js = [
        'js/mdc.sheets.side.js',
    ];
    public $depends = [
        'vip9008\MDC\assets\MaterialGrid',
    ];
}
