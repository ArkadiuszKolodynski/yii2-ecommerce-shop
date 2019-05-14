<?php
use yii\helpers\Url;
use yii\web\Session;

$session = new Session();
$session->open();
?>

<div class="panel">
    <div class="panel-body">
        <h4>Product Images</h4>
        <hr>
        
        <div class=" pull-left">
            <!-- product info -->
            <div>
                <?php echo $product->code; ?> :
                <?php echo $product->name; ?>
            </div>
            
            <!-- flash message -->
            <?php if (!empty($session->getFlash('message'))): ?>
            <div class="alert alert-success">
                <i class="glyphicon glyphicon-ok"></i>
                <?php echo $session['message']; ?>
            </div>
            <?php endif; ?>
            
            <div style="margin-top: 20 px">
                <!-- button -->
                <a href="<?php echo Url::toRoute(['/product-image/form', 'product_id' => $product->id]); ?>"
                    class="btn btn-primary">
                    <i class="glyphicon glyphicon-plus"></i>
                    New Image
                </a>
                
                <!-- image of product -->
                <table class="table table-striped table-bordered" style="margin-top: 10px">
                    <thead>
                        <tr>
                            <th width="40" style="text-align: right">no</th>
                            <th>images</th>
                            <th width="300">name</th>
                            <th width="40">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productImages as $productImage): ?>
                        <tr>
                            <td style="text-align: right"><?php echo $n++; ?></td>
                            <td><img src="/uploads/<?php echo $productImage->url; ?>" width="150" /></td>
                            <td><?php echo $productImage->name; ?></td>
                            <td style="text-align: center">
                                <a href="<?php echo Url::toRoute(['/product-image/delete', 'id' => $productImage->id]); ?>"
                                    onclick="return confirm('Are you sure to delete this item?')"
                                    class="btn btn-danger">
                                    <i class="glyphicon glyphicon-remove"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="pull-right">
            <?php if (!empty($product->img)): ?>
            <img src="/uploads/<?php echo $product->img; ?>" width="250" />
            <?php endif; ?>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
