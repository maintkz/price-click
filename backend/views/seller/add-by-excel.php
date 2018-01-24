<?php

use yii\helpers\Html;
use yii\helpers\Url;

// required js files
$this->registerJsFile( '@web/material/js/plugins/forms/validation/validate.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/forms/selects/bootstrap_multiselect.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/forms/selects/select2.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/uploaders/fileinput.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/forms/selects/bootstrap_select.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/notifications/sweet_alert.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );

// custom js file for this page
$this->registerJsFile( '@web/js/add-by-excel.js', ['depends' => [\yii\web\JqueryAsset::className()]] );

$this->title = "Добавление товаров через Excel";
?>
<!-- Form validation -->
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Добавление нового товара</h5>
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
        if ($error) {
        ?>
            <div class="alert alert-danger no-border">
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                <span class="text-semibold"><?= print_r($message); ?></span>.
            </div>
        <?php
        }
        ?>

        <?php
        if ($success) {
            ?>
            <div class="alert alert-success no-border">
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                <span class="text-semibold"><?= $message; ?>.</span>
            </div>
            <?php
        }
        ?>

        <p class="content-group-lg">Добавьте новый товар заполнив следующие поля.</p>
        <form class="form-horizontal form-validate-jquery" id="add-product-form" method="POST" action="<?= Url::to(['seller/add-by-excel']); ?>" enctype="multipart/form-data">
            <fieldset class="content-group">

                <!-- csrf token -->
                <?= Html :: hiddenInput(\Yii::$app->getRequest()->csrfParam, \Yii::$app->getRequest()->getCsrfToken(), []); ?>

                <!-- Section -->
                <div class="form-group">
                    <label class="control-label col-lg-3">Раздел</label>
                    <div class="col-lg-9">
                        <div class="input-group" style="width:100%">
                            <select id="product-section" name="section_id" class="bootstrap-select" data-width="100%">
                            </select>
                        </div>
                    </div>
                </div>
                <!-- /Section -->

                <!-- Category -->
                <div class="form-group">
                    <label class="control-label col-lg-3">Категория</label>
                    <div class="col-lg-9">
                        <div class="input-group" style="width:100%">
                            <select id="product-category" name="category_id" class="bootstrap-select" data-width="100%">
                            </select>
                        </div>
                    </div>
                </div>
                <!-- /Category -->

                <!-- Subcategory -->
                <div class="form-group">
                    <label class="control-label col-lg-3">Подкатегория</label>
                    <div class="col-lg-9">
                        <div class="input-group" style="width:100%">
                            <select id="product-subcategory"  name="subcategory_id" class="bootstrap-select" data-width="100%">
                            </select>
                        </div>
                    </div>
                </div>
                <!-- /Subcategory -->

                <!-- Загрузка файлов -->
                <div class="form-group">
                    <label class="col-lg-3 control-label text-semibold">Загрузите Excel файл:</label>
                    <div class="col-lg-9">
                        <input type="file" name="excel" class="file-input">
                    </div>
                </div>
                <!-- /Загрузка файлов -->

            </fieldset>

            <div class="text-right">
                <button type="reset" class="btn btn-default" id="reset">Очистить форму<i class="icon-reload-alt position-right"></i></button>
                <button id="apartment-submit" type="submit" class="btn btn-primary">Добавить<i class="icon-arrow-right14 position-right"></i></button>
            </div>
        </form>
    </div>

</div>
<!-- /form validation -->
