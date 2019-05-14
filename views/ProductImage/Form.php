<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>

<div class="panel">
    <div class="panel-body">
        <h4>Product Image > <?php echo $product->name; ?></h4>
        <hr>

        <?php $f = ActiveForm::begin([
            'action' => Url::toRoute(['/product-image/form', 'product_id' => $product->id]),
            'options' => [
                'enctype' => 'multipart/form-data'
            ]
        ]); ?>
        <?= $f->field($productImage, 'name'); ?>
        <?= $f->field($productImage, 'url')->fileInput(['value' => $productImage->url]); ?>
    
        <div class="form-group">
            <input type="submit" value="Save" class="btn btn-primary">
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
