<?php

namespace vip9008\MDC\widgets;

use Yii;
use yii\base\ErrorHandler;
use yii\helpers\ArrayHelper;
use vip9008\MDC\helpers\Html;
use yii\base\Model;
use yii\web\JsExpression;
use yii\widgets\ActiveField as BaseActiveField;

class ActiveField extends BaseActiveField
{
    public $options = [];
    public $role = ['name' => '', 'type' => ''];
    public $themeColor = '';
    public $template = "{input}\n{label}\n{hint}\n{error}";
    public $inputOptions = [];
    public $errorOptions = ['class' => 'help-block'];
    public $labelOptions = [];
    public $hintOptions = ['class' => 'hint-block'];

    public function begin()
    {
        if ($this->form->enableClientScript) {
            $clientOptions = $this->getClientOptions();
            if (!empty($clientOptions)) {
                $this->form->attributes[] = $clientOptions;
            }
        }

        $inputID = $this->getInputId();
        $attribute = Html::getAttributeName($this->attribute);
        $options = $this->options;

        Html::addCssClass($options, "field-$inputID");
        Html::addCssClass($options, $this->themeColor);

        if ($this->model->isAttributeRequired($attribute)) {
            $class[] = $this->form->requiredCssClass;
            Html::addCssClass($options, $this->form->requiredCssClass);
        }
        if ($this->model->hasErrors($attribute)) {
            Html::addCssClass($options, $this->form->errorCssClass);
        }

        $tag = ArrayHelper::remove($options, 'tag', 'div');

        return Html::beginTag($tag, $options);
    }

    public function label($label = null, $options = [])
    {
        if ($label === false) {
            $this->parts['{label}'] = '';
            return $this;
        }

        $options = array_merge($this->labelOptions, $options);
        Html::addCssClass($options, 'label');

        if ($label === null) {
            $label = $this->model->getAttributeLabel($this->attribute);
        }

        $this->parts['{label}'] = Html::tag('label', $label, $options);

        return $this;
    }

    public function textInput($options = [])
    {
        Html::addCssClass($this->options, 'mdc-text-field');
        Html::addCssClass($this->inputOptions, 'input');
        $options = array_merge($this->inputOptions, $options);
        $this->parts['{input}'] = Html::activeTextInput($this->model, $this->attribute, $options);

        return $this;
    }
    
    public function textarea($options = [])
    {
        Html::addCssClass($this->options, 'mdc-text-field');
        Html::addCssClass($this->inputOptions, 'input');
        $options = array_merge($this->inputOptions, $options);
        $this->parts['{input}'] = Html::activeTextarea($this->model, $this->attribute, $options);

        return $this;
    }

    public function hiddenInput($options = [])
    {
        $options = array_merge($this->inputOptions, $options);
        $this->parts['{input}'] = Html::activeHiddenInput($this->model, $this->attribute, $options);

        return $this;
    }

    public function passwordInput($options = [])
    {
        Html::addCssClass($this->options, 'mdc-text-field');
        Html::addCssClass($this->inputOptions, 'input');
        $options = array_merge($this->inputOptions, $options);
        $this->parts['{input}'] = Html::activePasswordInput($this->model, $this->attribute, $options);

        return $this;
    }

    public function radio($options = [], $enclosedByLabel = true)
    {
        if ($enclosedByLabel) {
            $this->parts['{input}'] = Html::activeRadio($this->model, $this->attribute, $options);
            $this->parts['{label}'] = '';
        } else {
            if (isset($options['label']) && !isset($this->parts['{label}'])) {
                $this->parts['{label}'] = $options['label'];
                if (!empty($options['labelOptions'])) {
                    $this->labelOptions = $options['labelOptions'];
                }
            }
            unset($options['labelOptions']);
            $options['label'] = null;
            $this->parts['{input}'] = Html::activeRadio($this->model, $this->attribute, $options);
        }

        return $this;
    }

    public function checkbox($options = [], $enclosedByLabel = true)
    {
        $this->template = "{input}";
        Html::addCssClass($this->options, 'checkbox-input');
        $options = array_merge($this->inputOptions, $options);
        $this->parts['{input}'] = Html::activeCheckbox($this->model, $this->attribute, $options);

        return $this;
    }

    public function dropDownList($items, $options = [])
    {
        Html::addCssClass($this->options, 'mdc-menu-container select-menu');
        Html::addCssClass($this->inputOptions, 'select-value');
        $options = array_merge($this->inputOptions, $options);
        $this->parts['{input}'] = Html::activeDropDownList($this->model, $this->attribute, $items, $options);
        
        return $this;
    }

    /**
     * Renders a list of checkboxes.
     * A checkbox list allows multiple selection, like [[listBox()]].
     * As a result, the corresponding submitted value is an array.
     * The selection of the checkbox list is taken from the value of the model attribute.
     * @param array $items the data item used to generate the checkboxes.
     * The array values are the labels, while the array keys are the corresponding checkbox values.
     * @param array $options options (name => config) for the checkbox list.
     * For the list of available options please refer to the `$options` parameter of [[\yii\helpers\Html::activeCheckboxList()]].
     * @return $this the field object itself.
     */
    public function checkboxList($items, $options = [])
    {
        $this->_skipLabelFor = true;
        $this->parts['{input}'] = Html::activeCheckboxList($this->model, $this->attribute, $items, $options);

        return $this;
    }

    /**
     * Renders a list of radio buttons.
     * A radio button list is like a checkbox list, except that it only allows single selection.
     * The selection of the radio buttons is taken from the value of the model attribute.
     * @param array $items the data item used to generate the radio buttons.
     * The array values are the labels, while the array keys are the corresponding radio values.
     * @param array $options options (name => config) for the radio button list.
     * For the list of available options please refer to the `$options` parameter of [[\yii\helpers\Html::activeRadioList()]].
     * @return $this the field object itself.
     */
    public function radioList($items, $options = [])
    {
        $this->_skipLabelFor = true;
        $this->parts['{input}'] = Html::activeRadioList($this->model, $this->attribute, $items, $options);

        return $this;
    }
}
