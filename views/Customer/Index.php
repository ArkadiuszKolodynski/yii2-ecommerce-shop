<?php
use yii\widgets\LinkPager;
?>

<div class="panel">
    <div class="panel-body">
        <h4>Customers</h4>
        <hr>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width="50" style="text-align: right">id</th>
                    <th width="200">username</th>
                    <th>email</th>
                    <th>first name</th>
                    <th>last name</th>
                    <th>address</th>
                    <th>city</th>
                    <th>zipcode</th>
                    <th>tel</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $customer): ?>
                <tr>
                    <td styel="text-align: right"><?php echo $customer->id; ?></td>
                    <td><?php echo $customer->username; ?></td>
                    <td><?php echo $customer->email; ?></td>
                    <td><?php echo $customer->first_name; ?></td>
                    <td><?php echo $customer->last_name; ?></td>
                    <td><?php echo $customer->address; ?></td>
                    <td><?php echo $customer->city; ?></td>
                    <td><?php echo $customer->zipcode; ?></td>
                    <td><?php echo $customer->tel; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <?php echo LinkPager::widget([
            'pagination' => $pages,
        ]);
        ?>
    </div>
</div>
