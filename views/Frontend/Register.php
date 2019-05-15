<?php
use yii\widgets\ActiveForm;
?>

<div class="panel">
    <div class="panel-body">
        <h4>Register</h4>
        <hr>
        
        <?php $f = ActiveForm::begin(); ?>
        <?php
        echo $f->field($customer, 'username');
        echo $f->field($customer, 'password')->passwordInput();
        echo $f->field($customer, 'email')->input('email');
        echo $f->field($customer, 'first_name');
        echo $f->field($customer, 'last_name');
        echo $f->field($customer, 'address');
        echo $f->field($customer, 'city');
        echo $f->field($customer, 'zipcode');
        echo $f->field($customer, 'tel');
        ?>
        
        <div class="form-group">
            <input type="submit" value="Register" class="btn btn-primary" />
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
