<?php

use yii\helpers\Url;
use yii\helpers\Html;

// required js files
$this->registerJsFile( '@web/material/js/plugins/forms/styling/uniform.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/uploaders/fileinput.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/notifications/sweet_alert.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );

// custom js file for this page
$this->registerJsFile( '@web/js/add-shop.js', ['depends' => [\yii\web\JqueryAsset::className()]] );

// title
$this->title = "Добавление магазина";
?>

<!-- Form validation -->
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Добавление магазина</h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
                <li><a data-action="reload"></a></li>
                <li><a data-action="close"></a></li>
            </ul>
        </div>
    </div>

    <div class="panel-body">
        <p class="content-group-lg">Заполните информацию о магазине.</p>
        <form class="form-horizontal" id="add-shop-form" method="POST" action="" enctype="multipart/form-data">
            <fieldset class="content-group">

                <!-- csrf token -->
                <?= Html :: hiddenInput(Yii::$app->getRequest()->csrfParam, Yii::$app->getRequest()->getCsrfToken(), []); ?>

                <!-- Shop name -->
                <div class="form-group">
                    <label class="control-label col-lg-3">Наименование <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input type="text" name="Shops[shop_name]" class="form-control" required="required" placeholder="Наименование магазина">
                    </div>
                </div>
                <!-- /shop name -->

                <!-- Shop min price -->
                <div class="form-group">
                    <label class="control-label col-lg-3">Минимальная сумма заказа <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input type="text" name="Shops[shop_min_price]" class="form-control" required="required" placeholder="Минимальная сумма заказа">
                    </div>
                </div>
                <!-- /shop min price -->

                <!-- Shop delivery price -->
                <div class="form-group">
                    <label class="control-label col-lg-3">Цена доставки <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input type="text" name="Shops[shop_delivery_price]" class="form-control" required="required" placeholder="Цена доставки">
                    </div>
                </div>
                <!-- /shop delivery price -->

                <!-- Shop open name -->
                <div class="form-group">
                    <label class="control-label col-lg-3">Время открытия магазина <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input type="text" name="Shops[shop_open_time]" class="form-control" required="required" placeholder="09:00:00">
                    </div>
                </div>
                <!-- /shop open name -->

                <!-- Shop close name -->
                <div class="form-group">
                    <label class="control-label col-lg-3">Время закрытия магазина <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input type="text" name="Shops[shop_close_time]" class="form-control" required="required" placeholder="18:00:00">
                    </div>
                </div>
                <!-- /shop close name -->

                <!-- Product contacts -->
                <div class="form-group">
                    <label class="control-label col-lg-3">Контакты</label>
                    <div class="col-lg-9">
                        <textarea rows="5" cols="5" name="Shops[shop_contacts]" class="form-control" placeholder="Контакты. тел: 8 707 777 7777"></textarea>
                    </div>
                </div>
                <!-- /Product contacts -->

                <!-- Product description -->
                <div class="form-group">
                    <label class="control-label col-lg-3">Описание товара</label>
                    <div class="col-lg-9">
                        <textarea rows="5" cols="5" name="Shops[shop_description]" class="form-control" placeholder="Описание товара"></textarea>
                    </div>
                </div>
                <!-- /Product description -->

                <!-- Загрузка файлов -->
                <div class="form-group">
                    <label class="col-lg-3 control-label text-semibold">Картинки:</label>
                    <div class="col-lg-9">
                        <input type="file" name="Shops[image]" class="file-input">
                        <span class="help-block">Загрузите картинку.</span>
                    </div>
                </div>
                <!-- /Загрузка файлов -->

            </fieldset>

            <div class="text-right">
                <button id="add-shop-button" type="submit" class="btn btn-primary">Добавить<i class="icon-arrow-right14 position-right"></i></button>
            </div>
        </form>
    </div>

</div>
<!-- /form validation -->
