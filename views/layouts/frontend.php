<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\web\Session;
use app\models\Company;
use app\models\Brand;
use app\models\Category;
use yii\widgets\ActiveForm;

AppAsset::register($this);

$session = new \yii\web\Session();
$session->open();

$company = Company::find()->one();
$brands = Brand::find()->orderBy('name')->all();
$categories = Category::find()->orderBy('name')->all();;
?>

<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?php echo $company->web_title; ?></title>
    <?php $this->head(); ?>
</head>
<body>

<?php $this->beginBody(); ?>
    <div class="">
        <div class="container">
            <div class="row">
                <div class="pull-left">
                    <h4>
                        <a href="/" style="text-decoration: none;">
                            <!-- logo -->
                            <?php if (!empty($company->logo)): ?>
                            <img src="/uploads/<?php echo $company->logo; ?>" width="40" />
                            <?php endif; ?>
                        
                            <!-- web title -->
                            <?php echo $company->web_title; ?>
                        </a>
                    </h4>
                </div>
                <div class="pull-right">
                    <!-- form login -->
                    <div style="margin-top: 10px">
                        <?php if (empty($session->get('customer_id'))): ?>
                            <a href="<?php echo Url::toRoute('/shop/cart'); ?>" class="btn btn-primary">
                                <i class="glyphicon glyphicon-shopping-cart"></i>
                                <span class="badge">
                                    <?php
                                        $countItemsInCart = 0;
                                        
                                        if (!empty($session->get ('cart'))) {
                                            $countItemsInCart = count($session->get('cart'));
                                        }
                                    ?>
                                    <?php echo $countItemsInCart; ?>
                                </span>
                            </a>
                            <?php $f = ActiveForm::begin([
                                'action' => Url::toRoute('/shop/login'),
                                'options' => [
                                    'class' => 'form-inline',
                                    'style' => 'display: inline;'
                                ]
                            ]); ?>
                            <input type="text" class="form-control" name="username" style="width: 130px" placeholder="Username" required />
                            <input type="password" class="form-control" name="password" style="width: 130px" placeholder="Password" required />
                            <input type="submit" class="btn btn-primary btn-sm" value="Login" />
                            <a class="btn btn-warning btn-sm" href="<?php echo Url::toRoute('/shop/register'); ?>">
                                Register
                                <i class="glyphicon glyphicon-chevron-right"></i>
                            </a>
                            <?php ActiveForm::end(); ?>
                        <?php else: ?>
                            <strong><?php echo $session->get('customer_name'); ?></strong>
                            
                            <a href="<?php echo Url::toRoute('/shop/cart'); ?>" class="btn btn-primary">
                                <i class="glyphicon glyphicon-shopping-cart"></i>
                                <span class="badge">
                                    <?php
                                        $countItemsInCart = 0;
                                        
                                        if (!empty($session->get ('cart'))) {
                                            $countItemsInCart = count($session->get('cart'));
                                        }
                                    ?>
                                    <?php echo $countItemsInCart; ?>
                                </span>
                            </a>
                            <a href="<?php echo Url::toRoute('/shop/history'); ?>" class="btn btn-success">
                                <i class="glyphicon glyphicon-th-list"></i>
                                History
                            </a>
                            <a href="<?php echo Url::toRoute('/shop/profile'); ?>" class="btn btn-primary">
                                <i class="glyphicon glyphicon-user"></i>
                                Profile
                            </a>
                            <a href="<?php echo Url::toRoute('/shop/logout'); ?>" class="btn btn-danger">
                                <i class="glyphicon glyphicon-off"></i>
                                Logout
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="navbar-inverse nav">
            <div class="container">
                <div class="row">
                    <div class="row">
                        <div class="row">
                            <!-- menu -->
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#w0-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <div class="collapse navbar-collapse">
                                <ul class="navbar-nav nav">
                                    <li class="first<?php if (strpos(Url::current(), '/shop/index') !== false) echo ' active'; ?>">
                                        <a href="<?php echo Url::toRoute('/shop/index'); ?>">
                                            Home
                                        </a>
                                    </li>
                                    <li class="dropdown<?php if (strpos(Url::current(), '/shop/categories') !== false) echo ' active'; ?>">
                                        <a href="<?php echo Url::toRoute('/shop/categories'); ?>">
                                            Categories
                                        </a>
                                        <div class="dropdown-menu">
                                        <?php foreach($categories as $category): ?>
                                        <?php if(strpos(Yii::$app->request->url, Url::toRoute('/shop/index')) !== false): ?>
                                            <a class="dropdown-item" href="<?php echo Url::current(['category' => $category->id]) ?>"><?php echo $category->name ?></a><br>
                                        <?php else: ?>
                                            <a class="dropdown-item" href="<?php echo Url::toRoute(['/shop/index', 'category' => $category->id]) ?>"><?php echo $category->name ?></a><br>
                                        <?php endif ?>
                                        <?php endforeach ?>
                                        </div>
                                    </li>
                                    <li class="dropdown<?php if (strpos(Url::current(), '/shop/brands') !== false) echo ' active'; ?>">
                                        <a href="<?php echo Url::toRoute('/shop/brands'); ?>">
                                            Brands
                                        </a>
                                        <div class="dropdown-menu">
                                        <?php foreach($brands as $brand): ?>
                                        <?php if(strpos(Yii::$app->request->url, Url::toRoute('/shop/index')) !== false): ?>
                                            <a class="dropdown-item" href="<?php echo Url::current(['brand' => $brand->id]) ?>"><?php echo $brand->name ?></a><br>
                                        <?php else: ?>
                                            <a class="dropdown-item" href="<?php echo Url::toRoute(['/shop/index', 'brand' => $brand->id]) ?>"><?php echo $brand->name ?></a><br>
                                        <?php endif ?>
                                        <?php endforeach ?>
                                        </div>
                                    </li>
                                    <li class="<?php if (strpos(Url::current(), '/shop/about') !== false) echo 'active'; ?>">
                                        <a href="<?php echo Url::toRoute('/shop/about'); ?>">
                                            About
                                        </a>
                                    </li>
                                    <li class="<?php if (strpos(Url::current(), '/shop/payment') !== false) echo 'active'; ?>">
                                        <a href="<?php echo Url::toRoute('/shop/payment'); ?>">
                                            Payment
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- Content -->
    <div class="container" style="margin-top: 10px">
        <div class="row">
            <?php echo $content; ?>
        </div>
    </div>
</div>

<!-- footer -->
<div style="color: #fff; background: #222; padding-top: 20px; padding-bottom: 20px">
    <div class="container">
        <div class="row">
            <div><?php echo $company->name; ?></div>
            <div>Tel: <?php echo $company->tel; ?></div>
            <div>Website: <?php echo $company->website; ?></div>
            <div>Email: <?php echo $company->email; ?></div>
            <div><?php echo $company->address; ?></div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
