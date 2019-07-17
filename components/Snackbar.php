<?php

namespace vip9008\MDC\components;

use Yii;
use yii\helpers\ArrayHelper;
use vip9008\MDC\helpers\Html;
use vip9008\MDC\assets\SnackbarAsset;

/**
 * Snackbar widget renders messages from session flash. All flash messages are displayed
 * in the sequence they were assigned using setFlash. You can set message as following:
 *
 * ```php
 * Yii::$app->session->setFlash('error', 'This is the message');
 * Yii::$app->session->setFlash('success', 'This is the message');
 * Yii::$app->session->setFlash('info', 'This is the message');
 * ```
 *
 * Multiple messages could be set as follows:
 *
 * ```php
 * Yii::$app->session->setFlash('error', ['Error 1', 'Error 2']);
 * ```
 *
 * @see https://almoamen.net/MDC/components/snackbars.php
 */
class Snackbar extends \yii\base\Widget
{
    /**
     * @var array Snackbars container Html attributes in terms of name => value.
     * Note: Snackbars container ID is set to #mdc-snackbars and cannot be changed.
     */
    public $options = [];

    /**
     * @var array the snackbar types configuration for the flash messages.
     * This array is setup as $key => $value, where:
     * - key: the name of the session flash variable
     * - value: the css class to be added to the snackbar
     */
    public $snackbarTypes = [
        'error'   => 'snackbar-error',
        'danger'  => 'snackbar-danger',
        'success' => 'snackbar-success',
        'info'    => 'snackbar-info',
        'warning' => 'snackbar-warning'
    ];

    /**
     * @var float Time in seconds before removing an active snackbar.
     * cannot be less than 4 or more than 10.
     */
    public $snackbarTime = 4.0;
    /**
     * @var array|null the action buttons Html attributs in terms of name => value.
     * if set to null action button will not be rendered.
     * default tag is [[button]] can be changed to [[a]] tag, example: ['tag' => 'a']
     * default label is [[Yii::t('yii', 'Dismiss')]] can be customized, example: ['label' => 'OK']
     */
    public $actionButton = null;

    public function init()
    {
        parent::init();
        $this->options['id'] = 'mdc-snackbars';

        SnackbarAsset::register($this->view);
        $this->view->registerJs("mdc_activate_snackbars({$this->snackbarTime});");
    }

    public function run()
    {
        $session = Yii::$app->session;
        $flashes = $session->getAllFlashes();

        echo Html::beginTag('div', $this->options);

        foreach ($flashes as $type => $flash) {
            $messageType = ArrayHelper::getValue($this->snackbarTypes, $type, $type);

            foreach ((array) $flash as $i => $message) {
                echo Html::beginTag('div', ['class' => "mdc-snackbar $messageType"]);
                    echo Html::tag('div', $message, ['class' => 'text']);
                    if (!empty($this->actionButton)) {
                        $tag = ArrayHelper::remove($this->actionButton, 'tag', 'button');
                        if (!in_array($tag, ['button', 'a'])) {
                            $tag = 'button';
                        }

                        $label = ArrayHelper::remove($this->actionButton, 'label', Yii::t('yii', 'Dismiss'));

                        Html::addCssClass($this->actionButton, "mdc-button");

                        echo Html::beginTag('div', ['class' => "mdc-button-group"]);
                            echo Html::tag($tag, $label, $this->actionButton);
                        echo Html::endTag('div');
                    }
                echo Html::endTag('div');
            }

            $session->removeFlash($type);
        }

        echo Html::endTag('div');
    }
}
