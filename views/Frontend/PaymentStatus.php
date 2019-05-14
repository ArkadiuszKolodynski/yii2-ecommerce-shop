<?php
use yii\web\Session;

$session = new Session();
$session->open();
?>

<meta http-equiv="refresh" content="5; url=/" />
<div class="panel">
    <div class="panel-body">
        <h4>Payment <?php echo $error ? 'error' : 'success' ?>!</h4>
        <hr>
    
        <div class="alert <?php echo $error ? 'alert-danger' : 'alert-success' ?>">
            <h3>
                <?php echo $error ? '<i class="glyphicon glyphicon-remove"></i>' : '<i class="glyphicon glyphicon-ok"></i>' ?>
                <strong>Order id: <?php echo $id; ?><?php echo $error ? ' canceled!' : '' ?></strong>
            </h3>
        </div>
    </div>
</div>
