<?php

namespace vip9008\MDC\widgets;

use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm as BaseActiveForm;

class ActiveForm extends BaseActiveForm
{
    public $options = [];
    public $themeColor = '';
    public $fieldClass = 'vip9008\MDC\widgets\ActiveField';

    public function init()
    {
        $this->themeColor = ArrayHelper::remove($this->options, 'themeColor', $this->themeColor);

        parent::init();
    }

    public function field($model, $attribute, $options = [])
    {
        if (!isset($options['themeColor'])) {
            $options['themeColor'] = $this->themeColor;
        }
        
        return parent::field($model, $attribute, $options);
    }
}
