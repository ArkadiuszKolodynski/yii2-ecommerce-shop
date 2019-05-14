<?php
use yii\helpers\Url;
?>

<div class="panel">
    <div class="panel-body">
        <h4>
            <?php echo $product->category->name; ?>
            <i class="glyphicon glyphicon-chevron-right"></i>
            (<?php echo $product->code; ?>)
            <?php echo $product->name; ?>
        </h4>
        
        <!-- product info -->
        <div class="col-md-12">
            <div class="col-md–3" style="display: inline-block;">
                <?php if (!empty($product->img)): ?>
                    <img src="/uploads/<?php echo $product->img; ?>" width="200" />
                <?php endif; ?>
            </div>
            <div class="col-md-9" style="display: inline-block;">
                <div><?php echo $product->detail; ?></div>
                <?php if (!empty($product->remark)): ?>
                    <div class="alert alert–info" style="margin-top: 10px; ">
                        <i class="glyphicon glyphicon-ok"></i>
                        <?php echo $product->remark; ?>
                    </div>
                <?php endif; ?>
                <div>
                    <h4 style="color: #407A52">
                        <?php echo number_format($product->price, 2); ?> PLN
                    </h4>
                </div>
                <div>
                    <a href="<?php echo Url::toRoute(['/shop/cart', 'id' => $product->id]); ?>" class="btn btn-success">
                        <i class="glyphicon glyphicon-plus"></i>
                        Add to Cart
                    </a>
                </div>
            </div>
        </div>
        
        <!-- image of product -->
        <div class="col-md-12" style="margin-top: 50px">
            <?php echo $productImages ? '<h2>Gallery</h2>' : null; ?>
            <div class="row">
                <div class="row">
                    <?php foreach ($productImages as $productImage): ?>
                    <div class="col-md–3" style="display: inline-block;">
                        <div class="panel panel-primary">
                            <div class="panel-heading"><?php echo $productImage->name; ?></div>
                            <div class="panel-body">
                                <img src="/uploads/<?php echo $productImage->url; ?>" width="250" height="170" />
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
