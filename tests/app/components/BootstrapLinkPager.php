<?php

namespace app\components;

use Yii;
use yii\helpers\Html;
use yii\widgets\LinkPager;

class BootstrapLinkPager extends LinkPager
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // In Bootstrap 4 no div's "next" and "prev", so you need to overwrite the default values
        $this->prevPageCssClass = 'page-item';
        $this->nextPageCssClass = 'page-item';

        // Change the location and size of block
        // https://v4-alpha.getbootstrap.com/components/pagination/#alignment
        // https://v4-alpha.getbootstrap.com/components/pagination/#sizing
        $this->options['class'] = 'pagination justify-content-center';

        // Change standard arrows "«" and "»"
//        $this->nextPageLabel = Yii::t('app', 'Next');
//        $this->prevPageLabel = Yii::t('app', 'Previous');

        // Default div for links
        $this->linkOptions['class'] = 'page-link';
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->registerLinkTags) {
            $this->registerLinkTags();
        }

        if ($this->pagination->getPageCount() > 1) {
            echo Html::tag('nav', $this->renderPageButtons());
        }
    }

    /**
     * @inheritdoc
     */
    protected function renderPageButton($label, $page, $class, $disabled, $active)
    {
        $options = ['class' => empty($class) ? 'page-item' : $class];
        $linkOptions = $this->linkOptions;

        if ($active) {
            Html::addCssClass($options, $this->activePageCssClass);
        }

        if ($disabled) {
            Html::addCssClass($options, $this->disabledPageCssClass);
            $linkOptions['tabindex'] = '-1';
        }

        return Html::tag('li', Html::a($label, $this->pagination->createUrl($page), $linkOptions), $options);
    }
}