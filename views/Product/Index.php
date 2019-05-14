<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\web\Session;

$session = new Session();
$session->open();
?>

<div class="panel">
    <div class="panel-body">
        <h4>Products</h4>
        <hr>
        
        <?php if (!empty($session->getFlash('message'))): ?>
        <div class="alert alert-success">
            <i class="glyphicon glyphicon-ok"></i>
            <?php echo $session['message']; ?>
        </div>
        <?php endif; ?>
        <a href="<?php echo Url::toRoute('/product/form'); ?>" class="btn btn-primary">
            <i class="glyphicon glyphicon-plus"></i>
            New Record
        </a>
        
        <table class="table table-striped table-bordered" style="margin-top: 10px">
            <thead>
                <tr>
                    <th width="40" style="text-align: right">id</th>
                    <th width="130">barcode</th>
                    <th>name</th>
                    <th>category</th>
                    <th>brand</th>
                    <th width="80" style="text-align: right">price</th>
                    <th width="80" style="text-align: right">costs</th>
                    <th width="50" style="text-align: right">qty</th>
                    <th width="150"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td style="text-align: right"><?php echo $product->id; ?></td>
                    <td><?php echo $product->code; ?></td>
                    <td><?php echo $product->name; ?></td>
                    <td><?php echo $product->category->name; ?></td>
                    <td><?php echo $product->brand->name; ?></td>
                    <td style="text-align: right">
                        <?php echo number_format($product->price,2); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo number_format($product->cost,2); ?>
                    </td>
                    <td style="text-align: right"><?php echo $product->qty; ?>
                    <td style="text-align: center">
                        <a href="<?php echo Url::toRoute(['/product-image/index', 'product_id' => $product->id]); ?>"
                            class="btn btn-info">
                            <i class="glyphicon glyphicon-picture"></i>
                        </a>
                        <a href="<?php echo Url::toRoute(['/product/edit', 'id' => $product->id]); ?>"
                            class="btn btn-success">
                            <i class="glyphicon glyphicon-pencil"></i>
                        </a>
                        <a href="<?php echo Url::toRoute(['/product/delete', 'id' => $product->id]); ?>"
                            class="btn btn-danger" onclick="return confirm ('Are you sure delete date?')">
                            <i class="glyphicon glyphicon-remove"></i>
                        </a>
                    </td>
                </tr>
            </tbody>
            <?php endforeach; ?>
        </table>
        
        <?php echo LinkPager::widget([
            'pagination' => $pages,
          ]);
        ?>
    </div>
</div>
