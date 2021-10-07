<?php

namespace vip9008\MDC\components;

use Yii;
use yii\helpers\ArrayHelper;
use vip9008\MDC\helpers\Html;
use vip9008\MDC\assets\TopAppBarAsset;

/**
 * A widget to render a top app bar component
 * @param array $options: top app bar container html options in terms of name-value pairs.
 * @param boolean $renderNavIcon: wether to render navigation icon or not. defaults to true.
 * @param boolean $navIcon: navigation icon html.
 * @param string|array $title (optional): top app bar title. array example,
 *
 *      ```php
 *      [
 *          'label' => 'Top App Bar Title',
 *          'options' => [...],
 *      ];
 *      ```
 *
 * @param array $actionItems: side action items. example,
 *
 *      ```php
 *      [
 *          '<button class="material-icon">person</button>',
 *          [
 *              'html' => '...',
 *              'options' => [...],
 *          ]
 *          [
 *              'html' => '...',
 *          ]
 *      ];
 *      ```
 *
*/

class TopAppBar extends \yii\base\Widget
{
    public $options = [];
    public $renderNavIcon = true;
    public $navIcon = '<button class="material-icon nav-icon">menu</button>';
    public $title = '';
    public $actionItems = [];

    public function init()
    {
        parent::init();

        TopAppBarAsset::register($this->getView());

        $this->options['id'] = 'mdc-top-app-bar';
    }

    public function run()
    {
        $barContent = [];

        if ($this->renderNavIcon) {
            $barContent[] = $this->navIcon;
        }

        if (!empty($this->title)) {
            if (is_array($this->title)) {
                $label = ArrayHelper::getValue($this->title, 'label', '');
                $options = ArrayHelper::getValue($this->title, 'options', []);
                Html::addCssClass($options, 'title');
                $barContent[] = Html::tag('div', $label, $options);
            } else {
                $barContent[] = Html::tag('div', $this->title, ['class' => 'title']);
            }
        }

        if (!empty($this->actionItems)) {
            if (!is_array($this->actionItems)) {
                throw new InvalidConfigException("'actionItems' expected to be an array.");
            }
            
            $barContent[] = Html::beginTag('div', ['class' => 'actions']);

            foreach ($this->actionItems as $item) {
                if (is_array($item)) {
                    $html = ArrayHelper::getValue($item, 'html', false);
                    if ($html === false) {
                        throw new InvalidConfigException("No 'html' option could be found.");
                    }

                    $options = ArrayHelper::getValue($item, 'options', []);
                    Html::addCssClass($options, 'action-item');

                    $barContent[] = Html::tag('div', $html, $options);
                } else {
                    $barContent[] = Html::tag('div', $item, ['class' => 'action-item']);
                }
            }

            $barContent[] = Html::endTag('div');
        }

        return Html::tag('header', implode("\n", $barContent), $this->options);
    }
}
