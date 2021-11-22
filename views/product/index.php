<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\Models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php  echo $this->render('_search') ?>

    <div class="form-group">
        <p>Показ столбцов:</p>
        <div class="form-check">
            <input data-index="3" class="form-check-input" type="checkbox" value="" id="image-column" checked
                   onclick="toggleColumn(this)">
            <label class="form-check-label" for="image-column">
                IMAGE
            </label>
        </div>
        <div class="form-check">
            <input data-index="4" class="form-check-input" type="checkbox" value="" id="sku-column" checked
                   onclick="toggleColumn(this)">
            <label class="form-check-label" for="sku-column">
                SKU
            </label>
        </div>
        <div class="form-check">
            <input data-index="5" class="form-check-input" type="checkbox" value="" id="title-column" checked
                   onclick="toggleColumn(this)">
            <label class="form-check-label" for="title-column">
                TITLE
            </label>
        </div>
        <div class="form-check">
            <input data-index="6" class="form-check-input" type="checkbox" value="" id="qty-column" checked
                   onclick="toggleColumn(this)">
            <label class="form-check-label" for="qty-column">
                QTY
            </label>
        </div>
        <div class="form-check">
            <input data-index="7" class="form-check-input" type="checkbox" value="" id="type-column" checked
                   onclick="toggleColumn(this)">
            <label class="form-check-label" for="type-column">
                TYPE
            </label>
        </div>
    </div>

    <a class="btn btn-block btn-danger" href="#" onclick="bulkAction();">Удалить</a>

    <?= \app\widgets\BootstrapGridView::widget([
        'dataProvider' => $dataProvider,
        'id'=>'grid',
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],
            ['class' => 'yii\grid\SerialColumn'],
            array(
                'label' => 'image',
                'format' => ['image', ['width'=>'100','height'=>'100']],
                'value'=>function($data) { return \Yii::getAlias('@productImagesUrl') .'/'.$data->image; },
            ),
            'sku',
            'title',
            'qty',
            'type',

            ['class' => 'yii\grid\ActionColumn'],
        ],

    ]); ?>

    <script>
        function bulkAction() {
            const skus = $('#grid').yiiGridView('getSelectedRows');

            $.ajax({
                type: 'POST',
                url : 'product/multiple-delete',
                data : {product_ids: skus},
                success : function() {
                    skus.map( function (dataKey) {
                        $('tr[data-key='+dataKey+']').remove();
                    })
                }
             });
        }

        function toggleColumn(input) {
            const checked = $(input).is(':checked');
            const dataIndex = $(input).data('index');

            if (checked) {
                $('#grid thead tr th:nth-child('+dataIndex+')').show()
                $('#grid tbody tr td:nth-child('+dataIndex+')').show()
            }else {
                $('#grid thead tr th:nth-child('+dataIndex+')').hide()
                $('#grid tbody tr td:nth-child('+dataIndex+')').hide()
            }
        }
    </script>


</div>
