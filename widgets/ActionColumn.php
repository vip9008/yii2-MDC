<?php

namespace vip9008\MDC\widgets;

use Yii;
use vip9008\MDC\helpers\Html;
use yii\grid\ActionColumn as BaseActionColumn;

class ActionColumn extends BaseActionColumn
{
    /**
     * @var string the template used for composing each cell in the action column.
     * Tokens enclosed within curly brackets are treated as controller action IDs (also called *button names*
     * in the context of action column). They will be replaced by the corresponding button rendering callbacks
     * specified in [[buttons]]. For example, the token `{view}` will be replaced by the result of
     * the callback `buttons['view']`. If a callback cannot be found, the token will be replaced with an empty string.
     *
     * As an example, to only have the view, and update button you can add the ActionColumn to your GridView columns as follows:
     *
     * ```php
     * ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {update}'],
     * ```
     *
     * @see buttons
     */
    public $template = "{view}\n{update}\n{delete}";
    /**
     * @var array html options to be applied to the [[initDefaultButton()|default button]].
     * @since 2.0.4
     */
    public $buttonOptions = [];
    /**
     * @var bool action menu mode. if true action buttons will be rendered as dropdown menu.
     */
    public $menuMode = false;

    /**
     * Initializes the default button rendering callbacks.
     */
    protected function initDefaultButtons()
    {
        $this->initDefaultButton('view', 'view_list');
        $this->initDefaultButton('update', 'edit');
        $this->initDefaultButton('delete', 'delete', [
            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
            'data-method' => 'post',
        ]);
    }

    /**
     * Initializes the default button rendering callback for single button.
     * @param string $name Button name as it's written in template
     * @param string $iconName The part of Bootstrap glyphicon class that makes it unique
     * @param array $additionalOptions Array of additional options
     * @since 2.0.11
     */
    protected function initDefaultButton($name, $iconName, $additionalOptions = [])
    {
        if (!isset($this->buttons[$name]) && strpos($this->template, '{' . $name . '}') !== false) {
            $this->buttons[$name] = function ($url, $model, $key) use ($name, $iconName, $additionalOptions) {
                switch ($name) {
                    case 'view':
                        $title = Yii::t('yii', 'Show details');
                        break;
                    case 'update':
                        $title = Yii::t('yii', 'Update information');
                        break;
                    case 'delete':
                        $title = Yii::t('yii', 'Delete record');
                        break;
                    default:
                        $title = ucfirst($name);
                }

                $options = array_merge([
                    'title' => $title,
                    'aria-label' => $title,
                    'data-pjax' => '0',
                ], $additionalOptions, $this->buttonOptions);

                if ($this->menuMode) {
                    Html::addCssClass($options, 'mdc-list-item');

                    return Html::a(
                        Html::tag('div', $iconName, ['class' => 'material-icon icon']).
                        Html::tag('div', $title, ['class' => 'text']),
                        $url,
                        $options
                    );
                }

                Html::addCssClass($options, 'material-icon icon');
                return Html::tag('div', Html::a($iconName, $url, $options), ['class' => 'action-item']);
            };
        }
    }

    public function renderDataCell($model, $key, $index)
    {
        if ($this->contentOptions instanceof Closure) {
            $options = call_user_func($this->contentOptions, $model, $key, $index, $this);
        } else {
            $options = $this->contentOptions;
        }

        if ($this->menuMode) {
            $actions = Html::tag('div',
                Html::button('more_vert', ['class' => 'material-icon icon menu-button']).
                Html::tag('div',
                    Html::tag('div',
                        Html::tag('div', $this->renderDataCellContent($model, $key, $index), ['class' => 'mdc-list-group']),
                    ['class' => 'mdc-list-container']),
                ['class' => 'menu-container']).
                Html::tag('div', '', ['class' => 'menu-scrim', 'tabindex' => '-1']),
            ['class' => 'action-item mdc-menu-container reverse']);
        } else {
            $actions = $this->renderDataCellContent($model, $key, $index);
        }
        
        $actions = Html::tag('div', Html::tag('div', $actions, ['class' => 'actions']), ['class' => 'cell-data action-container']);
        return Html::tag('td', $actions, $options);
    }

    // public function renderHeaderCell()
    // {
    //     return Html::tag('th', Html::tag('div', $this->renderHeaderCellContent(), []), $this->headerOptions);
    // }

    // public function renderFooterCell()
    // {
    //     return Html::tag('td', Html::tag('div', $this->renderFooterCellContent(), ['class' => 'cell-data action-container']), $this->footerOptions);
    // }
}