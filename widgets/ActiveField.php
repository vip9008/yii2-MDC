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
    
    private $_skipLabelFor = false;

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
        Html::addCssClass($this->errorOptions, ['mdt-caption']);
        Html::addCssClass($this->hintOptions, ['mdt-caption']);
        
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

    protected function booleanField($type, $options = [], $enclosedByLabel = true)
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
            if ($type == 'switch') {
                $this->template = "\n" . Html::tag('div', $label, ['class' => 'text']) . "\n{input}\n";
            }
        }

        Html::addCssClass($this->options, ['mdc-list-item']);

        $options = array_merge($this->inputOptions, $options);
        Html::addCssClass($options, $this->themeColor);

        return Html::{"active".ucfirst($type)}($this->model, $this->attribute, $options);
    }

    public function radio($options = [], $enclosedByLabel = true)
    {
        $this->parts['{input}'] = $this->booleanField('radio', $options, $enclosedByLabel);
        return $this;
    }

    public function checkbox($options = [], $enclosedByLabel = true)
    {
        $this->parts['{input}'] = $this->booleanField('checkbox', $options, $enclosedByLabel);
        return $this;
    }

    public function switch($options = [], $enclosedByLabel = true)
    {
        $this->parts['{input}'] = $this->booleanField('switch', $options, $enclosedByLabel);
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

        $buttonTag = ArrayHelper::remove($options, 'dropdownButtonTag', ($dropDownListType = 'searchable' ? "div" : "button");

        if ($buttonTag == 'button') {
            $options['type'] = 'button';
        }

        $this->template = Html::tag($buttonTag, "\n{value}\n{label}\n{input}\n{hint}\n{error}\n", $options) . Html::tag('div', Html::tag('div', "\n{list}\n", ['class' => 'mdc-list-container']), ['class' => 'menu-container']);

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
        $containerOptions = ArrayHelper::remove($options, 'containerOptions', []);

        if ($this->form->validationStateOn === ActiveForm::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($containerOptions);
        }

        $this->addAriaAttributes($containerOptions);
        $this->adjustLabelFor($containerOptions);
        $this->_skipLabelFor = true;
        
        if (empty($options['id'])) {
             $containerOptions['id'] = Html::getInputId($this->model, $this->attribute);
        } else {
            $containerOptions['id'] = $options['id'];
            unset($options['id']);
        }
        Html::addCssClass($containerOptions, ['mdc-list-group']);
        $this->options = array_merge($this->options, $containerOptions);
        $this->template = Html::tag('div', "\n{label}\n", ['class' => 'mdc-list-subtitle', 'style' => 'padding-bottom: 0;'])."\n{input}\n".Html::tag('div', "\n{hint}\n{error}\n", ['class' => 'mdc-list-subtitle', 'style' => 'padding-top: 0;']);
        $options['themeColor'] = $this->themeColor;
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
        $containerOptions = ArrayHelper::remove($options, 'containerOptions', []);

        if ($this->form->validationStateOn === ActiveForm::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($containerOptions);
        }

        $this->addRoleAttributes($containerOptions, 'radiogroup');
        $this->addAriaAttributes($containerOptions);
        $this->adjustLabelFor($containerOptions);
        $this->_skipLabelFor = true;
        
        if (empty($options['id'])) {
             $containerOptions['id'] = Html::getInputId($this->model, $this->attribute);
        } else {
            $containerOptions['id'] = $options['id'];
            unset($options['id']);
        }
        Html::addCssClass($containerOptions, ['mdc-list-group']);
        $this->options = array_merge($this->options, $containerOptions);
        $this->template = Html::tag('div', "\n{label}\n", ['class' => 'mdc-list-subtitle', 'style' => 'padding-bottom: 0;'])."\n{input}\n".Html::tag('div', "\n{hint}\n{error}\n", ['class' => 'mdc-list-subtitle', 'style' => 'padding-top: 0;']);

        unset($options['autocomplete']);
        $options['listItem'] = true;

        $itemOptions = ArrayHelper::remove($options, 'itemOptions', []);
        Html::addCssClass($itemOptions, ['mdc-list-item']);

        $content = [];
        foreach ($items as $value => $label) {
            $_itemOptions = $itemOptions;
            $_options = $options;
            $_options['value'] = $value;
            Html::addCssClass($_options, $this->themeColor);
            $_options = array_merge($this->inputOptions, $_options);

            $description = '';
            $meta = '';

            if (is_array($label)) {
                $description = ArrayHelper::getValue($label, 'description', '');
                $meta = ArrayHelper::getValue($label, 'meta', '');
                $label = ArrayHelper::getValue($label, 'label', '');
            }
            if (!empty($description)) {
                $description = Html::tag('div', $description, ['class' => 'secondary']);
                Html::addCssClass($_itemOptions, ['md-3line']);
            }
            if (!empty($meta)) {
                $meta = Html::tag('div', $meta, ['class' => 'meta']);
            }

            $content[] = Html::beginTag('div', $_itemOptions);
            $content[] = Html::activeRadio($this->model, $this->attribute, $_options);
            $content[] = Html::beginTag('div', ['class' => 'text']);
            $content[] = $label.$description;
            $content[] = Html::endTag('div');
            $content[] = $meta;
            $content[] = Html::endTag('div');
        }

        $this->parts['{input}'] = implode("\n", $content);
        return $this;
    }
}
