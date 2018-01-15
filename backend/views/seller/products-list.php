<?php

use yii\helpers\Url;
use yii\helpers\Html;

// required js files
$this->registerJsFile( '@web/material/js/plugins/tables/datatables/datatables.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/tables/datatables/extensions/responsive.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/forms/selects/select2.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/tables/datatables/datatables.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );

// required js files
$this->registerJsFile( '@web/material/js/plugins/forms/validation/validate.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/forms/selects/bootstrap_multiselect.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/forms/inputs/touchspin.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/forms/styling/switch.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/forms/styling/switchery.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/forms/styling/uniform.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/uploaders/fileinput.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/forms/selects/bootstrap_select.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/pickers/color/spectrum.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/notifications/sweet_alert.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );

// custom js file for this page
$this->registerJsFile( '@web/js/products-list.js', ['depends' => [\yii\web\JqueryAsset::className()]] );

// title
$this->title = "Список всех товаров";
?>

<!-- Form validation -->
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title"><?= $this->title ?></h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
                <li><a data-action="reload"></a></li>
                <li><a data-action="close"></a></li>
            </ul>
        </div>
    </div>

    <div class="panel-body">

        <table class="table products-list-datatable">
            <thead>
            <tr>
                <th>Подкатегория</th>
                <th>Наименование</th>
                <th>цена</th>
                <th>Количество</th>
                <th>Статус</th>
                <th>Действие</th>
            </tr>
            </thead>
        </table>

    </div>


    <!-- Edit modal -->
    <div id="modal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h6 class="modal-title">Информация о продукте</h6>
                </div>

                <div class="modal-body">

                    <p class="content-group-lg">Добавьте новый товар заполнив следующие поля.</p>
                    <form class="form-horizontal form-validate-jquery" id="add-product-form" method="POST" action="<?= URL::to(['apartments/add']) ?>" enctype="multipart/form-data">
                        <fieldset class="content-group">

                            <!-- csrf token -->
                            <?= Html :: hiddenInput(\Yii :: $app->getRequest()->csrfParam, \Yii :: $app->getRequest()->getCsrfToken(), []); ?>

                            <!-- Section -->
                            <div class="form-group">
                                <label class="control-label col-lg-3">Раздел</label>
                                <div class="col-lg-9">
                                    <div class="input-group" style="width:100%">
                                        <select id="product-section" name="ProductsList[section_id]" class="bootstrap-select" data-width="100%">
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
                                        <select id="product-category" name="ProductsList[category_id]" class="bootstrap-select" data-width="100%">
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
                                        <select id="product-subcategory"  name="ProductsList[subcategory_id]" class="bootstrap-select" data-width="100%">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- /Subcategory -->

                            <!-- Product name -->
                            <div class="form-group">
                                <label class="control-label col-lg-3">Наименование <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input type="text" name="Products[product_name]" class="form-control" required="required" placeholder="Наименование товара">
                                </div>
                            </div>
                            <!-- /Product name -->

                            <!-- Product description -->
                            <div class="form-group">
                                <label class="control-label col-lg-3">Описание товара</label>
                                <div class="col-lg-9">
                                    <textarea rows="5" cols="5" name="Products[product_description]" class="form-control" placeholder="Описание товара"></textarea>
                                </div>
                            </div>
                            <!-- /Product description -->

                            <!-- Parameters -->
                            <div class="form-group">
                                <label class="control-label col-lg-3">Добавить параметр</label>
                                <div class="col-lg-9">
                                    <div class="input-group">
                                        <select id="add-parameter-select" class="bootstrap-select" data-width="100%">
                                            <option value="color">Цвет</option>
                                            <option value="size">Размер</option>
                                            <option value="custom">Свой</option>
                                        </select>
                                        <span class="input-group-btn">
                                <button id="add-parameter-button" class="btn btn-primary" type="button">+</button>
                            </span>
                                    </div>
                                </div>
                            </div>
                            <!-- /Parameters -->

                            <div id="parameter-insert-helper"></div>

                            <!-- Product price -->
                            <div class="form-group">
                                <label class="control-label col-lg-3">Цена <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input type="text" name="Products[product_price]" class="form-control" required="required" placeholder="цена">
                                </div>
                            </div>
                            <!-- /Product price -->

                            <!-- Digits only -->
                            <div class="form-group">
                                <label class="control-label col-lg-3">Количество <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input type="text" name="ProductsList[product_list_count]" class="form-control" required="required" placeholder="количество">
                                </div>
                            </div>
                            <!-- /product price -->

                        </fieldset>

                        <div class="text-right">
                            <button type="reset" class="btn btn-default" id="reset">Очистить форму<i class="icon-reload-alt position-right"></i></button>
                            <button id="apartment-submit" type="submit" class="btn btn-primary">Добавить<i class="icon-arrow-right14 position-right"></i></button>
                        </div>
                    </form>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /edit modal -->

</div>
<!-- /form validation -->
