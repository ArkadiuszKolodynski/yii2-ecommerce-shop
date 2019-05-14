<?php
use yii\helpers\Url;
?>

<div class="panel">
    <div class="panel-body">
        <h4>Orders</h4>
        <hr>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width="50" style="text-align: right">id</th>
                    <th width="80" style="text-align: center"></th>
                    <th>customer id</th>
                    <th>full name</th>
                    <th width="150" style="text-align: center">tel</th>
                    <th width="150" style="text-align: center">created date</th>
                    <th width="100" style="text-align: center">status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td style="text-align: right"><?php echo $order->id; ?></td>
                    <td style="text-align: center">
                        <a class="btn btn-primary btn-sm" style="width: 100%" href="<?php echo Url::toRoute(['/orders/details', 'id' => $order->id]); ?>">
                            details
                        </a>
                    </td>
                    <td><?php echo $order->customer_id; ?></td>
                    <td><?php echo $order->first_name; ?> <?php echo $order->last_name; ?></td>
                    <td style="text-align: center"><?php echo $order->tel; ?></td>
                    <td style="text-align: center"><?php echo $order->created_at; ?></td>
                    <td style="text-align: center">
                        <?php if ($order->status === "paid"): ?>
                        <div class="label label-success">
                            <i class="glyphicon glyphicon-ok"></i>
                            <?php echo $order->status; ?>
                        </div>
                        <?php else: ?>
                            <?php echo $order->status; ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
