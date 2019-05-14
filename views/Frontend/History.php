<?php
use app\models\OrderDetails;
?>

<div class="panel">
    <div class="panel-body">
        <h3>
            <i class="glyphicon glyphicon-th-list"></i>
            History
        </h3>
        <hr>
        
        <?php foreach ($orders as $order): ?>
        <h4>
            <?php echo $order->created_at; ?> : 
            <?php echo $order->status; ?>
        </h4>
        <table style="margin-bottom: 50px" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="40" style="text-align: right">no</th>
                    <th width="100">code</th>
                    <th>name</th>
                    <th width="80" style="text-align: right">price</th>
                    <th width="80" style="text-align: right">qty</th>
                    <th width="100" style="text-align: right">total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $orderDetails = OrderDetails::find()
                  ->where(['order_id' => $order->id])
                  ->orderBy('id DESC')->all();
                $n = 1;
                ?>
                
                <?php foreach ($orderDetails as $orderDetail): ?>
                <?php
                $total = ($orderDetail->price * $orderDetail->qty);
                $sumQty += $orderDetail->qty;
                $sumPrice += $total;
                ?>
                <tr>
                    <td style="text-align: right"><?php echo $n++; ?></td>
                    <td><?php echo $orderDetail->product->code; ?></td>
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
            <tfoot>
                <tr>
                    <td colspan="4"><strong>Total</strong></td>
                    <td style="text-align: right">
                        <?php echo number_format($sumQty); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo number_format($sumPrice, 2); ?>
                    </td>
                </tr>
            </tfoot>
        </table>
        <?php endforeach; ?>
    </div>
</div>
