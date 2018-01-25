<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

AppAsset::register($this);

// $this->title = 'Главная - Админ панель';

$this->registerJsFile(
    '@web/js/login.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->title; ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<!-- Main navbar -->
<div class="navbar navbar-inverse bg-indigo">
    <div class="navbar-header">
        <a class="navbar-brand" href="index.html"></a>
        <ul class="nav navbar-nav visible-xs-block">
            <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
            <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
        </ul>
    </div>

    <div class="navbar-collapse collapse" id="navbar-mobile">
        <ul class="nav navbar-nav">
            <li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
        </ul>

        <div class="navbar-right">
            <p class="navbar-text">Здравствуйте, <?= Yii::$app->user->identity->username; ?></p>
            <p class="navbar-text"><a href="<?= Url::to(['site/logout']); ?>" id="logout" style="color: #fff"><i class="icon-switch2"></i><span>Выйти</span></a></p>
        </div>
    </div>
</div>
<!-- /main navbar -->

<!-- Page container -->
<div class="page-container">

    <!-- Page content -->
    <div class="page-content">

        <!-- Main sidebar -->
        <div class="sidebar sidebar-main sidebar-default">
            <div class="sidebar-content">

                <!-- User menu -->
                <div class="sidebar-user-material">
                    <div class="category-content">
                        <div class="sidebar-user-material-content">
                            <a href="#">
                                <?= Html::img('@backweb/images/logo.png', ['class' => 'img-responsive']); ?>
                            </a>
                            <h6><?= Yii::$app->user->identity->username; ?></h6>
                            <span class="text-size-small">Администратор</span>
                        </div>

                        <div class="sidebar-user-material-menu">
                            <a href="#user-nav" data-toggle="collapse"><span>Мой аккаунт</span> <i class="caret"></i></a>
                        </div>
                    </div>

                    <!-- csrf token -->
                    <?= Html :: hiddenInput(Yii::$app->getRequest()->csrfParam, Yii::$app->getRequest()->getCsrfToken(), []); ?>
                    <div class="navigation-wrapper collapse" id="user-nav">
                        <ul class="navigation">
                            <li><a href="<?= Url::to(['site/logout']); ?>" id="logout"><i class="icon-switch2"></i> <span>Выйти</span></a></li>
                        </ul>
                    </div>
                </div>
                <!-- /user menu -->


                <!-- Main navigation -->
                <div class="sidebar-category sidebar-category-visible">
                    <div class="category-content no-padding">

                        <ul class="navigation navigation-main navigation-accordion">

                            <li class="navigation-header"><span>Меню</span> <i class="icon-menu" title="" data-original-title=""></i></li>

                    <?php
                    if(Yii::$app->user->can('grant-permission-to-dealer')) {
                    ?>
                        <!-- Add categories -->
                        <li>
                            <a href="#"><i class="icon-warning22" title="Доступы"></i> <span>Доступы</span></a>
                            <ul>
                                <li><a href="<?= Url::to(['administrator/dealer-permissions']); ?>">Доступы дилеров</a></li>
                                <li><a href="<?= Url::to(['administrator/seller-permissions']); ?>">Достуры продавцов</a></li>
                            </ul>
                        </li>
                        <!-- /add categories -->
                    <?php
                    }
                    ?>

                    <?php
                    if(Yii::$app->user->can('edit-options')) {
                    ?>
                        <!-- Add slides -->
                        <li>
                            <a href="#"><i class="icon-cog" title="Общие настройки"></i> <span>Общие настройки</span></a>
                            <ul>
                                <li><a href="<?= Url::to(['administrator/slider']); ?>">Банера</a></li>
                                <li><a href="<?= Url::to(['administrator/cities']); ?>">Города</a></li>
                            </ul>
                        </li>
                        <!-- /add slides -->
                    <?php
                    }
                    ?>

                    <?php
                    if(Yii::$app->user->can('add-category')) {
                    ?>
                        <!-- Add categories -->
                        <li>
                            <a href="#"><i class="icon-list" title="Категории"></i> <span>Категории</span></a>
                            <ul>
                                <li><a href="<?= Url::to(['administrator/categories-list']); ?>">Список категорий</a></li>
                            </ul>
                        </li>
                        <!-- /add categories -->
                    <?php
                    }
                    ?>

                    <?php
                    if(Yii::$app->user->can('add-dealer') && Yii::$app->user->can('edit-dealer')) {
                    ?>

                            <!-- Admin -->
                            <li>
                                <a href="#"><i class="icon-users" title="Дилеры"></i> <span>Дилеры</span></a>
                                <ul>
                                    <li><a href="<?= Url::to(['administrator/dealers-list']); ?>">Список дилеров</a></li>
                                    <li><a href="<?= Url::to(['administrator/add-dealer']); ?>">Добавить нового дилера</a></li>
                                </ul>
                            </li>
                            <!-- /admin -->

                    <?php
                    }
                    ?>

                    <?php
                    if(Yii::$app->user->can('add-seller') && Yii::$app->user->can('edit-seller')) {
                    ?>

                            <!-- Dealer -->
                            <li>
                                <a href="#"><i class="icon-vcard" title="Продавцы"></i> <span>Продавцы</span></a>
                                <ul>
                                    <li><a href="<?= Url::to(['dealer/sellers-list']); ?>">Список продавцов</a></li>
                                    <li><a href="<?= Url::to(['dealer/add-seller']); ?>">Добавить продавца</a></li>
                                </ul>
                            </li>
                            <!-- /dealer -->

                    <?php
                    }
                    ?>

                    <?php
                    if(Yii::$app->user->can('add-product') && Yii::$app->user->can('edit-product')) {
                    ?>

                            <!-- Seller -->
                            <li>
                                <a href="#"><i class="icon-cart2" title="Товары"></i> <span>Товары</span></a>
                                <ul>
                                    <li><a href="<?= Url::to(['seller/products-list']); ?>">Список товаров</a></li>
                                    <li><a href="<?= Url::to(['seller/add-product']); ?>">Добавить новый товар</a></li>
                                    <li><a href="<?= Url::to(['seller/add-by-excel']); ?>">Добавить товары через Excel</a></li>
                                </ul>
                            </li>
                            <!-- /seller -->

                    <?php
                    }
                    ?>
                            <li>
                                <a href="#"><i class="icon-stats-dots" title="Статистика"></i>
                                    <span>Статистика</span></a>
                                <ul>
                                    <li><a href="#">...</a></li>
                                    <li><a href="#">...</a></li>
                                    <li><a href="#">...</a></li>
                                </ul>
                            </li>

                        </ul>

                    </div>
                </div>
                <!-- /main navigation -->

            </div>
        </div>
        <!-- /main sidebar -->

        <!-- Main content -->
        <div class="content-wrapper">
            <!-- Page header -->
            <div class="page-header page-header-default">
                <div class="page-header-content">
                    <div class="page-title">
                        <h4><?= $this->title; ?></h4>
                    </div>

                    <div class="heading-elements">
                        <div class="heading-btn-group">

                        </div>
                    </div>
                </div>

                <div class="breadcrumb-line">
                    <ul class="breadcrumb">

                    </ul>

                    <ul class="breadcrumb-elements">

                    </ul>
                </div>
            </div>
            <!-- /page header -->


            <!-- Content area -->
            <div class="content">

                <?= $content ?>

                <!-- Footer -->
                <div class="footer text-muted">
                    &copy;<?= date("Y"); ?>. <a href="http://maint.kz">Создано компанией Maint</a>
                </div>
                <!-- /footer -->

            </div>
            <!-- /content area -->
        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

</div>
<!-- /page container -->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
