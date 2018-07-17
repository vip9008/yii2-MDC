<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

echo "<?php\n";
?>

use yii\helpers\ArrayHelper;
use vip9008\MDC\helpers\Html;
use vip9008\MDC\widgets\ActiveForm;
use vip9008\MDC\assets\CardAsset;

CardAsset::register($this);

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->searchModelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */

$primaryColor = ArrayHelper::getValue(Yii::$app->params, 'primaryColor', 'indigo');
$accentColor = ArrayHelper::getValue(Yii::$app->params, 'accentColor', 'blue');
?>

<?= "<?php " ?>$form = ActiveForm::begin([
    'themeColor' => $accentColor,
    'action' => ['index'],
    'method' => 'get',
<?php if ($generator->enablePjax): ?>
    'options' => [
        'data-pjax' => 1
    ],
<?php endif; ?>
]); ?>
<div class="mdc-card <?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-search">
    <div class="mdc-card-primary">
        <div class="row">
<?php
$count = 0;
foreach ($generator->getColumnNames() as $attribute):
if (++$count < 6): ?>
            <div class="col">
                <?= "<?= " . $generator->generateActiveSearchField($attribute) . " ?>" ?>
            </div>
<?php else: ?>
            <div class="col">
                <?= "<?= '' // " . $generator->generateActiveSearchField($attribute) . " ?>" ?>
            </div>
<?php
endif;
endforeach;?>
        </div>
    </div>

    <div class="mdc-button-group direction-reverse">
        <?= "<?= " ?>Html::submitButton(<?= $generator->generateString('Search') ?>, ['class' => "mdc-button btn-contained bg-$primaryColor"]) ?>
        <?= "<?= " ?>Html::a(<?= $generator->generateString('Reset') ?>, ['index'], ['class' => "mdc-button btn-outlined bg-$accentColor"]) ?>
    </div>
</div>
<?= "<?php " ?>ActiveForm::end(); ?>
