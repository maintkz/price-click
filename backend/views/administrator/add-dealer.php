<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->registerJsFile( '@web/material/js/plugins/forms/selects/bootstrap_multiselect.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/forms/inputs/touchspin.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/forms/selects/select2.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/forms/styling/switch.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/forms/styling/switchery.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/forms/styling/uniform.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/notifications/sweet_alert.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/js/add-dealer.js', ['depends' => [\yii\web\JqueryAsset::className()]] );

?>

<!-- Form validation -->
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Добавление нового дилера</h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
                <li><a data-action="reload"></a></li>
                <li><a data-action="close"></a></li>
            </ul>
        </div>
    </div>

    <div class="panel-body">

        <?php
            if(isset($success) && $success) {
        ?>
                <div class="alert alert-success no-border">
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                    <span class="text-semibold">Дилер успешно добавлен.</span> <a href="#" class="alert-link">Посмотреть</a>.
                </div>
        <?php
            } elseif(isset($error) && !$success) {
        ?>
                <div class="alert alert-danger no-border">
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                    <span class="text-semibold">При добавлении дилера произошла ошибка</span>. Попробуйте еще раз.
                </div>
        <?php
            }
        ?>

        <p class="content-group-lg">Добавьте нового дилера заполнив следующие данные.</p>
        <form id="add-dealer-form" class="form-horizontal" method="POST" action="<?= URL::to(['administrator/add-dealer']) ?>" >
            <fieldset class="content-group">

                <!-- csrf token -->
                <?= Html :: hiddenInput(\Yii::$app->getRequest()->csrfParam, \Yii::$app->getRequest()->getCsrfToken(), []); ?>

                <!-- Basic text input -->
                <div class="form-group">
                    <label class="control-label col-lg-3">Логин <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input type="text" name="SignupForm[username]" class="form-control" required="required" placeholder="Введите логин">
                    </div>
                </div>
                <!-- /basic text input -->

                <!-- Email field -->
                <div class="form-group">
                    <label class="control-label col-lg-3">Email адрес <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input type="email" name="SignupForm[email]" class="form-control" id="email" required="required" placeholder="Введите email">
                    </div>
                </div>
                <!-- /email field -->

                <!-- Password field -->
                <div class="form-group">
                    <label class="control-label col-lg-3">Пароль <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input type="password" name="SignupForm[password]" id="password" class="form-control" required="required" placeholder="Минимум 6 символов">
                    </div>
                </div>
                <!-- /password field -->

                <!-- Basic text input -->
                <div class="form-group">
                    <label class="control-label col-lg-3">Адрес<span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input type="text" name="DealersInfo[address]" class="form-control" required="required" placeholder="Введите адрес">
                    </div>
                </div>
                <!-- /basic text input -->

                <!-- Basic text input -->
                <div class="form-group">
                    <label class="control-label col-lg-3">Телефон<span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input type="text" name="DealersInfo[phone]" class="form-control" required="required" placeholder="Введите телефон">
                    </div>
                </div>
                <!-- /basic text input -->

                <!-- Basic text input -->
                <div class="form-group">
                    <label class="control-label col-lg-3">Описание<span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <textarea rows="5" cols="5" name="DealersInfo[description]" class="form-control" placeholder="Введите описание"></textarea>
                    </div>
                </div>
                <!-- /basic text input -->

            </fieldset>

            <div class="text-right">
                <button type="reset" class="btn btn-default" id="reset">Очистить форму <i class="icon-reload-alt position-right"></i></button>
                <button id="add-dealer-submit" type="submit" class="btn btn-primary">Добавить<i class="icon-arrow-right14 position-right"></i></button>
            </div>
        </form>
    </div>
</div>
<!-- /form validation -->
