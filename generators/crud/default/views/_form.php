<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\helpers\ArrayHelper;
use vip9008\MDC\helpers\Html;
use vip9008\MDC\widgets\ActiveForm;
use vip9008\MDC\assets\CardAsset;

CardAsset::register($this);

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */

$primaryColor = ArrayHelper::getValue(Yii::$app->params, 'primaryColor', 'indigo');
$accentColor = ArrayHelper::getValue(Yii::$app->params, 'accentColor', 'blue');
?>

<div class="space"></div>
<div class="space"></div>

<div class="container">
    <div class="row">
        <div class="col xlarge-7 large-11 medium-12">
            <section class="chapter <?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">
                <h4 class="<?= '<?= $primaryColor ?>' ?>"><?= '<?= $this->title ?>' ?></h4>

                <?= "<?php " ?>$form = ActiveForm::begin(['themeColor' => $accentColor]); ?>
                <div class="mdc-card">
                    <div class="mdc-card-primary">

                        <div class="header <?= '<?= $primaryColor ?>' ?>">
                            <div class="title">
                                <h5 class="text-secondary"><?= '<?= $this->title ?>' ?></h5>
                            </div>
                        </div>

                        <div class="row">
<?php
foreach ($generator->getColumnNames() as $attribute):
if (in_array($attribute, $safeAttributes)): ?>
                            <div class="col">
                                <?= "<?= " . $generator->generateActiveField($attribute) . " ?>" ?>
                            </div>
<?php
endif;
endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="mdc-button-group direction-reverse">
                        <?= "<?= " ?>Html::submitButton(<?= $generator->generateString('Save') ?>, ['class' => "mdc-button btn-contained bg-$primaryColor"]) ?>
                        <?= "<?= " ?>Html::a(<?= $generator->generateString('Cancel') ?>, ['index'], ['class' => "mdc-button btn-outlined bg-$accentColor"]) ?>
                    </div>
                </div>
                <?= "<?php " ?>ActiveForm::end(); ?>
            </section>
        </div>
    </div>
</div>
