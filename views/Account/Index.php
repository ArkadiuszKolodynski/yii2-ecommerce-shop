<?php
use yii\helpers\Url;
use yii\web\Session;

$session = new Session();
$session->open(); 
?>

<div class="panel">
    <div class="panel-body">
        <h4>Accounts</h4>
        <hr>
        
        <?php if (!empty($session->getFlash('message'))): ?>
        <div class="alert alert-success">
            <i class="glyphicon glyphicon-ok"></i>
            <?php echo $session['message']; ?>
        </div>
        <?php endif; ?>
        
        <a href="<?php echo Url::toRoute('/account/form'); ?>" class="btn btn-primary">
            <i class="glyphicon glyphicon-plus"></i>
            New Record
        </a>
        
        <table style="margin-top: 10px" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="40" style="text-align: right">id</th>
                    <th>username</th>
                    <th width="100" style="text-align: center">level</th>
                    <th width="180">email</th>
                    <th width="110">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($accounts as $account): ?>
                <tr>
                    <td style="text-align: right"><?php echo $account->id; ?></td>
                    <td><?php echo $account->username; ?></td>
                    <td style="text-align: center"><?php echo $account->level; ?></td>
                    <td><?php echo $account->email; ?></td>
                    <td style="text-align: center">
                        <a href="<?php echo Url::toRoute(['/account/update', 'id' => $account->id]); ?>"
                            class="btn btn-success">
                            <i class="glyphicon glyphicon-pencil"></i>
                        </a>
                        <a href="<?php echo Url::toRoute(['/account/delete', 'id' => $account->id]); ?>"
                            class="btn btn-danger" onclick="return confirm('Are you sure to delete this item?')">
                            <i class="glyphicon glyphicon-remove"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
