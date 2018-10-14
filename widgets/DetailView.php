<?php

namespace vip9008\MDC\widgets;

use vip9008\MDC\helpers\Html;
use vip9008\MDC\assets\CardAsset;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView as BaseDetailView;

class DetailView extends BaseDetailView
{
    public $template = '<div style="padding: 1rem 0.5rem 0;" {options}>
                            <div {captionOptions}>
                                <div class="mdt-body" style="padding: 0 0.5rem 1.0625rem;">{label}</div>
                            </div>
                            <div {contentOptions}>
                                <div class="mdt-body text-secondary" style="padding: 0 0.5rem 1.0625rem;">{value}</div>
                            </div>
                        </div>
                        <div class="mdc-divider" style="margin-top: -1px;"></div>';
    public $options = ['class' => 'mdc-card-primary'];
    public $actions = [];

    public function run()
    {
        CardAsset::register($this->getView());

        $rows = [];
        $i = 0;
        foreach ($this->attributes as $attribute) {
            $rows[] = $this->renderAttribute($attribute, $i++);
        }

        $actions = '';
        if (!empty($this->actions)) {
            $_options = ArrayHelper::remove($this->actions, 'options', []);
            Html::addCssClass($_options, 'mdc-button-group');
            $actions .= Html::beginTag('div', $_options);

            foreach ($this->actions as $item) {
                $actions .= $item;
            }

            $actions .= Html::endTag('div');
        }

        $options = $this->options;
        $tag = ArrayHelper::remove($options, 'tag', 'div');
        
        echo Html::tag('div',
                Html::tag($tag, implode("\n", $rows), $options) . $actions,
            ['class' => 'mdc-card', 'style' => 'max-width: 840px;']);
    }

    protected function renderAttribute($attribute, $index)
    {
        if (is_string($this->template)) {
            $captionOptions = ArrayHelper::getValue($attribute, 'captionOptions', []);
            Html::addCssClass($captionOptions, 'col medium-4 smallext-5 small-3');
            $captionOptions = Html::renderTagAttributes($captionOptions);

            $contentOptions = ArrayHelper::getValue($attribute, 'contentOptions', []);
            Html::addCssClass($contentOptions, 'col xsmall-fill-space');
            $contentOptions = Html::renderTagAttributes($contentOptions);

            $options = ArrayHelper::getValue($attribute, 'options', []);
            Html::addCssClass($options, 'row');
            $options = Html::renderTagAttributes($options);

            return strtr($this->template, [
                '{label}' => $attribute['label'],
                '{value}' => $this->formatter->format($attribute['value'], $attribute['format']),
                '{captionOptions}' => $captionOptions,
                '{contentOptions}' => $contentOptions,
                '{options}' => $options,
            ]);
        }

        return call_user_func($this->template, $attribute, $index, $this);
    }
}
