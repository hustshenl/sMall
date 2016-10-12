<?php
/**
 * @copyright Copyright (c) 2012 - 2015 SHENL.COM
 * @license http://www.shenl.com/license/
 */

namespace common\widgets;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

class ActionColumn extends \yii\grid\ActionColumn
{

    /**
     * @var array the HTML options for the data cell tags.
     */
    public $headerOptions = ['class' => 'text-center'];

    /**
     * @var array the HTML options for the data cell tags.
     */
    public $contentOptions = ['class' => 'text-center'];

    /**
     * @var string the template that is used to render the content in each data cell.
     */
    public $template = '{update}';

    /**
     * @var string the icon for the view button.
     */
    //public $viewButtonIcon = 'icon-magnifier';
    public $viewButtonIcon = 'fa fa-search';
    public $viewButtonText = 'View';

    /**
     * @var string the icon for the update button.
     */
    public $updateButtonIcon = 'fa fa-pencil';
    public $updateButtonText = 'Update';

    /**
     * @var string the icon for the delete button.
     */
    public $deleteButtonIcon = 'fa fa-trash';
    public $deleteButtonText = 'Delete';
    //public $deleteButtonIcon = 'glyphicon glyphicon-trash';


    /**
     * @var mixed array pager settings or false to disable pager
     */
    public $pageSizeOptions = [20 => 20, 50 => 50];

    /**
     * @var string btn view class
     */
    public $btnViewClass = 'action-view btn btn-primary btn-sm';

    /**
     * @var string btn update class
     */
    public $btnUpdateClass = 'action-update btn btn-info btn-sm';

    /**
     * @var string btn delete class
     */
    public $btnDeleteClass = 'action-delete btn btn-danger btn-sm';


    /**
     * @var mixed filter reset route
     */
    public $routeFilterReset = null;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $view = $this->grid->getView();
        ActionColumnAsset::register($view);
    }

    /**
     * Initializes the default button rendering callbacks.
     */
    protected function initDefaultButtons()
    {
        if (!isset($this->buttons['view'])) {
            $this->buttons['view'] = function ($url, $model, $key,$mode) {
                if(in_array($mode,['_blank','_parent','_self','_top']))
                    return Html::a('<span class="' . $this->viewButtonIcon . '"></span> ' .
                        \Yii::t('common', $this->viewButtonText), $url,[
                        'title' => \Yii::t('yii', 'View'),
                        'target' => $mode,
                        'data-action' => 'view',
                        'data-raw' => '1',
                        //'data-pjax' => '0',
                        'class' => $this->btnViewClass,
                    ]);
                return Html::tag('act','<span class="' . $this->viewButtonIcon . '"></span> ' .
                    \Yii::t('common', $this->viewButtonText), [
                    'title' => \Yii::t('yii', 'View'),
                    'data-method' => 'get',
                    'data-href' => $url!==null?Url::to($url):'',
                    'data-action' => 'view',
                    'data-mode' => $mode,
                    'class' => $this->btnViewClass,
                ]);
            };
        }
        if (!isset($this->buttons['update'])) {
            $this->buttons['update'] = function ($url, $model, $key,$mode) {
                if(in_array($mode,['_blank','_parent','_self','_top']))
                    return Html::a('<span class="' . $this->updateButtonIcon . '"></span> ' .
                        \Yii::t('common', $this->updateButtonText), $url,[
                        'title' => \Yii::t('yii', 'Update'),
                        'target' => $mode,
                        'data-action' => 'update',
                        'data-raw' => '1',
                        'class' => $this->btnViewClass,
                    ]);

                return Html::tag('act','<span class="' . $this->updateButtonIcon . '"></span> ' .
                    \Yii::t('common', $this->updateButtonText), [
                    'title' => \Yii::t('yii', 'Update'),
                    'data-method' => 'get',
                    'data-href' => $url!==null?Url::to($url):'',
                    'data-action' => 'update',
                    'class' => $this->btnUpdateClass,
                ]);
            };
        }
        if (!isset($this->buttons['delete'])) {
            $this->buttons['delete'] = function ($url, $model, $key) {
                return Html::tag('act','<span class="' . $this->deleteButtonIcon . '"></span> ' .
                    \Yii::t('common', $this->deleteButtonText), [
                    'title' => \Yii::t('yii', 'Delete'),
                    'data-confirm' => \Yii::t('yii', 'Are you sure you want to delete this item?'),
                    'data-method' => 'get',
                    'data-href' => $url!==null?Url::to($url):'',
                    'data-pjax' => '0',
                    'data-action' => 'delete',
                    'data-mode' => 'ajax',
                    'class' => $this->btnDeleteClass,
                ]);
            };
        }
    }

    /**
     * @inheritdoc
     */
    /*protected function renderHeaderCellContent()
    {
        if (!$this->routeFilterReset)
        {
            $route = \Yii::$app->controller->getRoute();

            if (!\yii\helpers\StringHelper::startsWith($route, '/'))
            {
                $route = '/'.$route;
            }

            $this->routeFilterReset = [$route];
        }

        return Html::a('<span class="'.$this->resetButtonIcon.'"></span>', $this->routeFilterReset, [
                'title' => \Yii::t('yii', 'Reset filter'),
                'data-pjax' => '0',
        ]);
    }*/

    /**
     * Renders the filter cell content.
     * The default implementation simply renders a space.
     * This method may be overridden to customize the rendering of the filter cell (if any).
     * @return string the rendering result
     */
    protected function renderFilterCellContent()
    {
        if (!$this->pageSizeOptions) {
            return parent::renderFilterCellContent();
        }

        return Html::dropDownList($this->grid->dataProvider->pagination->pageSizeParam, $this->grid->dataProvider->pagination->pageSize, $this->pageSizeOptions);
    }

    /**
     * 重写了标签渲染方法。
     * @param mixed $model
     * @param mixed $key
     * @param int $index
     * @return mixed
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        return preg_replace_callback('/\\{([^}]+)\\}/', function ($matches) use ($model, $key, $index) {
            list($type,$name,$mode) = explode(':', $matches[1] . '::'); // 得到按钮名和类型

            if (empty($type) || !isset($this->buttons[$type])) { // 如果类型不存在 默认为view
                $type = 'view';
            }

            if ('' == $name) { // 名称为空，就用类型为名称
                $name = $type;
            }

            $url = $this->createUrl($name, $model, $key, $index);

            return call_user_func($this->buttons[$type], $url, $model, $key,$mode);
        }, $this->template);

    }
}