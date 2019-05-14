<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\Company;
use yii\web\Session;

AppAsset::register($this);

$session = new \yii\web\Session();
$session->open();

$company = Company::find()->one();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?php echo $company->web_title; ?> Administration</title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <div class="navbar-inverse navbar-fixed-top navbar" style="padding-right: 20px">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#w0-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo Url::toRoute('/backend/home'); ?>">
                <?php echo $company->web_title; ?>
            </a>
        </div>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav navbar-right nav">
                <?php if (!empty($session['account_id'])): ?>
                <li>
                    <a href="<?php echo Url::toRoute('/orders/index'); ?>">
                        Orders
                    </a>
                </li>
                <li>
                    <a href="<?php echo Url::toRoute('/category/index'); ?>">
                        Categories
                    </a>
                </li>
                <li>
                    <a href="<?php echo Url::toRoute('/brand/index'); ?>">
                        Brands
                    </a>
                </li>
                <li>
                    <a href="<?php echo Url::toRoute('/product/index'); ?>">
                        Products
                    </a>
                </li>
                <li>
                    <a href="<?php echo Url::toRoute('/customer/index'); ?>">
                        Customers
                    </a>
                </li>
                <li>
                    <a href="<?php echo Url::toRoute('/report/index'); ?>">
                        Reports
                    </a>
                </li>
                <li>
                    <a href="<?php echo Url::toRoute('/account/index'); ?>">
                        Accounts
                    </a>
                </li>
                <li>
                    <a href="<?php echo Url::toRoute('/company/index'); ?>">
                        Company Info
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <div class="container">
        <div class="row" style="text-align: right; margin-bottom: 10px;">
            <?php if (!empty($session['account_id'])): ?>
                <strong style="color: #fff;">
                    <?php echo $session['account_username']; ?>
                </strong>
                <a href="<?php echo Url::toRoute('/account/edit'); ?>" class="btn btn-primary">
                    <i class="glyphicon glyphicon-cog"></i>
                    Edit
                </a>
                <a href="<?php echo Url::toRoute('/backend/logout'); ?>" class="btn btn-danger">
                    <i class="glyphicon glyphicon-off"></i>
                    Logout
                </a>
            <?php endif; ?>
        </div>

        <div class="row">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Ecommerce <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
