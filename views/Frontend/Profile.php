<?php
use yii\widgets\ActiveForm;
use yii\web\Session;

$session = new Session();
$session->open();
?>

<div class="panel">
    <div class="panel-body">
        <h4>Profile</h4>
        <hr>
        
        <!-- flash message -->
        <?php if (!empty($session->getFlash('message'))): ?>
        <div class="alert alert-success">
            <i class="glyphicon glyphicon-ok"></i>
            <?php echo $session['message']; ?>
        </div>
        <?php endif; ?>
        
        <!-- form -->
        <?php $f = ActiveForm::begin(); ?>
        <?php
        echo $f->field($customer, 'username');
        echo $f->field($customer, 'password')->passwordInput(['value' => '']);
        echo $f->field($customer, 'email')->input('email');
        echo $f->field($customer, 'first_name');
        echo $f->field($customer, 'last_name');
        echo $f->field($customer, 'address');
        echo $f->field($customer, 'city');
        echo $f->field($customer, 'zipcode');
        echo $f->field($customer, 'tel');
        ?>
        
        <div class="control-group">
            <input type="submit" class="btn btn-primary" value="Save" />
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
