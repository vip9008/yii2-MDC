<?php

namespace vip9008\materialgrid\helpers;

use yii\helpers\ArrayHelper;

class Component extends Html
{
    /**
     * Generates a List Item component (List Row).
     * @param string|array $text: the component primary text part. Array example,
     *
     *   ```php
     *   [
     *       'overline' => ['string' => 'Overline', 'options' => ['class' => 'text-secondary']],
     *       'text' => ['string' => 'Title', 'options' => ['class' => 'text-primary']],
     *       'secondary' => ['string' => 'Secondary', 'options' => ['class' => 'text-secondary']],
     *   ];
     *   ```
     *
     * @param string|array $support: the component supporting visual part. Array example,
     *
     *   ```php
     *   [
     *       'string' => 'people',
     *       'options' => ['class' => 'graphic'],
     *   ];
     *   ```
     *
     * @param string|array $meta: the component metadata part. Array example,
     *
     *   ```php
     *   [
     *       'string' => 'info',
     *       'options' => ['class' => 'material-icon'],
     *   ];
     *   ```
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
    public static function listItem($text, $support = null, $meta = null, $options = []) {
        if (is_array($text)) {
            $overline = ArrayHelper::getValue($text, 'overline', []);
            if (!empty($overline)) {
                $_options = ArrayHelper::getValue($overline, 'options', []);
                static::addCssClass($_options, 'overline');
                $overline = static::tag('div', ArrayHelper::getValue($overline, 'string', ''), $_options);
            } else {
                $overline = '';
            }
            
            $secondary = ArrayHelper::getValue($text, 'secondary', []);
            if (!empty($secondary)) {
                $_options = ArrayHelper::getValue($secondary, 'options', []);
                static::addCssClass($_options, 'secondary');
                $secondary = static::tag('div', ArrayHelper::getValue($secondary, 'string', ''), $_options);
            } else {
                $secondary = '';
            }
            
            $text = ArrayHelper::getValue($text, 'text', []);
            if (!empty($text)) {
                $_options = ArrayHelper::getValue($text, 'options', []);
                static::addCssClass($_options, 'text');
                $text = static::tag('div', $overline . ArrayHelper::getValue($text, 'string', '') . $secondary, $_options);
            } else {
                $text = static::tag('div', $overline . $secondary, ['class' => 'text']);
            }
        } else {
            $text = static::tag('div', $text, ['class' => 'text']);
        }

        if (is_array($support)) {
            if (!empty($support)) {
                $_options = ArrayHelper::getValue($support, 'options', []);
                static::addCssClass($_options, 'icon');
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

        $tag = ArrayHelper::remove($options, 'tag', 'div');
        static::addCssClass($options, 'mdc-list-item');

        return static::tag($tag, $support . $text . $meta, $options);
    }
}
