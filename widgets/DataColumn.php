<?php

namespace vip9008\MDC\widgets;

use vip9008\MDC\helpers\Html;
use yii\grid\DataColumn as BaseDataColumn;

class DataColumn extends BaseDataColumn
{
    /**
     * @var bool the direction of this column.
     */
    public $reverse = false;


    /**
     * Renders the header cell.
     */
    public function renderHeaderCell()
    {
        $options = $this->headerOptions;

        if ($this->reverse === true) {
            Html::addCssClass($options, 'direction-reverse');
        }
        
        return Html::tag('th', $this->renderHeaderCellContent(), $options);
    }
    /**
     * {@inheritdoc}
     */
    protected function renderHeaderCellContent()
    {
        Html::addCssClass($this->sortLinkOptions, 'column-sort');

        return parent::renderHeaderCellContent();
    }

    /**
     * Renders a data cell.
     * @param mixed $model the data model being rendered
     * @param mixed $key the key associated with the data model
     * @param int $index the zero-based index of the data item among the item array returned by [[GridView::dataProvider]].
     * @return string the rendering result
     */
    public function renderDataCell($model, $key, $index)
    {
        if ($this->contentOptions instanceof \Closure) {
            $options = call_user_func($this->contentOptions, $model, $key, $index, $this);
        } else {
            $options = $this->contentOptions;
        }

        if ($this->reverse === true) {
            Html::addCssClass($options, 'direction-reverse');
        }

        return Html::tag('td', $this->renderDataCellContent($model, $key, $index), $options);
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