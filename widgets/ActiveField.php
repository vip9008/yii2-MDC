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
        $this->themeColor = ArrayHelper::remove($options, 'themeColor', $this->themeColor);

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

    private function textInputIcon($options = false)
    {
        if ($options === false) {
            return '';
        } else {
            if (is_array($options)) {
                $tag = strtolower(ArrayHelper::remove($options, 'tag', 'div'));
                Html::addCssClass($options, 'icon');

                if (!in_array($tag, ['div', 'a', 'button'])) {
                    $tag = 'div';
                }

                $label = ArrayHelper::remove($options, 'label', '');

                if ($tag == 'a') {
                    $url = ArrayHelper::remove($options, 'href', ArrayHelper::remove($options, 'url', '#'));
                    return  Html::a($label, $url, $options);
                } else {
                    return Html::tag($tag, $label, $options);
                }
            } else {
                return Html::tag('div', $options, ['class' => 'icon']);
            }
        }
    }

    public function textInput($options = [])
    {
        Html::addCssClass($this->options, ['mdc-text-field', $this->themeColor]);
        Html::addCssClass($this->inputOptions, 'input-element');

        $icon = $this->textInputIcon(ArrayHelper::remove($options, 'icon', false));
        $options = array_merge($this->inputOptions, $options);
        $this->parts['{input}'] = $icon . Html::tag('div', Html::activeTextInput($this->model, $this->attribute, $options), ['class' => 'input']);

        return $this;
    }
    
    public function textarea($options = [])
    {
        Html::addCssClass($this->options, ['mdc-text-area', $this->themeColor]);
        Html::addCssClass($this->inputOptions, 'input-element');
        $options = array_merge($this->inputOptions, $options);
        $this->parts['{input}'] = Html::tag('div', Html::activeTextarea($this->model, $this->attribute, $options), ['class' => 'input']);

        return $this;
    }

    public function hiddenInput($options = [])
    {
        $this->template = "{input}\n{hint}\n{error}";
        $options = array_merge($this->inputOptions, $options);
        $this->parts['{input}'] = Html::activeHiddenInput($this->model, $this->attribute, $options);

        return $this;
    }

    public function passwordInput($options = [])
    {
        Html::addCssClass($this->options, ['mdc-text-field', $this->themeColor]);
        Html::addCssClass($this->inputOptions, 'input-element');

        $icon = $this->textInputIcon(ArrayHelper::remove($options, 'icon', false));
        $options = array_merge($this->inputOptions, $options);
        $this->parts['{input}'] = $icon . Html::tag('div', Html::activePasswordInput($this->model, $this->attribute, $options), ['class' => 'input']);

        return $this;
    }

    public function radio($options = [], $enclosedByLabel = true)
    {
        $this->template = "\n{input}\n";
        $description = ArrayHelper::remove($options, 'description', '');

        if ($enclosedByLabel) {
            $label = "\n{label}\n";
            if (!empty($description)) {
                $label .= Html::tag('div', $description, ['class' => 'secondary']) . "\n";
                Html::addCssClass($this->options, ['md-3line']);
            }
            $this->template = "\n{input}\n" . Html::tag('div', $label, ['class' => 'text']) . "\n";
        }

        Html::addCssClass($this->options, ['mdc-list-item']);

        $options = array_merge($this->inputOptions, $options);
        Html::addCssClass($options, $this->themeColor);

        $this->parts['{input}'] = Html::activeRadio($this->model, $this->attribute, $options);

        return $this;
    }

    public function checkbox($options = [], $enclosedByLabel = true)
    {
        $this->template = "\n{input}\n";
        $description = ArrayHelper::remove($options, 'description', '');

        if ($enclosedByLabel) {
            $label = "\n{label}\n";
            if (!empty($description)) {
                $label .= Html::tag('div', $description, ['class' => 'secondary']) . "\n";
                Html::addCssClass($this->options, ['md-3line']);
            }
            $this->template = "\n{input}\n" . Html::tag('div', $label, ['class' => 'text']) . "\n";
        }

        Html::addCssClass($this->options, ['mdc-list-item']);

        $options = array_merge($this->inputOptions, $options);
        Html::addCssClass($options, $this->themeColor);

        $this->parts['{input}'] = Html::activeCheckbox($this->model, $this->attribute, $options);

        return $this;
    }

    public function switch($options = [], $enclosedByLabel = true)
    {
        $this->template = "\n{input}\n";
        $description = ArrayHelper::remove($options, 'description', '');

        if ($enclosedByLabel) {
            $label = "\n{label}\n";
            if (!empty($description)) {
                $label .= Html::tag('div', $description, ['class' => 'secondary']) . "\n";
                Html::addCssClass($this->options, ['md-3line']);
            }
            $this->template = "\n" . Html::tag('div', $label, ['class' => 'text']) . "\n{input}\n";
        }

        Html::addCssClass($this->options, ['mdc-list-item']);

        $options = array_merge($this->inputOptions, $options);
        Html::addCssClass($options, $this->themeColor);

        $this->parts['{input}'] = Html::activeSwitch($this->model, $this->attribute, $options);

        return $this;
    }

    public function dropDownList($items, $options = [])
    {
        $selection = ArrayHelper::getValue($options, 'value', Html::getAttributeValue($this->model, $this->attribute));
        
        $options = array_merge($this->options, $options);
        $options = array_merge($this->inputOptions, $options);
        Html::addCssClass($options, ['menu-button', 'mdc-text-field', $this->themeColor]);

        if ($selection !== null) {
            Html::addCssClass($options, 'focus');
        }

        $dropDownListType = 'standard';
        if (Html::findCssClass($options, 'mdc-searchable')) {
            $dropDownListType = 'searchable';
            $error_message = ArrayHelper::remove($options, 'errorMessage', "Can't find any match!");
        }

        $this->template = Html::tag('div', "\n{value}\n{label}\n{input}\n{hint}\n{error}\n", $options) .
                          Html::tag('div', "\n{list}\n", ['class' => 'mdc-list-container']);

        $this->options['class'] = 'mdc-menu-container select-menu';

        if (Html::findCssClass($options, 'full-width')) {
            Html::addCssClass($this->options, 'full-width');
        }

        $value = Html::arrayValueSearch($items, $selection, '');

        if (!empty($value)) {
            $doc = new \DOMDocument();
            $doc->loadHTML($value);
            $xpath = new \DOMXPath($doc);
            foreach ($xpath->query('//div') as $node) {
                $node->parentNode->removeChild($node);
            }

            $value = trim(strip_tags($doc->saveHTML()));
        }

        if ($dropDownListType == 'searchable') {
            $this->parts['{value}'] = Html::tag('div', 'arrow_drop_down', ['class' => 'icon material-icon trailing']).
                                      Html::beginTag('div', ['class' => 'input']).
                                      Html::tag('input', null, ['class' => 'input-element', 'type' => 'text', 'value' => $value]).
                                      Html::endTag('div');
        } else {
            $this->parts['{value}'] = Html::tag('div', 'arrow_drop_down', ['class' => 'icon material-icon trailing']).
                                      Html::beginTag('div', ['class' => 'input']).
                                      Html::tag('div', $value, ['class' => 'input-element']).
                                      Html::endTag('div');
        }

        $options['class'] = 'select-value';

        $this->parts['{input}'] = Html::activeDropDownList($this->model, $this->attribute, $items, $options);

        $name = ArrayHelper::getValue($options, 'name', Html::getInputName($this->model, $this->attribute));
        $options['name'] = $name;
        ArrayHelper::remove($options, 'unselect');

        $this->parts['{list}'] = Html::renderSelectOptions($selection, $items, $options);

        if ($dropDownListType == 'searchable') {
            $this->parts['{list}'] .= "\n<div class=\"mdc-list-item mdc-error-message\"><div class=\"text text-hint\">$error_message</div></div>";
        }
        
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
