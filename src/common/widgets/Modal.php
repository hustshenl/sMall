<?php
/**
 * Author: Shen.L
 * Email: shen@shenl.com
 * Date: 2017/3/7
 * Time: 0:03
 */

namespace common\widgets;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Modal extends \yii\bootstrap\Modal
{

    public $enableAjaxSubmit = true;
    public $size=self::SIZE_LARGE;

    public function init()
    {

        $this->renderJs();
        parent::init();
    }

    protected function renderJs()
    {
        $view = $this->getView();
        ModalAsset::register($view);
        $id = $this->getId();
        $this->toggleButton['id'] = $id . '-btn';
        $this->toggleButton['data-href'] = $this->toggleButton['href'];
        unset($this->toggleButton['href']);
        $enableAjaxSubmit = $this->enableAjaxSubmit ? 'true' : 'false';
        $view->registerJs(<<<JS
;yii.modal.initModal('#{$id}-btn','#{$id}',{$enableAjaxSubmit});
JS
        );
    }

    public static function renderViewHeader($header = '', $headerOptions = [])
    {
        $button = static::renderViewCloseButton();
        if ($button !== null) {
            $header = $button . "\n" . $header;
        }
        if ($header !== null) {
            Html::addCssClass($headerOptions, ['widget' => 'modal-header']);
            return Html::tag('div', "\n" . $header . "\n", $headerOptions);
        } else {
            return null;
        }
    }

    protected static function renderViewCloseButton($closeButton = [
        'data-dismiss' => 'modal',
        'aria-hidden' => 'true',
        'class' => 'close',
    ])
    {
        if ($closeButton !== false) {
            $tag = ArrayHelper::remove($closeButton, 'tag', 'button');
            $label = ArrayHelper::remove($closeButton, 'label', '&times;');
            if ($tag === 'button' && !isset($closeButton['type'])) {
                $closeButton['type'] = 'button';
            }
            return Html::tag($tag, $label, $closeButton);
        } else {
            return null;
        }
    }

}