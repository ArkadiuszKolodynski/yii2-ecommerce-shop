<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>

<div class="panel">
    <div class="panel-body">
        <h4>
            <i class="<?php echo $icon; ?>"></i>
            <?php echo $title; ?>
        </h4>
        <hr>
        
        <?php $f = ActiveForm::begin(['action' => Url::toRoute('/category/form')]); ?>
        <?= $f->field($category, 'code'); ?>
        <?= $f->field($category, 'name'); ?>
        <?= $f->field($category, 'remark'); ?>
        <?= $f->field($category, 'id')->hiddenInput()->label(false); ?>
        
        <div class="form-group">
            <input type="submit" value="Save" class="btn btn-primary">
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
