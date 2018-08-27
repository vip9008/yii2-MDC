<?php

namespace vip9008\MDC\widgets;

use vip9008\MDC\helpers\Html;
use vip9008\MDC\assets\CardAsset;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView as BaseDetailView;

class DetailView extends BaseDetailView
{
    public $template = '<div class="row" style="padding: 1rem 0.5rem 0;">
                            <div class="col medium-4 smallext-5 small-3">
                                <div class="mdt-body" style="padding: 0 0.5rem 1rem;">{label}</div>
                            </div>
                            <div class="col xsmall-fill-space">
                                <div class="mdt-body text-secondary" style="padding: 0 0.5rem 1rem;">{value}</div>
                            </div>
                        </div>
                        <div class="mdc-divider"></div>';
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
}
