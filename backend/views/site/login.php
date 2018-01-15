<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

AppAsset::register($this);

$this->title = 'Вход в админ панель';
$this->params['breadcrumbs'][] = $this->title;

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
    <!-- Global stylesheets -->

</head>
<?php $this->beginBody() ?>
<body class="login-container">

<!-- Main navbar -->
<div class="navbar navbar-inverse bg-indigo">
    <div class="navbar-header">
        <a class="navbar-brand" href="index.html"><img src="assets/images/logo_light.png" alt=""></a>

        <ul class="nav navbar-nav pull-right visible-xs-block">
            <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
        </ul>
    </div>

    <div class="navbar-collapse collapse" id="navbar-mobile">

    </div>
</div>
<!-- /main navbar -->


<!-- Page container -->
<div class="page-container">

    <!-- Page content -->
    <div class="page-content">

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Content area -->
            <div class="content">

                <!-- Simple login form -->
                <form action="<?= URL::to(['site/login']) ?>" method="POST" >

                    <!-- csrf token -->
                    <?= Html :: hiddenInput(\Yii :: $app->getRequest()->csrfParam, \Yii :: $app->getRequest()->getCsrfToken(), []); ?>
                    <input type="hidden" name="LoginForm[rememberMe]" value="0" >

                    <div class="panel panel-body login-form">
                        <div class="text-center">
                            <div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
                            <h5 class="content-group">Вход в админ панель <small class="display-block">введите логи и пароль</small></h5>
                        </div>

                        <div class="form-group has-feedback has-feedback-left">
                            <input type="text" class="form-control" name="LoginForm[username]" placeholder="Логин">
                            <div class="form-control-feedback">
                                <i class="icon-user text-muted"></i>
                            </div>
                        </div>

                        <div class="form-group has-feedback has-feedback-left">
                            <input type="password" class="form-control" name="LoginForm[password]" placeholder="Пароль">
                            <div class="form-control-feedback">
                                <i class="icon-lock2 text-muted"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn bg-pink-400 btn-block">Войти <i class="icon-circle-right2 position-right"></i></button>
                        </div>

                        <div class="text-center">
                            <a href="login_password_recover.html">Забыли пароль?</a>
                        </div>
                    </div>
                </form>
                <!-- /simple login form -->

                <!-- Footer -->
                <div class="footer text-muted text-center">
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


<!--<div class="site-login">-->
<!--    <h1>--><?//= Html::encode($this->title) ?><!--</h1>-->
<!---->
<!--    <p>Please fill out the following fields to login:</p>-->
<!---->
<!--    <div class="row">-->
<!--        <div class="col-lg-5">-->
<!--            --><?php //$form = ActiveForm::begin(['id' => 'login-form']); ?>
<!---->
<!--                --><?//= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
<!---->
<!--                --><?//= $form->field($model, 'password')->passwordInput() ?>
<!---->
<!--                --><?//= $form->field($model, 'rememberMe')->checkbox() ?>
<!---->
<!--                <div class="form-group">-->
<!--                    --><?//= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
<!--                </div>-->
<!---->
<!--            --><?php //ActiveForm::end(); ?>
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
