<?php

use yii\helpers\Html;

$this->registerJsFile( '@web/material/js/plugins/notifications/sweet_alert.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/forms/selects/bootstrap_select.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );

$this->registerJsFile( '@web/js/add-seller.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
?>

<!-- Form validation -->
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Добавление нового продавца</h5>
    </div>

    <div class="panel-body">

        <p class="content-group-lg">Добавьте нового продавца заполнив следующие данные.</p>
        <form id="add-seller-form" class="form-horizontal" method="POST" action="" >
            <fieldset class="content-group">

                <!-- csrf token -->
                <?= Html :: hiddenInput(\Yii :: $app->getRequest()->csrfParam, \Yii :: $app->getRequest()->getCsrfToken(), []); ?>

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
                        <input type="password" name="SignupForm[password]" id="password" class="form-control" required="required" placeholder="Минимум 5 символов">
                    </div>
                </div>
                <!-- /password field -->

                <!-- City -->
                <div class="form-group">
                    <label class="control-label col-lg-3">Город<span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <div class="input-group">
                            <select name="AuthAssignment[city_id]" id="cities" class="bootstrap-select" data-width="100%">
<!--                                <option value="color">Цвет</option>-->
<!--                                <option value="size">Размер</option>-->
<!--                                <option value="custom">Свой</option>-->
                            </select>
                        </div>
                    </div>
                </div>
                <!-- /City -->

                <!-- Address input -->
                <div class="form-group">
                    <label class="control-label col-lg-3">Адрес<span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input type="text" name="SellersInfo[address]" class="form-control" placeholder="Введите адрес">
                    </div>
                </div>
                <!-- /address input -->

                <!-- Phone input -->
                <div class="form-group">
                    <label class="control-label col-lg-3">Телефон<span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input type="text" name="SellersInfo[phone]" class="form-control" placeholder="Введите телефон">
                    </div>
                </div>
                <!-- /phone input -->

                <!-- Description input -->
                <div class="form-group">
                    <label class="control-label col-lg-3">Описание</label>
                    <div class="col-lg-9">
                        <textarea rows="5" cols="5" name="SellersInfo[description]" class="form-control" placeholder="Введите описание"></textarea>
                    </div>
                </div>
                <!-- /description input -->

                <!-- Income percent input -->
                <div class="form-group">
                    <label class="control-label col-lg-3">Процент монетизации<span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input type="text" name="SellersInfo[income_percent]" class="form-control" placeholder="Процент монетизации">
                    </div>
                </div>
                <!-- /income percent input -->

                <!-- Income percent input -->
                <div class="form-group">
                    <label class="control-label col-lg-3">Ответственное лицо<span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input type="text" name="SellersInfo[responsible]" class="form-control" required="required" placeholder="Ответственное лицо">
                    </div>
                </div>
                <!-- /income percent input -->

            </fieldset>

            <div class="text-right">
                <button id="add-seller-button" type="submit" class="btn btn-primary">Добавить<i class="icon-arrow-right14 position-right"></i></button>
            </div>
        </form>
    </div>
</div>
<!-- /form validation -->
