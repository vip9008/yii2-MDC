<?php

namespace vip9008\MDC\components;

use vip9008\MDC\helpers\Html;
use yii\grid\DataColumn as BaseDataColumn;

class DataColumn extends BaseDataColumn
{
    /**
     * {@inheritdoc}
     */
    protected function renderHeaderCellContent()
    {
        Html::addCssClass($this->sortLinkOptions, 'column-sort');

        return parent::renderHeaderCellContent();
    }

    /**
     * {@inheritdoc}
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $options = [
            'class' => 'cell-data',
        ];

        return Html::tag('div', parent::renderDataCellContent($model, $key, $index), $options);
    }
}