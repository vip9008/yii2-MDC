<?php

namespace vip9008\MDC\components;

use Yii;
use yii\helpers\ArrayHelper;
use vip9008\MDC\helpers\Html;
use vip9008\MDC\assets\NavDrawerAsset;

/**
 * A widget to render a nav drawer component
 * @param array $options: nav container html options in terms of name-value pairs.
 * @param string | array $drawerType: nav drawer type. will be added as a css class. defaults to permanent
 * supported drawer types are ['modal', 'persistent', 'permanent', 'clipped']
 *
 * @param string $primaryColor: component primary color.
 * @param string $accentColor: component accent color (unused).
 * @param array $header: nav drawer header section. example,
 *
 *      ```php
 *      [
 *          'title' => 'Header Title',
 *          'subtext' => 'Header Subtext',
 *      ];
 *      ```
 *
 *      ```php
 *      [
 *          'title' => [
 *              'label' => 'Header Title',
 *              'options' => [...],
 *          ],
 *          'subtext' => [
 *              'label' => 'Header Subtext',
 *              'options' => [...],
 *          ],
 *      ];
 *      ```
 *
 * @param array $navItems: navigation items to be rendered inside the drawer. example,
 *
 *      ```php
 *      [
 *          [
 *              'support' => [...],
 *              'label' => [
 *                  'overline' => ['string' => 'Overline', 'options' => ['class' => 'text-secondary']],
 *                  'text' => ['string' => 'Title', 'options' => ['class' => 'text-primary']],
 *                  'secondary' => ['string' => 'Secondary', 'options' => ['class' => 'text-secondary']],
 *              ],
 *              'meta' => [...],
 *              'url' => ['site/index'],
 *              'options' => [...],
 *          ],
 *          [
 *              'label' => 'Dropdown',
 *              'items' => [
 *                   ['label' => 'Level 1 - Dropdown A', 'url' => '#', 'options' => [...]],
 *                   '<div class="mdc-divider"></div>',
 *                   ['label' => 'Level 1 - Dropdown B', 'url' => '#'],
 *              ],
 *          ],
 *          [
 *              'label' => 'Login',
 *              'url' => ['site/login'],
 *              'visible' => Yii::$app->user->isGuest
 *          ],
 *      ];
 *      ```
 *
 * Note: Multilevel dropdowns beyond Level 1 are not supported.
 * @see vip9008\MDC\helpers\Html::listItem()
 * @see https://almoamen.net/MDC/components/lists.php
 *
 * @param string $encodeLabels: wether to encode $navItems labels or not. Html::encode() will be used if true. defaults to true.
 * @param string $activateItems: wether to add active class to currently active links or not. defaults to true.
 * @param string $activateParents: wether to add active class to the parent of currently active links or not. defaults to true.
 * @param string $route: current request route. defaults to null.
 * @param string $params: current request params. defaults to null.
*/

class NavDrawer extends \yii\base\Widget
{
    public $options = [];
    public $drawerType = ['permanent'];
    public $primaryColor = 'deep-purple-A700';
    public $accentColor = '';

    // header params
    public $header = [];

    // navigation items params
    public $navItems = [];
    public $encodeLabels = true;
    public $activateItems = true;
    public $activateParents = true;
    public $route = null;
    public $params = null;

    public function init()
    {
        parent::init();

        NavDrawerAsset::register($this->getView());

        $this->options['id'] = 'mdc-nav-drawer';
        Html::addCssClass($this->options, $this->drawerType);

        if ($this->route === null && Yii::$app->controller !== null) {
            $this->route = Yii::$app->controller->getRoute();
        }
        if ($this->params === null) {
            $this->params = Yii::$app->request->getQueryParams();
        }
    }

    public function run()
    {
        return Html::tag('nav', $this->renderHeader() . $this->renderItems(), $this->options) . Html::tag('div', '', ['class' => 'mdc-drawer-scrim', 'tabindex' => '-1']);
    }

    public function renderHeader()
    {
        if (!empty($this->header)) {
            $content = [];
            $options = ArrayHelper::remove($this->header, 'options', []);
            Html::addCssClass($options, 'header');

            foreach ($this->header as $item) {
                if (is_array($item)) {
                    $_tag = ArrayHelper::getValue($item, 'tag', 'div');
                    $_label = ArrayHelper::getValue($item, 'label', '');
                    $_options = ArrayHelper::getValue($item, 'options', []);

                    $content[] = Html::tag($_tag, $_label, $_options);
                } else {
                    // if item is not an array
                    $content[] = $item;
                }
            }

            return Html::tag('div', implode("\n", $content), ['class' => $options]);
        } else {
            return '';
        }
    }

    public function renderItems()
    {
        $items = [];

        foreach ($this->navItems as $i => $item) {
            if (!ArrayHelper::getValue($item, 'visible', true)) {
                continue;
            }

            if (is_string($item)) {
                $items[] = $item;
                continue;
            }

            $options = ArrayHelper::getValue($item, 'options', []);
            Html::addCssClass($options, $this->primaryColor);
            $item['options'] = $options;

            $items[] = $this->renderItem($item);
        }

        return Html::tag('div', implode("\n", $items), ['class' => 'mdc-list-container']);
    }

    public function renderItem($item)
    {
        if (!is_array($item)) {
            return $item;
        }

        $listItem = [
            'support' => ArrayHelper::getValue($item, 'support', null),
            'label' => ArrayHelper::getValue($item, 'label', false),
            'meta' => ArrayHelper::getValue($item, 'meta', null),
        ];

        if (!$listItem['label']) {
            throw new InvalidConfigException("No 'label' option could be found.");
        }

        $encodeLabel = ArrayHelper::getValue($item, 'encode', $this->encodeLabels);
        $items = ArrayHelper::getValue($item, 'items', '');
        $url = ArrayHelper::getValue($item, 'url', '#');
        $options = ArrayHelper::getValue($item, 'options', []);

        $options['encodeText'] = $encodeLabel;
        $active = $this->isItemActive($item);

        $dropdownItems = false;
        if (!empty($items) && is_array($items)) {
            foreach ($items as $subItem) {
                if ($this->isItemActive($subItem)) {
                    $active = true;
                }

                // ensure there are no sub items
                ArrayHelper::remove($subItem, 'items');
                $dropdownItems[] = $this->renderItem($subItem);
            }

            $dropdownItems = Html::tag('div', implode("\n", $dropdownItems), ['class' => 'mdc-dropdown']);
        }

        if ($this->activateItems && $active) {
            Html::addCssClass($options, 'active bold');
        }

        if ($dropdownItems !== false) {
            if (empty($listItem['meta'])) {
                $listItem['meta'] = [
                    'string' => Html::tag('div', 'keyboard_arrow_down', ['class' => 'material-icon']),
                    'options' => [
                        'class' => 'icon',
                    ]
                ];
            }

            $containerOptions = ['class' => 'mdc-list-group'];
            if ($this->activateItems && $active) {
                Html::addCssClass($containerOptions, 'expanded');
            } else {
                Html::addCssClass($containerOptions, 'collapsed');
            }

            Html::addCssClass($options, 'interactive');
            $listItem = Html::listItem($listItem['label'], $listItem['support'], $listItem['meta'], null, $options);
            return Html::tag('div', $listItem . $dropdownItems, $containerOptions);
        } else {
            $options['tag'] = 'a';
            $options['url'] = $url;
            return Html::listItem($listItem['label'], $listItem['support'], $listItem['meta'], null, $options);
        }
    }

    protected function isItemActive($item)
    {
        if (isset($item['url']) && is_array($item['url']) && isset($item['url'][0])) {
            $route = $item['url'][0];
            if ($route[0] !== '/' && Yii::$app->controller) {
                $route = Yii::$app->controller->module->getUniqueId() . '/' . $route;
            }
            if (ltrim($route, '/') !== $this->route) {
                // remove last part of route (action id)
                $trimmedRoute = ltrim(substr($route, 0, strrpos($route, '/')), '/');
                $trimmedCurrentRoute = substr($this->route, 0, strrpos($this->route, '/'));

                if (ArrayHelper::getValue($item, 'isParent', false)) {
                    if (empty($trimmedRoute) || empty($trimmedCurrentRoute) || $trimmedRoute != $trimmedCurrentRoute) {
                        return false;
                    }
                } else {
                    if (ltrim($route, '/') != $trimmedCurrentRoute) {
                        return false;
                    }
                }
            }
            unset($item['url']['#']);
            if (count($item['url']) > 1) {
                $params = $item['url'];
                unset($params[0]);
                foreach ($params as $name => $value) {
                    if ($value !== null && (!isset($this->params[$name]) || $this->params[$name] != $value)) {
                        return false;
                    }
                }
            }

            return true;
        }

        return false;
    }
}
