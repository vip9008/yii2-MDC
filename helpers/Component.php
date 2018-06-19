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
     *       'graphic' => true,
     *       'options' => ['class' => 'text-secondary'],
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
     * @param array $options: the component container html options in terms of name-value pairs.
     * @return string the generated html component
     *
     * @see https://almoamen.net/MDC/components/lists.php
     */
    public static function listItem($text, $support = null, $meta = null, $options = []) {
    }
}
