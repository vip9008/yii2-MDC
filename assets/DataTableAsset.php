<?php

namespace vip9008\MDC\assets;

use yii\web\AssetBundle;

class DataTableAsset extends AssetBundle
{
    public $sourcePath = '@vip9008/md-assets';
    public $css = [
        "css/mdc.data.table.css",
    ];
    public $js = [
        "js/mdc.data.table.js",
    ];
    public $depends = [
        'vip9008\MDC\assets\MaterialGrid',
        'vip9008\MDC\assets\SelectionControlAsset',
        'vip9008\MDC\assets\ButtonAsset',
        'vip9008\MDC\assets\CardAsset',
    ];
}
