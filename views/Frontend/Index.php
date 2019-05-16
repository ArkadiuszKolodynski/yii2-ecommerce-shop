<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
use app\models\Brand;
use app\models\Category;
?>

<?php if($wrongPassword === 'true'): ?>
<div class="alert alert-danger alert-dismissible">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>Wrong password!</strong>
</div>
<?php endif ?>

<div style="margin-bottom: 10px">
    <div class="pull-left">
    
        <a href="<?php echo Url::current(['sort' => 'box']); ?>" class="btn btn-primary" title="Display grid">
            <i class="glyphicon glyphicon-th"></i>
        </a>
        <a href="<?php echo Url::current(['sort' => 'list']); ?>" class="btn btn-primary" title="Display list">
            <i class="glyphicon glyphicon-th-list"></i>
        </a>
    </div>
    <div class=" pull-right">
        <?php ActiveForm::begin([
            'action' => Url::toRoute('/shop/index'),
            'method' => 'get',
            'options' => [
                'class' => 'form-inline',
                'name' => 'formProduct'
            ]
        ]); ?>
        <input type="text" name="search" class="form-control" placeholder="Search..." />
        <a class="btn btn-primary" onclick="document.formProduct.submit()">
            <i class="glyphicon glyphicon-search"></i>
        </a>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="clearfix"></div>
</div>
<div class="panel">
<?php if (!empty($_GET['category'])): ?>
    <?php $categoryFilter = Category::findOne($_GET['category']) ?>
    <a class="btn btn-danger" href="<?php echo Url::current(['category' => null]) ?>">
        <?php echo $categoryFilter->name ?> <i class="glyphicon glyphicon-remove"></i>
    </a>
<?php endif ?>
<?php if (!empty($_GET['brand'])): ?>
    <?php $brandFilter = Brand::findOne($_GET['brand']) ?>
    <a class="btn btn-danger" href="<?php echo Url::current(['brand' => null]) ?>">
        <?php echo $brandFilter->name ?> <i class="glyphicon glyphicon-remove"></i>
    </a>
<?php endif ?>
<?php if ($brand !== null) echo '
<nav aria-label="breadcrumb" style="font-size: 20px">
  <ol class="breadcrumb">
    <li class="breadcrumb-item" aria-current="page"><a href="'.Url::toRoute(['/shop/brands']).'">Brands</a></li>
    <li class="breadcrumb-item active" aria-current="page">'.$brand->name.'</li>
  </ol>
</nav>' ?>
<?php if ($category !== null) echo '
<nav aria-label="breadcrumb" style="font-size: 20px">
  <ol class="breadcrumb">
    <li class="breadcrumb-item" aria-current="page"><a href="'.Url::toRoute(['/shop/categories']).'">Categories</a></li>
    <li class="breadcrumb-item active" aria-current="page">'.$category->name.'</li>
  </ol>
</nav>' ?>
    <div class="panel-body text-center">
    <?php if (empty($products)): ?>
    <h2>No products found!</h2>
    <?php else: ?>
    <?php foreach ($products as $product): ?>
        <?php if ($sort == 'box'): ?>
        <!-- display box -->
        <div class="col-md–3 col-sm-4 col-xs-6">
            <div class="panel" style="height: 300px; text-align: center">
                <div>
                    <a href="<?php echo Url::toRoute(['/shop/productview', 'id' => $product->id]); ?>">
                        <img src="/uploads/<?php echo $product->img; ?>" alt="<?php echo $product->name; ?>" width="200" height="130" />
                    </a>
                </div>
                <div style="min-height: 30px">
                    <a href="<?php echo Url::toRoute(['/shop/productview', 'id' => $product->id]); ?>">
                        <h5><?php echo $product->name; ?></h5>
                    </a>
                </div>
                <div style="text-align: center">
                    <h4><?php echo number_format($product->price, 2); ?> PLN</h4>
                </div>
                <div style="text-align: center">
                    <a href="<?php echo Url::toRoute(['/shop/cart', 'id' => $product->id]); ?>" class="btn btn-success">
                        <i class="glyphicon glyphicon-plus"></i>
                        Add to Cart
                    </a>
                </div>
            </div>
        </div>
        <?php else: ?>
        <!-- display list -->
        <div class="col-md-12">
                <div class="col-md–3" style="padding-top: 5px; padding-bottom: 5px; margin-bottom: 20px;">
                    <a href="<?php echo Url::toRoute(['/shop/productview', 'id' => $product->id]); ?>">
                        <img src="/uploads/<?php echo $product->img; ?>" alt="<?php echo $product->name; ?>" width="200" height="130" />
                    </a>
                </div>
                <div class="col-md–6">
                    <a href="<?php echo Url::toRoute(['/shop/productview', 'id' => $product->id]); ?>">
                        <h5><?php echo $product->name; ?></h5>
                    </a>
                </div>
                <div class="col-md–3">
                    <h4><?php echo number_format($product->price, 2); ?> PLN</h4>
                </div>
                <div>
                    <a href="<?php echo Url::toRoute(['/shop/cart', 'id' => $product->id]); ?>" class="btn btn-success">
                        <i class="glyphicon glyphicon-plus"></i>
                        Add to Cart
                    </a>
                </div>
                <hr>
        </div>
        <?php endif; ?>
    <?php endforeach; ?>
    <?php endif ?>
    </div>
    <div class="text-center">Total count: <strong><?php echo $totalCount; ?></strong></div>
    <hr>
    <div style="text-align: center">
    <?php if (!empty($_GET['brand']) || !empty($_GET['category'])): ?>
        <?php echo LinkPager::widget([
            'pagination' => $pagination, 
        ]);
        ?>
    <?php endif ?>
    </div>
</div>
