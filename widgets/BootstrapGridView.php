<?php

namespace app\widgets;

use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\widgets\BootstrapLinkPager;

class BootstrapGridView extends GridView
{

    public function renderPager()
    {
        $pagination = $this->dataProvider->getPagination();
        if ($pagination === false || $this->dataProvider->getCount() <= 0) {
            return '';
        }
        /* @var $class BootstrapLinkPager */
        $pager = $this->pager;
        $class = ArrayHelper::remove($pager, 'class', BootstrapLinkPager::className());
        $pager['pagination'] = $pagination;
        $pager['view'] = $this->getView();

        return $class::widget($pager);
    }

}