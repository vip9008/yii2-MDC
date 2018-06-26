<?php

namespace vip9008\MDC\helpers;

use yii\helpers\ArrayHelper;
use yii\helpers\Html as BaseHtml;

class Html extends BaseHtml
{
    /**
     * Generates a List Item component (List Row).
     * @param string|array $text: the component primary text part. array example,
     *
     *   ```php
     *   [
     *       'overline' => 'Overline',
     *       'text' => 'Title',
     *       'secondary' => 'Secondary',
     *   ];
     *   ```
     *
     *   ```php
     *   [
     *       'overline' => ['string' => 'Overline', 'options' => ['class' => 'text-secondary']],
     *       'text' => ['string' => 'Title', 'options' => ['class' => 'text-primary']],
     *       'secondary' => ['string' => 'Secondary', 'options' => ['class' => 'text-secondary']],
     *   ];
     *   ```
     *
     * @param string|array $support: the component supporting visual part. array example,
     *
     *   ```php
     *   [
     *       'string' => 'people',
     *       'options' => ['class' => 'graphic'],
     *   ];
     *   ```
     *
     * @param string|array $meta: the component metadata part. array example,
     *
     *   ```php
     *   [
     *       'string' => 'info',
     *       'options' => ['class' => 'icon'],
     *   ];
     *   ```
     *
     * @param array $primaryAction: primary action html options in terms of name-value pairs. you can specify the container tag. example,
     *
     *   ```php
     *   [
     *       'url' => ['controller/action'],
     *       'tag' => 'a',
     *   ];
     *   ```
     *
     * defaults to button if not specified. recommended tags are ['a', 'button'].
     *
     * @param array $options: the component container html options in terms of name-value pairs. you can specify the container tag. example,
     *
     *   ```php
     *   [
     *       'tag' => 'div',
     *   ];
     *   ```
     *
     * this will generate a div tag as a container. defaults to div if not specified. recommended tags are ['div', 'a', 'button'].
     *
     * @return string the generated html component
     *
     * @see https://almoamen.net/MDC/components/lists.php
     */
    public static function listItem($text, $support = null, $meta = null, $primaryAction = null, $options = []) {
        $encodeText = ArrayHelper::remove($options, 'encodeText', true);

        if (is_array($text)) {
            $overline = ArrayHelper::getValue($text, 'overline', []);
            if (!empty($overline)) {
                if (is_array($overline)) {
                    $_options = ArrayHelper::getValue($overline, 'options', []);
                    static::addCssClass($_options, 'overline');
                    $string = ArrayHelper::getValue($overline, 'string', '');
                    $string = $encodeText ? static::encode($string) : $string;
                    $overline = static::tag('div', $string, $_options);
                } else {
                    $overline = static::tag('div', $overline, ['class' => 'overline']);
                }
            } else {
                $overline = '';
            }
            
            $secondary = ArrayHelper::getValue($text, 'secondary', []);
            if (!empty($secondary)) {
                if (is_array($secondary)) {
                    $_options = ArrayHelper::getValue($secondary, 'options', []);
                    static::addCssClass($_options, 'secondary');
                    $string = ArrayHelper::getValue($secondary, 'string', '');
                    $string = $encodeText ? static::encode($string) : $string;
                    $secondary = static::tag('div', $string, $_options);
                } else {
                    $secondary = static::tag('div', $secondary, ['class' => 'secondary']);
                }
            } else {
                $secondary = '';
            }
            
            $text = ArrayHelper::getValue($text, 'text', []);
            if (!empty($text)) {
                if (is_array($text)) {
                    $_options = ArrayHelper::getValue($text, 'options', []);
                    static::addCssClass($_options, 'text');
                    $string = ArrayHelper::getValue($text, 'string', '');
                    $string = $encodeText ? static::encode($string) : $string;
                    $text = static::tag('div', $overline . $string . $secondary, $_options);
                } else {
                    $text = static::tag('div', $overline . $text . $secondary, ['class' => 'text']);
                }
            } else {
                $text = static::tag('div', $overline . $secondary, ['class' => 'text']);
            }
        } else {
            $text = static::tag('div', $text, ['class' => 'text']);
        }

        if (is_array($support)) {
            if (!empty($support)) {
                $_options = ArrayHelper::getValue($support, 'options', []);
                if (empty(ArrayHelper::getValue($_options, 'class'))) {
                    static::addCssClass($_options, 'icon');
                }
                $support = static::tag('div', ArrayHelper::getValue($support, 'string', ''), $_options);
            } else {
                $support = static::tag('div', '', ['class' => 'icon']);
            }
        } else {
            if ($support === null) {
                $support = '';
            } else {
                $support = static::tag('div', $support, ['class' => 'icon']);
            }
        }

        if (is_array($meta)) {
            if (!empty($meta)) {
                $_options = ArrayHelper::getValue($meta, 'options', []);
                static::addCssClass($_options, 'meta');
                $meta = static::tag('div', ArrayHelper::getValue($meta, 'string', ''), $_options);
            } else {
                $meta = '';
            }
        } else {
            if ($meta === null) {
                $meta = '';
            } else {
                $meta = static::tag('div', $meta, ['class' => 'meta']);
            }
        }

        if ($primaryAction === null) {
                $primaryAction = '';
        } else {
            $tag = ArrayHelper::remove($primaryAction, 'tag', 'button');
            Html::addCssClass($primaryAction, 'primary-action');
            if ($tag == 'a') {
                $url = ArrayHelper::remove($primaryAction, 'url', 'javascript: ;');
                $primaryAction = static::a('', $url, $primaryAction);
            } else {
                $primaryAction = static::tag($tag, '', $primaryAction);
            }
        }

        $tag = ArrayHelper::remove($options, 'tag', 'div');
        static::addCssClass($options, 'mdc-list-item');

        if ($tag == 'a') {
            $url = ArrayHelper::remove($options, 'url', '#');
            return static::a($support . $text . $meta, $url, $options);
        }

        return static::tag($tag, $support . $text . $primaryAction . $meta, $options);
    }

    /**
     * Generates a drop-down list.
     * @param string $name the input name
     * @param string|array|null $selection the selected value(s). String for single or array for multiple selection(s).
     * @param array $items the option data items. The array keys are option values, and the array values
     * are the corresponding option labels. The array can also be nested (i.e. some array values are arrays too).
     * For each sub-array, an option group will be generated whose label is the key associated with the sub-array.
     * If you have a list of data models, you may convert them into the format described above using
     * [[\yii\helpers\ArrayHelper::map()]].
     *
     * Note, the values and labels will be automatically HTML-encoded by this method, and the blank spaces in
     * the labels will also be HTML-encoded.
     * @param array $options the tag options in terms of name-value pairs. The following options are specially handled:
     *
     * - prompt: string, a prompt text to be displayed as the first option. Since version 2.0.11 you can use an array
     *   to override the value and to set other tag attributes:
     *
     *   ```php
     *   ['text' => 'Please select', 'options' => ['value' => 'none', 'class' => 'prompt', 'label' => 'Select']],
     *   ```
     *
     * - options: array, the attributes for the select option tags. The array keys must be valid option values,
     *   and the array values are the extra attributes for the corresponding option tags. For example,
     *
     *   ```php
     *   [
     *       'value1' => ['disabled' => true],
     *       'value2' => ['label' => 'value 2'],
     *   ];
     *   ```
     *
     * - groups: array, the attributes for the optgroup tags. The structure of this is similar to that of 'options',
     *   except that the array keys represent the optgroup labels specified in $items.
     * - encodeSpaces: bool, whether to encode spaces in option prompt and option value with `&nbsp;` character.
     *   Defaults to false.
     * - encode: bool, whether to encode option prompt and option value characters.
     *   Defaults to `true`. This option is available since 2.0.3.
     *
     * The rest of the options will be rendered as the attributes of the resulting tag. The values will
     * be HTML-encoded using [[encode()]]. If a value is null, the corresponding attribute will not be rendered.
     * See [[renderTagAttributes()]] for details on how attributes are being rendered.
     *
     * @return string the generated drop-down list tag
     */
    public static function dropDownList($name, $selection = null, $items = [], $options = [])
    {
        if (!empty($options['multiple'])) {
            return static::listBox($name, $selection, $items, $options);
        }
        $_options = $options;
        $_options['name'] = $name;
        unset($options['unselect']);
        $selectOptions = static::renderSelectOptions($selection, $items, $_options);

        var_dump($options);
        $input = static::tag(
            'div',
            Html::tag('div', 'arrow_drop_down', ['class' => 'icon material-icon trailing']).
            Html::tag('div', ArrayHelper::getValue($items, $selection, ''), ['class' => 'input']).
            Html::hiddenInput($name, $selection, $options),
            ['class' => 'mdc-text-field menu-button']
        );

        return $input;
        return static::tag('select', "\n" . $selectOptions . "\n", $options);
    }
}