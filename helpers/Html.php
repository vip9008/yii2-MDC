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

        if ($tag == 'a') {
            $url = ArrayHelper::remove($options, 'url', '#');
            return static::a($support . $text . $meta, $url, $options);
        }

        return static::tag($tag, $support . $text . $meta, $options);
    }
}