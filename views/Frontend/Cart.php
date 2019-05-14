<?php
use yii\helpers\Url;
use yii\web\Session;
use yii\widgets\ActiveForm;

$session = new Session();
$session->open();
?>

<div class="panel">
    <div class="panel-body">
        <?php if (!empty($product)): ?>
        <h4><i class="glyphicon glyphicon-plus"></i> Add to Cart</h4>
        
        <?php $f = ActiveForm::begin(['options' => ['name' => 'formAddToCart']]); ?>
        <table style="margin-bottom: 50px" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width="100">code</th>
                    <th>name</th>
                    <th width="100" style="text-align: right">price</th>
                    <th width="80" style="text-align: right">qty</th>
                    <th width="40">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $product->code; ?></td>
                    <td>
                        <a href="<?php echo Url::toRoute(['/shop/productview', 'id' => $product->id]); ?>"><?php echo $product->name; ?></a>
                    </td>
                    <td style="text-align: right">
                        <?php echo number_format($product->price, 2); ?>
                    </td>
                    <td>
                        <input type="text" class="form-control" name="qty" value="1" style="text-align: right" />
                    </td>
                    <td>
                        <a href="javascript: void(0)."
                          onclick="document.formAddToCart.submit()"
                          class="btn btn-primary">
                            <i class="glyphicon glyphicon-plus"></i>
                            Add
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php ActiveForm::end(); ?>
        <?php endif; ?>

        <h4>
            <i class="glyphicon glyphicon-shopping-cart"></i>
            Items in Cart
        </h4>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width="40" style="text-align: right">no</th>
                    <th width="100">code</th>
                    <th>name</th>
                    <th width="100" style="text-align: right">price</th>
                    <th width="80" style="text-align: right">qty</th>
                    <th width="120" style="text-align: right">total</th>
                    <th width="40">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $c): ?>
                <?php
                $sumQty += $c['qty'];
                $sumPrice += ($c['qty'] * $c['price']);
                ?>
                <tr>
                    <td style="text-align: right">
                        <?php echo $n++; ?>
                    </td>
                    <td><?php echo $c['code']; ?></td>
                    <td>
                        <a href="<?php echo Url::toRoute(['/shop/productview', 'id' => $c['id']]); ?>"><?php echo $c['name']; ?></a>
                    </td>
                    <td style="text-align: right">
                        <?php echo number_format($c['price'], 2); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo number_format($c['qty']); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo number_format($c['qty'] * $c['price'], 2); ?>
                    </td>
                    <td style="text-align: center">
                        <?php
                        $product_id = null;
                        
                        if (!empty($product)) {
                            $product_id = $product->id;
                        }
                        ?>
                        <a href="<?php echo Url::toRoute(['/shop/cartremove', 'index' => $n - 2, 'id' => $product_id]); ?>" class="btn btn-danger btn-sm">
                            <i class="glyphicon glyphicon-remove"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4"><strong>Total</strong></td>
                    <td style="text-align: right"><?php echo $sumQty; ?></td>
                    <td style="text-align: right">
                        <?php echo number_format($sumPrice, 2); ?>
                    </td>
                </tr>
            </tfoot>
        </table>
        <div style="text-align: center">
            <a href="<?php echo Url::toRoute('/shop/index'); ?>" class="btn btn-primary btn-lg">
                <i class="glyphicon glyphicon-chevron-left"></i>
                Shopping
            </a>
            <a href="<?php echo Url::toRoute('/shop/checkout'); ?>" class="">
                <button class="btn btn-success btn-lg"<?php if (empty($cart)) echo 'disabled'; ?>>Check Out
                <i class="glyphicon glyphicon-chevron-right"></i>
                </button>
            </a>
        </div>
    </div>
</div>
