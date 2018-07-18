<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\helpers\ArrayHelper;
use vip9008\MDC\helpers\Html;
use <?= $generator->indexWidgetType === 'grid' ? "vip9008\\MDC\\components\\DataTable" : "yii\\widgets\\ListView" ?>;
<?= $generator->enablePjax ? 'use yii\widgets\Pjax;' : '' ?>

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;

$primaryColor = ArrayHelper::getValue(Yii::$app->params, 'primaryColor', 'indigo');
$accentColor = ArrayHelper::getValue(Yii::$app->params, 'accentColor', 'blue');
?>

<div class="container">
    <div class="row">
        <div class="col large-12">
            <section class="chapter <?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">

                <div class="mdc-button-group">
                    <?= "<?= " ?>Html::a(<?= $generator->generateString('Create ' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>, ['create'], ['class' => "mdc-button btn-contained bg-$accentColor"]) ?>
                </div>

<?php if($generator->enablePjax): ?>
                <?= "<?php Pjax::begin(); ?>" ?>
<?php endif; ?>

<?php if(!empty($generator->searchModelClass)): ?>
                <?= "<?php " . ($generator->indexWidgetType === 'grid' ? "// " : "") ?>echo $this->render('_search', ['model' => $searchModel]); ?>
<?php endif; ?>

<?php if ($generator->indexWidgetType === 'grid'): ?>
                <?= "<?= " ?>DataTable::widget([
                    'dataProvider' => $dataProvider,
<?php if (!empty($generator->searchModelClass)): ?>
                    // 'filterModel' => $searchModel,
<?php endif; ?>
                    'columns' => [
                        // ['class' => 'vip9008\MDC\widgets\SerialColumn'],

<?php
$count = 0;
if (($tableSchema = $generator->getTableSchema()) === false):
foreach ($generator->getColumnNames() as $name):
if (++$count < 6): ?>
                        '<?= $name ?>',
<?php else: ?>
                        // '<?= $name ?>',
<?php
endif;
endforeach;
else:
foreach ($tableSchema->columns as $column):
$format = $generator->generateColumnFormat($column);
if (++$count < 6): ?>
                        '<?= $column->name . ($format === 'text' ? "" : ":" . $format) ?>',
<?php else: ?>
                        // '<?= $column->name . ($format === 'text' ? "" : ":" . $format) ?>',
<?php
endif;
endforeach;
endif; ?>

                        ['class' => 'vip9008\MDC\widgets\ActionColumn'],
                    ],
                ]); ?>
<?php else: ?>
                <?= "<?= " ?>ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemOptions' => ['class' => 'item'],
                    'itemView' => function ($model, $key, $index, $widget) {
                        return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
                    },
                ]) ?>
<?php endif; ?>

<?php if($generator->enablePjax): ?>
                <?= "<?php Pjax::end(); ?>" ?>
<?php endif; ?>

            </section>
        </div>
    </div>
</div>
