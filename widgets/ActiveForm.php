<?php

namespace vip9008\MDC\widgets;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm as BaseActiveForm;

use vip9008\MDC\assets\MenuAsset;
use vip9008\MDC\assets\SelectionControlAsset;
use vip9008\MDC\assets\TextFieldAsset;

class ActiveForm extends BaseActiveForm
{
    public $options = [];
    public $themeColor = '';
    public $fieldClass = 'vip9008\MDC\widgets\ActiveField';

    public function init()
    {
        MenuAsset::register($this->getView());
        SelectionControlAsset::register($this->getView());
        TextFieldAsset::register($this->getView());
        
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
