<?php

namespace app\widgets;

class BootstrapLinkPager extends \yii\widgets\LinkPager
{

    /**
     * @var array HTML attributes for the link in a pager container tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $linkOptions = ['class' => 'page-link'];

    public $disabledPageCssClass = 'disabled page-link';

}