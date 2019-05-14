<?php
use yii\widgets \ActiveForm;
?>

<div class="panel">
    <div class="panel-body">
        <h4>Income Report</h4>
        <hr>
        
        <!-- filter -->
        <?php $f = ActiveForm::begin(['options' => [
            'class' => 'form-inline',
            'name' => 'formReport'
        ]]);
        ?>
        
        <label>Year</label>
        <select name="year" class="form-control">
            <?php foreach ($year_list as $year): ?>
            <option value="<?php echo $year; ?>"
                <?php if ($y === $year): ?>
                    selected
                <?php endif; ?>
            >
                <?php echo $year; ?>
            </option>
            <?php endforeach; ?>
        </select>

        <label style="width: 80px; text-align: right">Month</label>
        <select name="month" class="form-control ">
            <?php foreach ($month_list as $month): ?>
            <option value="<?php echo $month; ?>"
                <?php if ($m === $month): ?>
                    selected
                <?php endif; ?>
            >
                <?php echo $month; ?>
            </option>
            <?php endforeach; ?>
        </select>
        <a href="javascript: void(0)" onclick="document.formReport.submit()" class="btn btn-primary">
            Show Data
        </a>

        <?php ActiveForm::end(); ?>
        
        <!-- data -->
        <table style="margin-top: 20px" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <td width="40" style="text-align: right">no</td>
                    <td width="80">order no</td>
                    <td width="30">day</td>
                    <td width="20">customer id</td>
                    <td width="200">full name</td>
                    <td width="150">tel</td>
                    <td>product</td>
                    <td width="80" style="text-align: right">price</td>
                    <td width="70" style="text-align: right">qty</td>
                    <td width="90" style="text-align: right">total</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach($orderDetails as $orderDetail): ?>
                <?php
                $d = $orderDetail->order->pay_date;
                $d = explode(' ', $d);
                $d = explode('-', $d[0]);
                $d = $d[2];
                ?>
                <tr>
                    <td style="text-align: right"><?php echo $n++; ?></td>
                    <td><?php echo $orderDetail->order_id; ?></td>
                    <td><?php echo $d; ?></td>
                    <td><?php echo $orderDetail->order->customer_id; ?></td>
                    <td><?php echo $orderDetail->order->first_name; ?> <?php echo $orderDetail->order->last_name; ?></td>
                    <td><?php echo $orderDetail->order->tel; ?></td>
                    <td><?php echo $orderDetail->product->name; ?></td>
                    <td style="text-align: right">
                        <?php echo number_format($orderDetail->price, 2); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo number_format($orderDetail->qty); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo number_format($orderDetail->price * $orderDetail->qty, 2); ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
