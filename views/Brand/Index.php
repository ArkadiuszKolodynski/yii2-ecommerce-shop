<?php
use yii\helpers\Url;
use yii\web\Session;

$session = new Session ();
$session->open();
?>

<div class=" panel">
    <div class=" panel-body">
        <h4>Categories</h4>
        <hr>
    
        <?php if (!empty($session->getFlash('message'))): ?>
        <div class="alert alert-success">
            <i class="glyphicon glyphicon-ok"></i>
            <?php echo $session['message']; ?>
        </div>
        <?php endif; ?>
    
        <a href="<?php echo Url::toRoute('/brand/form'); ?>" class="btn btn-primary">
            <i class="glyphicon glyphicon-plus"></i>
            New Record
        </a>
    
        <table class="table table-striped table-bordered" style="margin-top: 10px">
            <thead>
                <tr>
                    <th style="text-align: right" width="50">id</th>
                    <th width="100">code</th>
                    <th>name</th>
                    <th>remark</th>
                    <th width="110">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $brand): ?>
                <tr>
                    <td><?php echo $brand->id; ?></td>
                    <td><?php echo $brand->code; ?></td>
                    <td><?php echo $brand->name; ?></td>
                    <td><?php echo $brand->remark; ?></td>
                    <td style="text-align: center">
                        <a href="<?php echo Url::toRoute(['/brand/edit', 'id' => $brand->id]); ?>"
                            class="btn btn-success">
                            <i class="glyphicon glyphicon-pencil"></i>
                        </a>
                        <a href="<?php echo Url::toRoute(['/brand/delete', 'id' => $brand->id]); ?>"
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