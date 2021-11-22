<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\Models\ProductSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="country-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="form-group field-productsearch">
        <label class="control-label" for="productsearch">Поиск</label>

        <?php $search_query = isset($_GET['query']) ? Html::encode($_GET['query']) : ''; ?>
        <input value="<?= $search_query ?>" type="text" id="productsearch"
               class="form-control"
               name="query">
        <div class="help-block"></div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
