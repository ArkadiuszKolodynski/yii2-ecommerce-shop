<?php
use yii\helpers\Url;
?>

<div class="panel">
    <nav aria-label="breadcrumb" style="font-size: 20px">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Categories</li>
        </ol>
    </nav>
    <div class="panel-body">
        <div class="list-group">
            <?php foreach($categories as $category): ?>
            <a href="<?php echo Url::toRoute(['/shop/categories', 'id' => $category->id]) ?>" class="list-group-item list-group-item-info"><?php echo $category->name; ?></a>
            <?php endforeach ?>
        </div>
    </div>
</div>
