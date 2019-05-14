<?php
use yii\helpers\Url;
?>

<div class="panel">
    <nav aria-label="breadcrumb" style="font-size: 20px">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Brands</li>
        </ol>
    </nav>
    <div class="panel-body">
    <div class="list-group">
            <?php foreach($brands as $brand): ?>
            <a href="<?php echo Url::toRoute(['/shop/brands', 'id' => $brand->id]) ?>" class="list-group-item list-group-item-info"><?php echo $brand->name; ?></a>
            <?php endforeach ?>
        </div>
    </div>
</div>
