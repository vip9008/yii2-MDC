<?php

namespace vip9008\MDC\helpers;

use yii\helpers\ArrayHelper;
use yii\helpers\Html as BaseHtml;

class Html extends BaseHtml
{
    public static function beginForm($action = '', $method = 'post', $options = ['class' => 'mdc-form'])
    {
        return parent::beginForm($action, $method, $options);
    }

    /**
     * Generates FAB component
     */
    private static function fab($icon, $label = null, $options = [])
    {
        $iconOptions = ArrayHelper::remove($options, 'icon', []);
        static::addCssClass($iconOptions, ['icon', 'material-icon']);

        $labelOptions = ArrayHelper::remove($options, 'icon', []);
        static::addCssClass($labelOptions, 'label');

        $icon = static::tag('div', $icon, $iconOptions);

        if ($label) {
            $label = static::tag('div', $label, $labelOptions);
        }

        return $icon."\n".$label;
    }

    public static function fabA($url, $icon, $label = null, $options = [])
    {
        static::addCssClass($options, 'mdc-fab-button');
        return static::a(static::fab($icon, $label), $url, $options);
    }

    public static function fabButton($icon, $label = null, $options = [])
    {
        static::addCssClass($options, 'mdc-fab-button');
        return static::button(static::fab($icon, $label), $options);
    }

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
    public static function listItem($text, $listOptions = [], $options = [])
    {
        $encodeText = ArrayHelper::remove($options, 'encodeText', true);
        $support = ArrayHelper::getValue($listOptions, 'support', null);
        $meta = ArrayHelper::getValue($listOptions, 'meta', null);
        $primaryAction = ArrayHelper::getValue($listOptions, 'primaryAction', null);

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
                    static::addCssClass($_options, 'icon material-icon');
                }
                $support = static::tag('div', ArrayHelper::getValue($support, 'string', ''), $_options);
            } else {
                $support = static::tag('div', '', ['class' => 'icon material-icon']);
            }
        } else {
            if ($support === null) {
                $support = '';
            } else {
                $support = static::tag('div', $support, ['class' => 'icon material-icon']);
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
            static::addCssClass($primaryAction, 'primary-action');
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
     * Renders and MDC divider.
     */
    public static function divider($options = [])
    {
        static::addCssClass($options, 'mdc-divider');
        return static::tag('div', '', $options);
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
        
        ArrayHelper::remove($options, 'type');
        ArrayHelper::remove($options, 'unselect');

        return static::hiddenInput($name, $selection, $options);
    }

    /**
     * Renders a stand-alone drop-down list.
     * @see [[dropDownList()]] for more information
     *
     * @return string the generated input
     */
    public static function dropDownListInput($name, $selection = null, $items = [], $options = [])
    {
        if (!empty($options['multiple'])) {
            return static::listBox($name, $selection, $items, $options);
        }
        
        ArrayHelper::remove($options, 'type');
        ArrayHelper::remove($options, 'unselect');
        ArrayHelper::remove($options, 'name');

        $label = ArrayHelper::remove($options, 'label', $name);

        $inputOptions = $options;
        $inputOptions['class'] = 'select-value';

        $_options = ['class' => ArrayHelper::getValue($options, 'class', [])];
        static::addCssClass($_options, ['menu-button', 'mdc-text-field']);
        if ($selection !== null) {
            static::addCssClass($_options, 'focus');
        }

        $selectionValue = static::arrayValueSearch($items, $selection);

        if (!empty($selectionValue)) {
            $doc = new \DOMDocument();
            @$doc->loadHTML($selectionValue);
            $xpath = new \DOMXPath($doc);
            foreach ($xpath->query('//div') as $node) {
                $node->parentNode->removeChild($node);
            }
            
            $selectionValue = trim(strip_tags($doc->saveHTML()));
        }

        $buttonTag = ArrayHelper::remove($_options, 'dropdownButtonTag', "button");

        $inputElement = static::tag($buttonTag, static::tag('div', $selectionValue, ['class' => 'input-element']), ['class' => 'input']);
        if (self::findCssClass($_options, 'mdc-searchable')) {
            $inputElement = static::tag('div', static::tag('input', $selectionValue, ['class' => 'input-element', 'type' => 'text']), ['class' => 'input']);
        }

        $input = static::tag('div',
                 static::tag('div', 'arrow_drop_down', ['class' => 'icon material-icon trailing']).
                 $inputElement.
                 static::tag('label', $label, ['class' => 'label']).
                 static::hiddenInput($name, $selection, $inputOptions),
                 $_options);

        $options['name'] = $name;

        $list = static::tag('div',
                static::tag('div',
                    static::renderSelectOptions($selection, $items, $options),
                    ['class' => 'mdc-list-container']
                ).
                static::tag('div', '', ['class' => 'menu-scrim', 'tabindex' => '-1']),
                ['class' => 'menu-container']
            );

        return static::tag('div', "\n$input\n$list\n", ['class' => 'mdc-menu-container select-menu']);
    }

    /**
     * Renders the option tags that can be used by [[dropDownList()]] and [[listBox()]].
     * @param string|array|null $selection the selected value(s). String for single or array for multiple selection(s).
     * @param array $items the option data items. The array keys are option values, and the array values
     * are the corresponding option labels. The array can also be nested (i.e. some array values are arrays too).
     * For each sub-array, an option group will be generated whose label is the key associated with the sub-array.
     * If you have a list of data models, you may convert them into the format described above using
     * [[\yii\helpers\ArrayHelper::map()]].
     *
     * Note, the values and labels will be automatically HTML-encoded by this method, and the blank spaces in
     * the labels will also be HTML-encoded.
     * @param array $tagOptions the $options parameter that is passed to the [[dropDownList()]] or [[listBox()]] call.
     * This method will take out these elements, if any: "prompt", "options" and "groups". See more details
     * in [[dropDownList()]] for the explanation of these elements.
     *
     * @return string the generated list options
     */
    public static function renderSelectOptions($selection, $items, &$tagOptions = [])
    {
        if (ArrayHelper::isTraversable($selection)) {
            $selection = array_map('strval', (array)$selection);
        }

        $lines = [];
        $encodeSpaces = ArrayHelper::remove($tagOptions, 'encodeSpaces', false);
        $encode = ArrayHelper::remove($tagOptions, 'encode', true);
        if (isset($tagOptions['prompt'])) {
            $promptOptions = ['data-value' => ''];
            ArrayHelper::remove($promptOptions, 'value');
            if (is_string($tagOptions['prompt'])) {
                $promptText = $tagOptions['prompt'];
            } else {
                $promptText = $tagOptions['prompt']['text'];
                $promptOptions = array_merge($promptOptions, $tagOptions['prompt']['options']);
            }
            $promptText = $encode ? static::encode($promptText) : $promptText;
            if ($encodeSpaces) {
                $promptText = str_replace(' ', '&nbsp;', $promptText);
            }
            static::addCssClass($promptOptions, ['interactive', 'text-secondary']);
            $promptOptions['tabindex'] = '-1';
            $promptOptions['data-label'] = '';
            $lines[] = static::listItem($promptText, [], $promptOptions);
        }

        $options = ArrayHelper::getValue($tagOptions, 'options', []);
        $groups = ArrayHelper::getValue($tagOptions, 'groups', []);

        unset($tagOptions['prompt'], $tagOptions['options'], $tagOptions['groups']);

        $options['encodeSpaces'] = ArrayHelper::getValue($options, 'encodeSpaces', $encodeSpaces);
        $options['encode'] = ArrayHelper::getValue($options, 'encode', $encode);

        $count = 0;
        foreach ($items as $key => $value) {
            if (is_array($value)) {
                $groupAttrs = ArrayHelper::getValue($groups, $key, []);
                $groupLabel = ArrayHelper::remove($groupAttrs, 'label', $key);

                $attrs = ['options' => $options, 'groups' => $groups, 'encodeSpaces' => $encodeSpaces, 'encode' => $encode];

                $content = static::renderSelectOptions($selection, $value, $attrs);

                if ($count > 0) {
                    $lines[] = static::tag('div', '', ['class' => 'mdc-divider']);
                }

                static::addCssClass($groupAttrs, 'mdc-list-group');

                if (!empty($groupLabel)) {
                    $groupLabel = static::tag('div', $groupLabel, ['class' => 'mdc-list-subtitle']);
                } else {
                    $groupLabel = '';
                }

                $lines[] = static::tag('div', "\n" . $groupLabel . "\n" . $content . "\n", $groupAttrs);
            } else {
                $attrs = ArrayHelper::remove($tagOptions, $key, []);
                $attrs['data-value'] = (string) $key;
                ArrayHelper::remove($attrs, 'value');

                if (!array_key_exists('selected', $attrs)) {
                    $attrs['selected'] = $selection !== null &&
                        (!ArrayHelper::isTraversable($selection) && !strcmp($key, $selection)
                        || ArrayHelper::isTraversable($selection) && ArrayHelper::isIn((string)$key, $selection));
                }

                if ($attrs['selected'] == true) {
                    static::addCssClass($attrs, 'selected');
                }
                ArrayHelper::remove($attrs, 'selected');

                $text = $encode ? static::encode($value) : $value;
                if ($encodeSpaces) {
                    $text = str_replace(' ', '&nbsp;', $text);
                }

                static::addCssClass($attrs, 'interactive');
                $attrs['tabindex'] = '-1';
                $attrs['data-label'] = ArrayHelper::getValue($attrs, 'data-label', $value);

                // if (!empty($value)) {
                //     $doc = new \DOMDocument();
                //     @$doc->loadHTML($value);
                //     $xpath = new \DOMXPath($doc);
                //     foreach ($xpath->query('//div') as $node) {
                //         $node->parentNode->removeChild($node);
                //     }
                //     $attrs['data-label'] = trim(strip_tags($doc->saveHTML()));
                // }
                
                $lines[] = static::listItem($text, [], $attrs);
            }
            $count++;
        }

        return implode("\n", $lines);
    }

    /**
     * Generates an mdc-text-field input.
     * @param string $name the name attribute.
     * @param string $value the value attribute. If it is null, the value attribute will not be generated.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[encode()]].
     * If a value is null, the corresponding attribute will not be rendered.
     * See [[renderTagAttributes()]] for details on how attributes are being rendered.
     * The following attributes will have special treatment:
     * string|array 'icon': Text field icon. [content => the icon itself, options => html options for the icon tag].
     * string 'label': Label for the input. if not set $name will be used instead.
     * string 'hint': Text to be rendered in the help block. if not set, help block will not render.
     * @return string the generated mdc-text-field
     */
    public static function textFieldInput($name, $value = null, $options = [])
    {
        $types_list = [
            'text',
            'email',
            'number',
            'password',
            'search',
            'tel',
            'url',
        ];

        $icon = ArrayHelper::remove($options, 'icon', null);

        if ($icon !== null) {
            if (is_array($icon)) {
                $_options = ArrayHelper::getValue($icon, 'options', []);
                $icon = ArrayHelper::getValue($icon, 'content', '');
            } else {
                $_options = [];
            }

            static::addCssClass($_options, ['icon', 'material-icon']);
            $tag = ArrayHelper::remove($_options, 'tag', 'div');
            $icon = static::tag($tag, $icon, $_options);
        } else {
            $icon = '';
        }

        $label = ArrayHelper::remove($options, 'label', ucfirst($name));
        $label = static::tag('label', $label, ['class' => 'label']);

        $hint = ArrayHelper::remove($options, 'hint', '');
        if (!empty($hint)) {
            $hint = static::tag('div', $hint, ['class' => 'help-block']);
        }

        $type = ArrayHelper::remove($options, 'type', 'text');
        if (!in_array($type, $types_list)) {
            $type = 'text';
        }

        $_options = ['class' => ArrayHelper::remove($options, 'class', [])];
        $color = ArrayHelper::remove($options, 'themeColor', 'indigo');
        static::addCssClass($_options, ['mdc-text-field', $color]);
        if ($value !== null) {
            static::addCssClass($_options, 'focus');
        }

        static::addCssClass($options, 'input-element');
        $input = static::tag('div', static::input($type, $name, $value, $options), ['class' => 'input']);

        return static::tag('div', "\n$icon\n$input\n$label\n$hint\n", $_options);
    }

    public static function textAreaInput($name, $value = null, $options = [])
    {
        $label = ArrayHelper::remove($options, 'label', ucfirst($name));
        $label = static::tag('label', $label, ['class' => 'label']);

        $hint = ArrayHelper::remove($options, 'hint', '');
        if (!empty($hint)) {
            $hint = static::tag('div', $hint, ['class' => 'help-block']);
        }

        $_options = ['class' => ArrayHelper::remove($options, 'class', [])];
        $color = ArrayHelper::remove($options, 'themeColor', 'indigo');
        static::addCssClass($_options, ['mdc-text-area', $color]);
        if ($value !== null) {
            static::addCssClass($_options, 'focus');
        }

        static::addCssClass($options, 'input-element');
        $input = static::tag('div', static::textarea($name, $value, $options), ['class' => 'input']);

        return static::tag('div', "\n$input\n$label\n$hint\n", $_options);
    }

    

    /**
     * Generates a list of checkboxes.
     * A checkbox list allows multiple selection, like [[listBox()]].
     * As a result, the corresponding submitted value is an array.
     * @param string $name the name attribute of each checkbox.
     * @param string|array|null $selection the selected value(s). String for single or array for multiple selection(s).
     * @param array $items the data item used to generate the checkboxes.
     * The array keys are the checkbox values, while the array values are the corresponding labels.
     * @param array $options options (name => config) for the checkbox list container tag.
     * The following options are specially handled:
     *
     * - tag: string|false, the tag name of the container element. False to render checkbox without container.
     *   See also [[tag()]].
     * - unselect: string, the value that should be submitted when none of the checkboxes is selected.
     *   By setting this option, a hidden input will be generated.
     * - disabled: boolean, whether the generated by unselect option hidden input should be disabled. Defaults to false.
     *   This option is available since version 2.0.16.
     * - encode: boolean, whether to HTML-encode the checkbox labels. Defaults to true.
     *   This option is ignored if `item` option is set.
     * - strict: boolean, if `$selection` is an array and this value is true a strict comparison will be performed on `$items` keys. Defaults to false.
     *   This option is available since 2.0.37.
     * - separator: string, the HTML code that separates items.
     * - itemOptions: array, the options for generating the checkbox tag using [[checkbox()]].
     * - item: callable, a callback that can be used to customize the generation of the HTML code
     *   corresponding to a single item in $items. The signature of this callback must be:
     *
     *   ```php
     *   function ($index, $label, $name, $checked, $value)
     *   ```
     *
     *   where $index is the zero-based index of the checkbox in the whole list; $label
     *   is the label for the checkbox; and $name, $value and $checked represent the name,
     *   value and the checked status of the checkbox input, respectively.
     *
     * See [[renderTagAttributes()]] for details on how attributes are being rendered.
     *
     * @return string the generated checkbox list
     */
    public static function checkboxList($name, $selection = null, $items = [], $options = [])
    {
        if (ArrayHelper::isTraversable($selection)) {
            $selection = array_map('strval', ArrayHelper::toArray($selection));
        }

        $formatter = ArrayHelper::remove($options, 'item');
        $encode = ArrayHelper::remove($options, 'encode', true);
        $separator = ArrayHelper::remove($options, 'separator', "\n");
        $tag = ArrayHelper::remove($options, 'tag', 'div');
        $strict = ArrayHelper::remove($options, 'strict', false);
        $themeColor = ArrayHelper::remove($options, 'themeColor', '');
        $itemOptions = ArrayHelper::remove($options, 'itemOptions', []);
        static::addCssClass($itemOptions, ['mdc-list-item']);

        $lines = [];
        $index = 0;
        foreach ($items as $value => $label) {
            $_name = $name;
            if (substr($_name, -2) !== '[]') {
                $_name .= "[$index]";
            } else {
                $_name = substr($_name, 0, -2) . "[$index]";
            }
            
            $_itemOptions = $itemOptions;
            $_options = $options;
            unset($_options['id']);
            $_options['value'] = $value;
            static::addCssClass($_options, $themeColor);

            $checked = $selection !== null && (!ArrayHelper::isTraversable($selection) && !strcmp($value, $selection) || ArrayHelper::isTraversable($selection) && ArrayHelper::isIn((string)$value, $selection, $strict));
            if ($formatter !== null) {
                $lines[] = call_user_func($formatter, $index, $label, $_name, $checked, $value);
            } else {
                $description = '';
                $meta = '';

                if (is_array($label)) {
                    $description = ArrayHelper::getValue($label, 'description', '');
                    $meta = ArrayHelper::getValue($label, 'meta', '');
                    $label = ArrayHelper::getValue($label, 'label', '');
                }

                if (!empty($description)) {
                    $description = static::tag('div', $description, ['class' => 'secondary']);
                    static::addCssClass($_itemOptions, ['md-3line']);
                }
                if (!empty($meta)) {
                    $meta = static::tag('div', $meta, ['class' => 'meta']);
                }

                $lines[] = static::beginTag('div', $_itemOptions);
                $lines[] = static::checkbox($_name, $checked, $_options);
                $lines[] = static::beginTag('div', ['class' => 'text']);
                $lines[] = $label.$description;
                $lines[] = static::endTag('div');
                $lines[] = $meta;
                $lines[] = static::endTag('div');
            }
            $index++;
        }

        if (isset($options['unselect'])) {
            // add a hidden field so that if the list box has no option being selected, it still submits a value
            $name2 = substr($name, -2) === '[]' ? substr($name, 0, -2) : $name;
            $hiddenOptions = [];
            // make sure disabled input is not sending any value
            if (!empty($options['disabled'])) {
                $hiddenOptions['disabled'] = $options['disabled'];
            }
            $hidden = static::hiddenInput($name2, $options['unselect'], $hiddenOptions);
            unset($options['unselect'], $options['disabled']);
        } else {
            $hidden = '';
        }

        $visibleContent = implode($separator, $lines);

        if ($tag === false) {
            return $hidden . $visibleContent;
        }

        return $hidden . static::tag($tag, $visibleContent, $options);
    }

    /**
     * Generates a switch input.
     * @see [[checkbox()]] for details.
     *
     * @return string the generated switch tag
     */
    public static function switch($name, $checked = false, $options = [])
    {
        return static::booleanInput('switch', $name, $checked, $options);
    }

    /**
     * Generates a switch tag.
     * @see [[activeCheckbox()]] for details
     *
     * @return string the generated switch tag
     */
    public static function activeSwitch($model, $attribute, $options = [])
    {
        return static::activeBooleanInput('switch', $model, $attribute, $options);
    }

    /**
     * Generates a button tag.
     * @param string $content the content enclosed within the button tag. It will NOT be HTML-encoded.
     * Therefore you can pass in HTML code such as an image tag. If this is is coming from end users,
     * you should consider [[encode()]] it to prevent XSS attacks.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[encode()]].
     * If a value is null, the corresponding attribute will not be rendered.
     * See [[renderTagAttributes()]] for details on how attributes are being rendered.
     * @return string the generated button tag
     */
    public static function button($content = 'Button', $options = ['class' => 'mdc-button'])
    {
        return parent::button($content, $options);
    }

    /**
     * Generates a boolean input.
     * @param string $type the input type. This can be either `radio` or `checkbox`.
     * @param string $name the name attribute.
     * @param bool $checked whether the checkbox should be checked.
     * @param array $options the tag options in terms of name-value pairs. The following options are specially handled:
     *
     * - uncheck: string, the value associated with the uncheck state of the checkbox. When this attribute
     *   is present, a hidden input will be generated so that if the checkbox is not checked and is submitted,
     *   the value of this attribute will still be submitted to the server via the hidden input.
     * - label: string, a label displayed next to the checkbox.  It will NOT be HTML-encoded. Therefore you can pass
     *   in HTML code such as an image tag. If this is is coming from end users, you should [[encode()]] it to prevent XSS attacks.
     *   When this option is specified, the checkbox will be enclosed by a label tag.
     * - labelOptions: array, the HTML attributes for the label tag. Do not set this option unless you set the "label" option.
     *
     * The rest of the options will be rendered as the attributes of the resulting checkbox tag. The values will
     * be HTML-encoded using [[encode()]]. If a value is null, the corresponding attribute will not be rendered.
     * See [[renderTagAttributes()]] for details on how attributes are being rendered.
     *
     * @return string the generated checkbox tag
     * @since 2.0.9
     */
    protected static function booleanInput($type, $name, $checked = false, $options = [])
    {
        $checked = (int) $checked;
        unset($options['label'], $options['labelOptions']);

        if (ArrayHelper::remove($options, 'listItem', false)) {
            unset($options['id']);
        }

        switch ($type) {
            case 'checkbox':
                $containerOptions = [
                    'class' => ArrayHelper::remove($options, 'class', ''),
                ];

                static::addCssClass($containerOptions, 'mdc-checkbox');
                static::addCssClass($options, 'mdc-control');

                return static::tag(
                    'div',
                    parent::booleanInput('checkbox', $name, $checked, $options).
                    static::tag('div', '', ['class' => 'control-icon']),
                    $containerOptions
                );
            break;

            case 'switch':
                $containerOptions = [
                    'class' => ArrayHelper::remove($options, 'class', ''),
                ];

                static::addCssClass($containerOptions, 'mdc-switch');
                static::addCssClass($options, 'mdc-control');

                return static::tag(
                    'div',
                    parent::booleanInput('checkbox', $name, $checked, $options).
                    static::tag('div', static::tag('div', '', ['class' => 'rail']), ['class' => 'control-icon']),
                    $containerOptions
                );
            break;

            case 'radio':
                $containerOptions = [
                    'class' => ArrayHelper::remove($options, 'class', ''),
                    'tabindex' => ArrayHelper::remove($options, 'tabindex', '0'),
                ];

                static::addCssClass($containerOptions, 'mdc-radiobutton');
                static::addCssClass($options, 'mdc-control');

                $options['type'] = 'radio';
                $options['name'] = $name;
                $options['checked'] = (bool) $checked;

                return static::tag(
                    'div',
                    static::tag('input', null, $options).
                    static::tag('div', '', ['class' => 'control-icon']),
                    $containerOptions
                );
            break;

            default:
                return static::input($type, $name, $checked, $options);
        }
    }

    /**
     * Find a css class in a set of html options.
     * @param array $options: html options in terms of name-value pairs.
     * @param string $class: the css class to be find in $options.
     *
     * @return bool
     */
    public static function findCssClass($options, $class)
    {
        $classes = ArrayHelper::getValue($options, 'class', []);
        if (!is_array($classes)) {
            $classes = explode(' ', $classes);
        }

        return in_array($class, $classes);
    }

    public static function arrayValueSearch($array, $index, $return = null)
    {
        foreach (new \RecursiveIteratorIterator(new \RecursiveArrayIterator($array)) as $key => $value) {
            if ((string) $key == (string) $index) {
                return $value;
            }
        }

        return $return;
    }
}