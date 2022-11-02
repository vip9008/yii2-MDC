<?php

namespace vip9008\MDC\widgets;

use yii\helpers\Json;
use vip9008\MDC\helpers\Html;
use vip9008\MDC\assets\MenuAsset;
use vip9008\MDC\assets\SelectionControlAsset;
use vip9008\MDC\assets\TextFieldAsset;

class ActiveForm extends \yii\widgets\ActiveForm
{
    public $options = [];
    public $themeColor = '';
    public $fieldClass = 'vip9008\MDC\widgets\ActiveField';

    public function init()
    {
        MenuAsset::register($this->getView());
        SelectionControlAsset::register($this->getView());
        TextFieldAsset::register($this->getView());
        
        Html::addCssClass($this->options, 'mdc-form');
        $this->themeColor = empty($this->themeColor) ? 'indigo' : $this->themeColor;

        parent::init();
    }

    public function field($model, $attribute, $options = [])
    {
        if (!isset($options['themeColor'])) {
            $options['themeColor'] = $this->themeColor;
        }
        
        return parent::field($model, $attribute, $options);
    }

    public function getClientScript()
    {
        $id = $this->options['id'];
        $options = Json::htmlEncode($this->getClientOptions());
        $attributes = Json::htmlEncode($this->attributes);
        return "jQuery('#$id').yiiActiveForm($attributes, $options);";
    }
}
