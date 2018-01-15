<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->registerJsFile( '@web/material/js/plugins/forms/inputs/touchspin.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/forms/selects/select2.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/forms/styling/switch.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/forms/styling/switchery.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/forms/styling/uniform.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/notifications/sweet_alert.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/js/edit-seller.js', ['depends' => [\yii\web\JqueryAsset::className()]] );

$this->title = "Редактирование данных дилера";
?>

<!-- csrf token -->
<?= Html :: hiddenInput(\Yii::$app->getRequest()->csrfParam, \Yii::$app->getRequest()->getCsrfToken(), []); ?>
<input type="hidden" name="user_id"  id="user_id" value="<?= $seller->id; ?>" />

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h5 class="panel-title">Изменить логин</h5>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                        <li><a data-action="reload"></a></li>
                        <li><a data-action="close"></a></li>
                    </ul>
                </div>
            </div>

            <div class="panel-body">

                <form class="form-horizontal form-validate-jquery" method="POST" action="" >
                    <fieldset class="content-group">

                        <!-- Basic text input -->
                        <div class="form-group">
                            <label class="control-label col-lg-3">Логин <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input id="username" type="text" name="username" class="form-control" required="required" value="<?= $seller->username ?>" placeholder="Введите логин">
                            </div>
                        </div>
                        <!-- /basic text input -->

                        <div class="text-right">
                            <button id="edit-username-button" type="submit" class="btn btn-primary">Изменить<i class="icon-arrow-right14 position-right"></i></button>
                        </div>

                    </fieldset>

                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h5 class="panel-title">Изменить email</h5>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                        <li><a data-action="reload"></a></li>
                        <li><a data-action="close"></a></li>
                    </ul>
                </div>
            </div>

            <div class="panel-body">

                <form class="form-horizontal form-validate-jquery" method="POST" action="" >
                    <fieldset class="content-group">

                        <!-- Email field -->
                        <div class="form-group">
                            <label class="control-label col-lg-3">Email адрес <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input type="email" name="email" class="form-control" id="email" required="required" value="<?= $seller->email ?>" placeholder="Введите email">
                            </div>
                        </div>
                        <!-- /email field -->

                        <div class="text-right">
                            <button id="edit-email-button" type="submit" class="btn btn-primary">Изменить<i class="icon-arrow-right14 position-right"></i></button>
                        </div>

                    </fieldset>

                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h5 class="panel-title">Изменить пароль</h5>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                        <li><a data-action="reload"></a></li>
                        <li><a data-action="close"></a></li>
                    </ul>
                </div>
            </div>

            <div class="panel-body">

                <form class="form-horizontal form-validate-jquery" method="POST" action="" >
                    <fieldset class="content-group">

                        <!-- Password field -->
                        <div class="form-group">
                            <label class="control-label col-lg-3">Пароль <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input type="password" name="password" id="password" class="form-control" required="required" placeholder="Минимум 6 символов">
                            </div>
                        </div>
                        <!-- /password field -->

                        <div class="text-right">
                            <button id="edit-password-button" type="submit" class="btn btn-primary">Изменить<i class="icon-arrow-right14 position-right"></i></button>
                        </div>

                    </fieldset>

                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <!-- Form validation -->
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h5 class="panel-title">Изменить статус</h5>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                        <li><a data-action="reload"></a></li>
                        <li><a data-action="close"></a></li>
                    </ul>
                </div>
            </div>

            <div class="panel-body">

                <form class="form-horizontal form-validate-jquery" method="POST" action="" >
                    <fieldset class="content-group">

                        <div class="checkbox checkbox-switchery">
                            <label>
                                <input id="status" type="checkbox" class="switchery" <?php if($seller->status) echo "checked"; ?> data-on-text="Активный" data-off-text="Неактивный"  >
                                Статус
                            </label>
                        </div>

                        <div class="text-right">
                            <button id="edit-status-button" type="submit" class="btn btn-primary">Изменить<i class="icon-arrow-right14 position-right"></i></button>
                        </div>

                    </fieldset>

                </form>
            </div>
        </div>
    </div>
</div>