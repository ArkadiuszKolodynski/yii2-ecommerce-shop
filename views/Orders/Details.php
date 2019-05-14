<?php
use yii\helpers\Url;
?>

<div class="panel">
    <div class="panel-body">   
        <!-- header -->
        <h4>
            <div class="pull-left">Order Detail NO : <?php echo $order->id; ?></div>
            <div class="pull-right">
                <?php if ($order->status === "paid"): ?>
                <span class="label label-success">
                    <i class="glyphicon glyphicon-ok"></i>
                    <?php echo $order->status; ?>
                </span>
                <?php else: ?>
                <span class="label label-danger">
                    <i class="glyphicon glyphicon-hourglass"></i>
                    <?php echo $order->status; ?>
                </span>
                <?php endif; ?>
            </div>
            <div class="clearfix"></div>
        </h4>
        <hr>
        
        <!-- items -->
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width="50" style="text-align: right">no</th>
                    <th width="100" style="text-align: center">code</th>
                    <th>name</th >
                    <th width="80" style="text-align: right">price</th>
                    <th width="80" style="text-align: right">qty</th>
                    <th width="100" style="text-align: right">total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orderDetails as $orderDetail): ?>
                <?php
                $total = ($orderDetail->price * $orderDetail->qty);
                ?>
                <tr>
                    <td style="text-align: right"><?php echo $n++; ?></td>
                    <td style="text-align: center">
                        <?php echo $orderDetail->product->code; ?>
                    </td>
                    <td><?php echo $orderDetail->product->name; ?></td>
                    <td style="text-align: right">
                        <?php echo number_format($orderDetail->price, 2); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo number_format($orderDetail->qty); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo number_format($total, 2); ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <!-- buttons -->
        <div style="text-align: center">
            <a href="<?php echo Url::toRoute('/orders/index'); ?>" class="btn btn-primary">
                <i class="glyphicon glyphicon-chevron-left"></i> 
                Back
            </a>
            <a href="<?php echo Url::toRoute(['/orders/pay', 'id' => $order->id]); ?>" class="btn btn-success">
                <i class="glyphicon glyphicon-ok"></i> 
                Pay
            </a>
            <a href="<?php echo Url::toRoute(['/orders/send', 'id' => $order->id]); ?>" class="btn btn-warning">
                <i class="glyphicon glyphicon-share-alt"></i> 
                Send
            </a>
            <a href="<?php echo Url::toRoute(['/orders/cancel', 'id' => $order->id]); ?>" class="btn btn-danger">
                <i class="glyphicon glyphicon-remove"></i> 
                Cancel
            </a>
        </div>
    </div>
</div>
