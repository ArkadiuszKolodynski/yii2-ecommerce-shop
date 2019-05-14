<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\web\Session;

$session = new Session();
$session->open();
?>

<div class="panel">
    <div class="panel-body">
        <h4>
            <i class="<?php echo $icon; ?>"></i>
            <?php echo $title; ?>
        </h4>
        <hr>
        
        <?php if (!empty($session->getFlash('message'))): ?>
        <div class="alert alert-success">
            <i class="glyphicon glyphicon-ok"></i>
            <?php echo $session['message']; ?>
        </div>
        <?php endif; ?>
        
        <?php $f = ActiveForm::begin(['action' => Url::toRoute('/account/form')]); ?>
        <?php
        echo $f->field($account, 'level')->dropdownList(['Select...', 'admin', 'manager',
          'user'], ['prompt' => $account->level, 'style' => 'width: 200px']);
        echo $f->field($account, 'name');
        echo $f->field($account, 'username');
        echo $f->field($account, 'password')->passwordInput(['value' => '']);
        echo $f->field($account, 'email')->input('email');
        echo $f->field($account, 'id')->hiddenInput()->label(false);
        ?>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Save">
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
